<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHandler;
use App\Helpers\TableQuery;
use App\Helpers\TableSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

class DynamicController extends Controller
{
  /**
   * Define the list of allowed table names and their corresponding primary key columns.
   * Format: 'table_name' => 'primary_key_column_name'
   * Be VERY specific and careful about which tables you allow modification on.
   */
  private $allowedTables = [
    'adultmaleequivalent' => 'AMEID',
    'age' => 'AgeID', // Assuming 'age' table uses 'AgeID'
    'brand' => 'BrandID',
    'company' => 'CompanyID',
    'consumption' => 'ConsumptionID',
    'country' => 'CountryID',
    'distribution' => 'DistributionID',
    'distributionchannel' => 'DistributionChannelID',
    'entity' => 'EntityID',
    'extractionconversion' => 'ExtractionID',
    'foodtype' => 'FoodTypeID',
    'foodvehicle' => 'VehicleID',
    'gender' => 'GenderID',
    'geographylevel1' => 'GL1ID',
    'geographylevel2' => 'GL2ID',
    'geographylevel3' => 'GL3ID',
    'individualconsumption' => 'ConsumptionID',
    'measurecurrency' => 'MCID',
    'measureunit1' => 'UCID',
    'packagingtype' => 'PackagingTypeID',
    'processingstage' => 'PSID',
    'producerprocessor' => 'ProducerProcessorID',
    'producerreference' => 'ProducerReferenceID',
    'producersku' => 'SKUID',
    'product' => 'ProductID',
    'reference' => 'ReferenceID',
    'subdistributionchannel' => 'SubDistributionChannelID',
    'supply' => 'SupplyID',
    'yeartype' => 'YearTypeID',
  ];

  /**
   * Helper function to get the primary key name for a table.
   *
   * @param string $tableName
   * @return string|null Returns the primary key name or null if table not allowed.
   */
  private function getPrimaryKeyName(string $tableName): ?string
  {
    return $this->allowedTables[$tableName] ?? null;
  }

  /**
   * Helper function to validate table access and primary key existence.
   *
   * @param string $tableName
   * @param string|null &$primaryKeyName (Output parameter)
   * @return \Illuminate\Http\JsonResponse|null Returns error response if validation fails, null otherwise.
   */
  private function validateTableAccess(string $tableName, ?string &$primaryKeyName)
  {
    $primaryKeyName = $this->getPrimaryKeyName($tableName);

    if (!$primaryKeyName) {
      return ResponseHandler::error(message: "Access to table '{$tableName}' is forbidden or not configured.", status: 403);
    }

    if (!Schema::hasTable($tableName)) {
      return ResponseHandler::error(message: "Table '{$tableName}' not found.", status: 404);
    }

    // Check if the table has the configured primary key column
    if (!Schema::hasColumn($tableName, $primaryKeyName)) {
      return ResponseHandler::error(message: "Table '{$tableName}' does not have the configured primary key column '{$primaryKeyName}'. Dynamic operations not supported.", status: 400);
    }

    return null;
  }

  /**
   * Get paginated data from a specified table.
   */
  public function getByTableName(Request $request, $tableName)
  {
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    // --- Custom Pagination Logic ---
    $currentPage = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 15);
    $offset = ($currentPage - 1) * $perPage;

