<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr; // Import Arr facade
use Illuminate\Validation\ValidationException; // Import ValidationException

class DynamicController1 extends Controller
{
  // Define the list of allowed table names for CRUD operations
  // Be VERY specific and careful about which tables you allow modification on.
  private $allowedTables = [
    'age',
    'brand',
    'genders',
    'countries',
    // Add other tables you want to manage dynamically
  ];

  /**
   * Helper function to validate table access.
   *
   * @param string $tableName
   * @return \Illuminate\Http\JsonResponse|null Returns error response if validation fails, null otherwise.
   */
  private function validateTableAccess(string $tableName)
  {
    if (!in_array($tableName, $this->allowedTables)) {
      return ResponseHandler::error(message: "Access to table '{$tableName}' is forbidden.", status: 403);
    }

    if (!Schema::hasTable($tableName)) {
      return ResponseHandler::error(message: "Table '{$tableName}' not found.", status: 404);
    }

    // Check if the table has a primary key named 'id' (common convention)
    // Adjust if your primary keys have different names or are composite.
    if (!Schema::hasColumn($tableName, 'id')) {
      return ResponseHandler::error(message: "Table '{$tableName}' does not have a standard 'id' primary key column, dynamic operations not supported.", status: 400);
    }

    return null; // Validation passed
  }

  /**
   * Get paginated data from a specified table.
   */
  public function getByTableName(Request $request, $tableName)
  {
    if ($error = $this->validateTableAccess($tableName)) {
      return $error;
    }

    // --- Custom Pagination Logic ---
    $currentPage = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 15);
    $offset = ($currentPage - 1) * $perPage;

    $totalItems = DB::table($tableName)->count();
    $items = DB::table($tableName)
      ->offset($offset)
      ->limit($perPage)
      // Consider adding a default order if needed, e.g., ->orderBy('id', 'asc')
      ->get();

    $paginatedData = new LengthAwarePaginator(
      $items,
      $totalItems,
      $perPage,
      $currentPage,
      ['path' => $request->url(), 'query' => $request->query()]
    );

    return ResponseHandler::success(data: $paginatedData);
  }

  /**
   * Store a new record in the specified table.
   *
   * IMPORTANT: This implementation lacks specific validation rules per table.
   * It only inserts data for columns that actually exist in the table.
   * Consider adding more robust validation based on $tableName if needed.
   */
  public function store(Request $request, $tableName)
  {
    if ($error = $this->validateTableAccess($tableName)) {
      return $error;
    }

    try {
      // Get the list of columns for the table
      $columns = Schema::getColumnListing($tableName);

      // Filter the request data to include only keys that match column names
      // Exclude 'id' as it's usually auto-incrementing
      $validData = Arr::only($request->all(), Arr::except($columns, ['id']));

      // --- Basic Validation Example (Optional) ---
      // You might want some minimal common validation
      // if (empty($validData)) {
      //     return ResponseHandler::error(message: 'No valid data provided for insertion.', status: 400);
      // }
      // --- End Basic Validation ---

      // Insert data and get the new ID
      $id = DB::table($tableName)->insertGetId($validData);

      // Fetch the newly created record
      $newItem = DB::table($tableName)->find($id);

      return ResponseHandler::success(data: $newItem, message: "Record created successfully in '{$tableName}'.", status: 201);
    } catch (\Illuminate\Database\QueryException $e) {
      // Catch potential database errors (e.g., unique constraints, missing required fields not provided)
      return ResponseHandler::error(message: "Database error: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  /**
   * Update an existing record in the specified table by ID.
   *
   * IMPORTANT: Similar to store(), lacks specific validation rules per table.
   */
  public function update(Request $request, $tableName, $id)
  {
    if ($error = $this->validateTableAccess($tableName)) {
      return $error;
    }

    try {
      // Check if the record exists
      $existingItem = DB::table($tableName)->find($id);
      if (!$existingItem) {
        return ResponseHandler::error(message: "Record with ID {$id} not found in table '{$tableName}'.", status: 404);
      }

      // Get the list of columns for the table
      $columns = Schema::getColumnListing($tableName);

      // Filter the request data to include only keys that match column names
      // Exclude 'id' as it shouldn't be updated directly this way
      $validData = Arr::only($request->all(), Arr::except($columns, ['id']));

      // --- Basic Validation Example (Optional) ---
      if (empty($validData)) {
        return ResponseHandler::error(message: 'No valid data provided for update.', status: 400);
      }
      // --- End Basic Validation ---

      // Update the record
      $affectedRows = DB::table($tableName)->where('id', $id)->update($validData);

      // Fetch the updated record
      $updatedItem = DB::table($tableName)->find($id);

      return ResponseHandler::success(data: $updatedItem, message: "Record updated successfully in '{$tableName}'.");
    } catch (\Illuminate\Database\QueryException $e) {
      return ResponseHandler::error(message: "Database error: " . $e->getMessage(), status: 500);
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }

  /**
   * Delete a record from the specified table by ID.
   */
  public function deleteById(Request $request, $tableName, $id)
  {
    if ($error = $this->validateTableAccess($tableName)) {
      return $error;
    }

    try {
      // Check if the record exists before attempting deletion
      $existingItem = DB::table($tableName)->find($id);
      if (!$existingItem) {
        return ResponseHandler::error(message: "Record with ID {$id} not found in table '{$tableName}'.", status: 404);
      }

      // Delete the record
      $deleted = DB::table($tableName)->where('id', $id)->delete();

      if ($deleted) {
        return ResponseHandler::success(message: "Record with ID {$id} deleted successfully from '{$tableName}'.");
      } else {
        // This case might be rare if the find() check passed, but good to handle
        return ResponseHandler::error(message: "Failed to delete record with ID {$id} from '{$tableName}'.", status: 500);
      }
    } catch (\Illuminate\Database\QueryException $e) {
      // Catch potential foreign key constraint issues, etc.
      return ResponseHandler::error(message: "Database error: Could not delete record. It might be referenced by other data. (" . $e->getMessage() . ")", status: 409); // 409 Conflict is often suitable here
    } catch (\Exception $e) {
      return ResponseHandler::error(message: "An unexpected error occurred: " . $e->getMessage(), status: 500);
    }
  }
}