    try {
      // Use a subquery for pagination to correctly count total items
      // This is generally more robust than counting separately
      $query = DB::table($tableName)
        ->select(DB::raw("{$tableName}.{$primaryKeyName} as id, {$tableName}.*"))
        ->orderBy($primaryKeyName, 'asc');


      $totalItems = DB::table($tableName)->count();
      $items = $query->offset($offset)
        ->limit($perPage)
        ->get();

      $paginatedData = new LengthAwarePaginator(
        $items,
        $totalItems,
        $perPage,
        $currentPage,
        [
          'path' => $request->url(),
          'query' => $request->query(),
        ]
      );

      // *** Add the schema information HERE ***
      // Convert the paginator to an array first for more reliable structure
      $responseData = $paginatedData->toArray();
      // Add the schema to this array
      // $responseData['schema'] = TableSchema::getSchemaByTableName($tableName);

      // *** Cache the schema information HERE ***
      $cacheKey = "schema:{$tableName}";
      // Cache for 24 hours (adjust duration as needed)
      $cacheDuration = 60 * 60 * 24; // seconds

      $responseData['schema'] = Cache::remember($cacheKey, $cacheDuration, function () use ($tableName) {
        // This closure only runs if the schema isn't found in the cache
        return TableSchema::getSchemaByTableName($tableName);
      });

      return ResponseHandler::success(data: $responseData);
    } catch (QueryException $e) {
      return ResponseHandler::error(message: "Database error fetching data: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  public function getByTableNameWithRelations(Request $request, $tableName)
  {
    // return ResponseHandler::success(data: TableQuery::getVehicleList());
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    // --- Custom Pagination Logic ---
    $currentPage = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 15);
    $offset = ($currentPage - 1) * $perPage;

    try {
      // Use a subquery for pagination to correctly count total items
      // This is generally more robust than counting separately
      $query = TableQuery::getTableQuery($tableName);

      if ($query == null) {
        return ResponseHandler::error(message: "An unexpected error occurred");
      }

      $totalItems = DB::table($tableName)->count();
      $items = $query->offset($offset)
        ->limit($perPage)
        ->get();

      $paginatedData = new LengthAwarePaginator(
        $items,
        $totalItems,
        $perPage,
        $currentPage,
        [
          'path' => $request->url(),
          'query' => $request->query(),
        ]
      );

      // *** Add the schema information HERE ***
      // Convert the paginator to an array first for more reliable structure
      $responseData = $paginatedData->toArray();
      // Add the schema to this array
      // $responseData['schema'] = TableSchema::getSchemaByTableName($tableName);

      // *** Cache the schema information HERE ***
      $cacheKey = "schema:{$tableName}";
      // Cache for 24 hours (adjust duration as needed)
      $cacheDuration = 60 * 60 * 24; // seconds

      $responseData['schema'] = Cache::remember($cacheKey, $cacheDuration, function () use ($tableName) {
        // This closure only runs if the schema isn't found in the cache
        return TableSchema::getSchemaByTableName($tableName);
      });

      return ResponseHandler::success(data: $responseData);
    } catch (QueryException $e) {
      return ResponseHandler::error(message: "Database error fetching data: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  /**
   * Store a new record in the specified table.
   */
  public function store(Request $request, $tableName)
  {
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    try {
      $columns = Schema::getColumnListing($tableName);

      // Filter request data, excluding the determined primary key
      $validData = Arr::only($request->all(), Arr::except($columns, [$primaryKeyName]));

      // Basic check if any valid data was provided after filtering
      if (empty($validData)) {
        return ResponseHandler::error(message: 'No valid data provided for insertion.', status: 400);
      }

      $id = DB::table($tableName)->insertGetId($validData, $primaryKeyName);

      // Fetch the newly created record using the correct primary key column
      $newItem = DB::table($tableName)
        ->select(DB::raw("{$tableName}.{$primaryKeyName} as id, {$tableName}.*"))
        ->where($primaryKeyName, $id)->first();

      Cache::forget("schema:{$tableName}");
      Cache::forget("getList:{$tableName}");

      return ResponseHandler::success(data: $newItem, message: "Record created successfully in '{$tableName}'.", status: 201);
    } catch (QueryException $e) {
      return ResponseHandler::error(message: "Database error during insert: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  /**
   * Update an existing record in the specified table by its primary key value.
   */
  public function update(Request $request, $tableName, $id) // $id here is the *value* of the primary key
  {
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    try {
      // Check if the record exists using the correct primary key column
      $existingItem = DB::table($tableName)->where($primaryKeyName, $id)->first();
      if (!$existingItem) {
        return ResponseHandler::error(message: "Record with {$primaryKeyName} = {$id} not found in table '{$tableName}'.", status: 404);
      }

      $columns = Schema::getColumnListing($tableName);
      // Filter request data, excluding the primary key
      $validData = Arr::only($request->all(), Arr::except($columns, [$primaryKeyName]));

      if (empty($validData)) {
        return ResponseHandler::error(message: 'No valid data provided for update.', status: 400);
      }

      // Update the record using the correct primary key column
      /* $affectedRows = */
      DB::table($tableName)->where($primaryKeyName, $id)->update($validData);

      // Fetch the updated record using the correct primary key column
      $updatedItem = DB::table($tableName)
        ->select(DB::raw("{$tableName}.{$primaryKeyName} as id, {$tableName}.*")) // Also alias PK here for consistency
        ->where($primaryKeyName, $id)->first();

      Cache::forget("schema:{$tableName}");
      Cache::forget("getList:{$tableName}");

      return ResponseHandler::success(data: $updatedItem, message: "Record updated successfully in '{$tableName}'.");
    } catch (QueryException $e) {
      return ResponseHandler::error(message: "Database error during update: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  /**
   * Delete a record from the specified table by its primary key value.
   */
  public function deleteById(Request $request, $tableName, $id) // $id here is the *value* of the primary key
  {
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    try {
      // Check if the record exists using the correct primary key column
      $existingItem = DB::table($tableName)->where($primaryKeyName, $id)->first();
      if (!$existingItem) {
        return ResponseHandler::error(message: "Record with {$primaryKeyName} = {$id} not found in table '{$tableName}'.", status: 404);
      }

      // Delete the record using the correct primary key column
      $deleted = DB::table($tableName)->where($primaryKeyName, $id)->delete();

      if ($deleted) {
        Cache::forget("schema:{$tableName}");
        Cache::forget("getList:{$tableName}");
        // Use $primaryKeyName in the success message for clarity
        return ResponseHandler::success(message: "Record with {$primaryKeyName} = {$id} deleted successfully from '{$tableName}'.");
      } else {
        return ResponseHandler::error(message: "Failed to delete record with {$primaryKeyName} = {$id} from '{$tableName}'.", status: 500);
      }
    } catch (QueryException $e) {
      // Catch potential foreign key constraint issues, etc.
      return ResponseHandler::error(message: "Database error: Could not delete record (maybe referenced by other data). Details: " . $e->getMessage(), status: 409); // 409 Conflict
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  public function show($tableName, $id)
  {
    if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
      return $error;
    }

    try {
      // Check if the record exists using the correct primary key column
      $existingItem = DB::table($tableName)->where($primaryKeyName, $id)->first();
      if (!$existingItem) {
        return ResponseHandler::error(message: "Record with {$primaryKeyName} = {$id} not found in table '{$tableName}'.", status: 404);
      }

      return ResponseHandler::success(data: $existingItem);
    } catch (QueryException $e) {
      // Catch potential foreign key constraint issues, etc.
      return ResponseHandler::error(message: "Database error: Could not delete record (maybe referenced by other data). Details: " . $e->getMessage(), status: 409); // 409 Conflict
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  // public function getTableSchema(Request $request, $tableName)
  // {
  //   // Validation doesn't strictly need the primary key for GET, but we'll run it for consistency
  //   // and to ensure the table is allowed and exists.
  //   if ($error = $this->validateTableAccess($tableName, $primaryKeyName)) {
  //     // We don't actually *use* $primaryKeyName here, but the validation ensures the table is valid.
  //     return $error;
  //   }

  //   try {

  //     return ResponseHandler::success(data: TableSchema::getSchemaByTableName($tableName));
  //   } catch (\Throwable $e) {
  //     return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
  //   }
  // }
}
