<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TableQuery
{
  static public function getTableQuery(string $tableName)
  {
    switch ($tableName) {
      case 'adultmaleequivalent':
        return DB::table("adultmaleequivalent as t")
          ->join("gender as g", "t.GenderID", '=', "g.GenderID")
          ->join("age as a", "t.AgeID", '=', "a.AgeID")
          ->select("t.AMEID as id", "t.AME", "g.GenderName", "a.AgeRange")
          ->orderBy('t.AMEID', 'asc');
        break;

      case 'consumption':
        return DB::table("consumption as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("geographylevel1 as gl1", "t.GL1ID", '=', "gl1.GL1ID")
          ->join("geographylevel2 as gl2", "t.GL2ID", '=', "gl2.GL2ID")
          ->join("geographylevel3 as gl3", "t.GL3ID", '=', "gl3.GL3ID")
          ->join("gender as g", "t.GenderID", '=', "g.GenderID")
          ->join("age as a", "t.AgeID", '=', "a.AgeID")
          ->join("measureunit1 as mu", "t.UCID", '=', "mu.UCID")
          ->join("yeartype as yt", "t.YearTypeID", '=', "yt.YearTypeID")
          ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
          ->select(
            "t.ConsumptionID as id",
            "fv.VehicleName",
            "gl1.AdminLevel1",
            "gl2.AdminLevel2",
            "gl3.AdminLevel3",
            "g.GenderName",
            "a.AgeRange",
            "t.NumberOfPeople",
            "t.SourceVolume",
            "t.VolumeMTY",
            "mu.SupplyVolumeUnit",
            "yt.YearTypeName",
            "t.StartYear",
            "t.EndYear",
            "r.ReferenceNumber",
          )
          ->orderBy('t.ConsumptionID', 'asc');
        break;

      case 'distribution':
        return DB::table("distribution as t")
          ->join("distributionchannel as dc", "t.DistributionChannelID", '=', "dc.DistributionChannelID")
          ->join("subdistributionchannel as sdc", "t.SubDistributionChannelID", '=', "sdc.SubDistributionChannelID")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("country as c", "t.CountryID", '=', "c.CountryID")
          ->select(
            "t.DistributionID as id",
            "dc.DistributionChannelName",
            "sdc.SubDistributionChannelName",
            "fv.VehicleName",
            "c.CountryName",
            "t.StartYear",
            "t.DistributedVolume",
          )
          ->orderBy('t.DistributionID', 'asc');
        break;

      case 'entity':
        return DB::table("entity as t")
          ->join("company as co", "t.CompanyID", '=', "co.CompanyID")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("geographylevel1 as gl1", "t.GL1ID", '=', "gl1.GL1ID")
          ->join("geographylevel2 as gl2", "t.GL2ID", '=', "gl2.GL2ID")
          ->join("geographylevel3 as gl3", "t.GL3ID", '=', "gl3.GL3ID")
          ->join("country as c", "t.CountryID", '=', "c.CountryID")
          ->select(
            "t.EntityID as id",
            "t.ProducerProcessorName",
            "co.CompanyName",
            "fv.VehicleName",
            "gl1.AdminLevel1",
            "gl2.AdminLevel2",
            "gl3.AdminLevel3",
            "c.CountryName",
          )
          ->orderBy('t.EntityID', 'asc');
        break;

      case 'extractionconversion':
        return DB::table("extractionconversion as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("foodtype as ft", "t.FoodTypeID", '=', "ft.FoodTypeID")
          ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
          ->select(
            "t.ExtractionID as id",
            "t.ExtractionRate",
            "fv.VehicleName",
            "ft.FoodTypeName",
            "r.ReferenceNumber",
          )
          ->orderBy('t.ExtractionID', 'asc');
        break;

      case 'foodtype':
        return DB::table("foodtype as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->select(
            "t.FoodTypeID as id",
            "t.FoodTypeName",
            "fv.VehicleName",
          )
          ->orderBy('t.FoodTypeID', 'asc');
        break;

      case 'geographylevel1':
        return DB::table("geographylevel1 as t")
          ->join("country as c", "t.CountryID", '=', "c.CountryID")
          ->select(
            "t.GL1ID as id",
            "t.AdminLevel1",
            "c.CountryName",
          )
          ->orderBy('t.GL1ID', 'asc');
        break;

      case 'geographylevel2':
        return DB::table("geographylevel2 as t")
          ->join("geographylevel1 as gl1", "t.GL1ID", '=', "gl1.GL1ID")
          ->select(
            "t.GL2ID as id",
            "t.AdminLevel2",
            "gl1.AdminLevel1",
          )
          ->orderBy('t.GL2ID', 'asc');
        break;

      case 'geographylevel3':
        return DB::table("geographylevel3 as t")
          ->join("geographylevel2 as gl2", "t.GL2ID", '=', "gl2.GL2ID")
          ->select(
            "t.GL3ID as id",
            "t.AdminLevel3",
            "gl2.AdminLevel2",
          )
          ->orderBy('t.GL3ID', 'asc');
        break;

      case 'individualconsumption':
        return DB::table("individualconsumption as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("gender as g", "t.GenderID", '=', "g.GenderID")
          ->join("age as a", "t.AgeID", '=', "a.AgeID")
          ->join("measureunit1 as mu", "t.UCID", '=', "mu.UCID")
          ->join("yeartype as yt", "t.YearTypeID", '=', "yt.YearTypeID")
          ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
          ->select(
            "t.ConsumptionID as id",
            "fv.VehicleName",
            "g.GenderName",
            "a.AgeRange",
            "t.NumberOfPeople",
            "t.SourceVolume",
            "t.VolumeMTY",
            "mu.SupplyVolumeUnit",
            "yt.YearTypeName",
            "t.StartYear",
            "t.EndYear",
            "r.ReferenceNumber",
          )
          ->orderBy('t.ConsumptionID', 'asc');
        break;

      case 'processingstage':
        return DB::table("processingstage as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->select(
            "t.PSID as id",
            "t.ProcessingStageName",
            "t.ExtractionRate",
            "fv.VehicleName",
          )
          ->orderBy('t.PSID', 'asc');
        break;

      case 'producerprocessor':
        return DB::table("producerprocessor as t")
          ->join("entity as e", "t.EntityID", '=', "e.EntityID")
          ->join("producerreference as pr", "t.ProducerReferenceID", '=', "pr.ProducerReferenceID")
          ->select(
            "t.ProducerProcessorID as id",
            "e.ProducerProcessorName",
            "t.TaskDoneByEntity",
            "t.ProductionCapacityVolumeMTY",
            "t.PercentageOfCapacityUsed",
            "t.AnnualProductionSupplyVolumeMTY",
            "pr.IdentifierNumber",
          )
          ->orderBy('t.ProducerProcessorID', 'asc');
        break;

      case 'producerreference':
        return DB::table("producerreference as t")
          ->join("company as co", "t.CompanyID", '=', "co.CompanyID")
          ->join("country as c", "t.CountryID", '=', "c.CountryID")
          ->select(
            "t.ProducerReferenceID as id",
            "co.CompanyName",
            "t.IdentifierNumber",
            "t.IdentifierReferenceSystem",
            "c.CountryName",
          )
          ->orderBy('t.ProducerReferenceID', 'asc');
        break;

      case 'producersku':
        return DB::table("producersku as t")
          ->join("product as p", "t.ProductID", '=', "p.ProductID")
          ->join("company as co", "t.CompanyID", '=', "co.CompanyID")
          ->join("packagingtype as pa", "t.PackagingTypeID", '=', "pa.PackagingTypeID")
          ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
          ->join("measurecurrency as mc", "t.CurrencyID", '=', "mc.MCID")
          ->select(
            "t.SKUID as id",
            "p.ProductName",
            "co.CompanyName",
            "t.SKU",
            "t.Unit",
            "pa.PackagingTypeName",
            "t.Price",
            "mc.CurrencyName",
            "r.ReferenceNumber",
          )
          ->orderBy('t.SKUID', 'asc');
        break;

      case 'product':
        return DB::table("product as t")
          ->join("brand as b", "t.BrandID", '=', "b.BrandID")
          ->join("company as co", "t.CompanyID", '=', "co.CompanyID")
          ->join("foodtype as ft", "t.FoodTypeID", '=', "ft.FoodTypeID")
          ->select(
            "t.ProductID as id",
            "t.ProductName",
            "b.BrandName",
            "co.CompanyName",
            "ft.FoodTypeName",
          )
          ->orderBy('t.ProductID', 'asc');
        break;

      case 'subdistributionchannel':
        return DB::table("subdistributionchannel as t")
          ->join("distributionchannel as dc", "t.DistributionChannelID", '=', "dc.DistributionChannelID")
          ->select(
            "t.SubDistributionChannelID as id",
            "t.SubDistributionChannelName",
            "dc.DistributionChannelName",
          )
          ->orderBy('t.SubDistributionChannelID', 'asc');
        break;

      case 'supply':
        return DB::table("supply as t")
          ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
          ->join("country as c", "t.CountryID", '=', "c.CountryID")
          ->join("foodtype as ft", "t.FoodTypeID", '=', "ft.FoodTypeID")
          ->join("processingstage as ps", "t.PSID", '=', "ps.PSID")
          ->join("entity as e", "t.EntityID", '=', "e.EntityID")
          ->join("product as p", "t.ProductID", '=', "p.ProductID")
          ->join("producerreference as proc", "t.ProducerReferenceID", '=', "proc.ProducerReferenceID")
          ->join("measureunit1 as mu", "t.UCID", '=', "mu.UCID")
          ->join("yeartype as yt", "t.YearTypeID", '=', "yt.YearTypeID")
          ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
          ->select(
            "t.SupplyID as id",
            "fv.VehicleName",
            "c.CountryName",
            "ft.FoodTypeName",
            "ps.ProcessingStageName",
            "t.Origin",
            "e.ProducerProcessorName",
            "p.ProductName",
            "proc.IdentifierNumber",
            "mu.SupplyVolumeUnit",
            "t.SourceVolume",
            "t.VolumeMTY",
            "t.CropToFirstProcessedFoodStageConvertedValue",
            "yt.YearTypeName",
            "t.StartYear",
            "t.EndYear",
            "r.ReferenceNumber",
          )
          ->orderBy('t.SupplyID', 'asc');
        break;

      default:
        return null;
        break;
    }
  }

  static public function getBrandList()
  {
    return Cache::remember("getList:brand", 60 * 60 * 24, function () {
      return DB::table("brand as t")
        ->select("t.BrandID as value", "t.BrandName as label")
        ->orderBy('t.BrandID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getVehicleList()
  {
    return Cache::remember("getList:foodvehicle", 60 * 60 * 24, function () {
      return DB::table("foodvehicle as t")
        ->select("t.VehicleID as value", "t.VehicleName as label")
        ->orderBy('t.VehicleID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getGeoLevel1List()
  {
    return Cache::remember("getList:geographylevel1", 60 * 60 * 24, function () {
      return DB::table("geographylevel1 as t")
        ->select("t.GL1ID as value", "t.AdminLevel1 as label")
        ->orderBy('t.GL1ID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getGeoLevel2List()
  {
    return Cache::remember("getList:geographylevel2", 60 * 60 * 24, function () {
      return DB::table("geographylevel2 as t")
        ->select("t.GL2ID as value", "t.AdminLevel2 as label")
        ->orderBy('t.GL2ID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getGeoLevel3List()
  {
    return Cache::remember("getList:geographylevel3", 60 * 60 * 24, function () {
      return DB::table("geographylevel3 as t")
        ->select("t.GL3ID as value", "t.AdminLevel3 as label")
        ->orderBy('t.GL3ID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getGenderList()
  {
    return Cache::remember("getList:gender", 60 * 60 * 24, function () {
      return DB::table("gender as t")
        ->select("t.GenderID as value", "t.GenderName as label")
        ->orderBy('t.GenderID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getAgeList()
  {
    return Cache::remember("getList:age", 60 * 60 * 24, function () {
      return DB::table("age as t")
        ->select("t.AgeID as value", "t.AgeRange as label")
        ->orderBy('t.AgeID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getMeasureUnit1List()
  {
    return Cache::remember("getList:measureunit1", 60 * 60 * 24, function () {
      return DB::table("measureunit1 as t")
        ->select("t.UCID as value", "t.SupplyVolumeUnit as label")
        ->orderBy('t.UCID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getYearTypeList()
  {
    return Cache::remember("getList:yeartype", 60 * 60 * 24, function () {
      return DB::table("yeartype as t")
        ->select("t.YearTypeID as value", "t.YearTypeName as label")
        ->orderBy('t.YearTypeID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getReferenceList()
  {
    return Cache::remember("getList:reference", 60 * 60 * 24, function () {
      return DB::table("reference as t")
        ->select("t.ReferenceID as value", "t.ReferenceNumber as label")
        ->orderBy('t.ReferenceID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getDistributionChannelList()
  {
    return Cache::remember("getList:distributionchannel", 60 * 60 * 24, function () {
      return DB::table("distributionchannel as t")
        ->select("t.DistributionChannelID as value", "t.DistributionChannelName as label")
        ->orderBy('t.DistributionChannelID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getSubDistributionChannelList()
  {
    return Cache::remember("getList:subdistributionchannel", 60 * 60 * 24, function () {
      return DB::table("subdistributionchannel as t")
        ->select("t.SubDistributionChannelID as value", "t.SubDistributionChannelName as label")
        ->orderBy('t.SubDistributionChannelID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getCountryList()
  {
    return Cache::remember("getList:country", 60 * 60 * 24, function () {
      return DB::table("country as t")
        ->select("t.CountryID as value", "t.CountryName as label")
        ->orderBy('t.CountryID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getCompanyList()
  {
    return Cache::remember("getList:company", 60 * 60 * 24, function () {
      return DB::table("company as t")
        ->select("t.CompanyID as value", "t.CompanyName as label")
        ->orderBy('t.CompanyID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getFoodTypeList()
  {
    return Cache::remember("getList:foodtype", 60 * 60 * 24, function () {
      return DB::table("foodtype as t")
        ->select("t.FoodTypeID as value", "t.FoodTypeName as label")
        ->orderBy('t.FoodTypeID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getEntityList()
  {
    return Cache::remember("getList:entity", 60 * 60 * 24, function () {
      return DB::table("entity as t")
        ->select("t.EntityID as value", "t.ProducerProcessorName as label")
        ->orderBy('t.EntityID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getProductList()
  {
    return Cache::remember("getList:product", 60 * 60 * 24, function () {
      return DB::table("product as t")
        ->select("t.ProductID as value", "t.ProductName as label")
        ->orderBy('t.ProductID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getCurrencyList()
  {
    return Cache::remember("getList:measurecurrency", 60 * 60 * 24, function () {
      return DB::table("measurecurrency as t")
        ->select("t.MCID as value", "t.CurrencyName as label")
        ->orderBy('t.MCID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getProcessingStageList()
  {
    return Cache::remember("getList:processingstage", 60 * 60 * 24, function () {
      return DB::table("processingstage as t")
        ->select("t.PSID as value", "t.ProcessingStageName as label")
        ->orderBy('t.PSID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getProducerReferenceList()
  {
    return Cache::remember("getList:producerreference", 60 * 60 * 24, function () {
      return DB::table("producerreference as t")
        ->select("t.ProducerReferenceID as value", "t.IdentifierNumber as label")
        ->orderBy('t.ProducerReferenceID', 'asc')
        ->get()
        ->toArray();
    });
  }

  static public function getPackagingTypeList()
  {
    return Cache::remember("getList:packagingtype", 60 * 60 * 24, function () {
      return DB::table("packagingtype as t")
        ->select("t.PackagingTypeID as value", "t.PackagingTypeName as label")
        ->orderBy('t.PackagingTypeID', 'asc')
        ->get()
        ->toArray();
    });
  }
}


// ->join("foodvehicle as fv", "t.VehicleID", '=', "fv.VehicleID")
// "fv.VehicleName",

// ->join("geographylevel1 as gl1", "t.GL1ID", '=', "gl1.GL1ID")
// "gl1.AdminLevel1",

// ->join("geographylevel2 as gl2", "t.GL2ID", '=', "gl2.GL2ID")
// "gl2.AdminLevel2",

// ->join("geographylevel3 as gl3", "t.GL3ID", '=', "gl3.GL3ID")
// "gl3.AdminLevel3",

// ->join("gender as g", "t.GenderID", '=', "g.GenderID")
// "g.GenderName",

// ->join("age as a", "t.AgeID", '=', "a.AgeID")
// "a.AgeRange",

// ->join("measureunit1 as mu", "t.UCID", '=', "mu.UCID")
// "mu.SupplyVolumeUnit",

// ->join("yeartype as yt", "t.YearTypeID", '=', "yt.YearTypeID")
// "yt.YearTypeName",

// ->join("reference as r", "t.ReferenceID", '=', "r.ReferenceID")
// "r.ReferenceNumber",

// ->join("distributionchannel as dc", "t.DistributionChannelID", '=', "dc.DistributionChannelID")
// "dc.DistributionChannelName",

// ->join("subdistributionchannel as sdc", "t.SubDistributionChannelID", '=', "sdc.SubDistributionChannelID")
// "sdc.SubDistributionChannelName",

// ->join("country as c", "t.CountryID", '=', "c.CountryID")
// "c.CountryName",

// ->join("company as co", "t.CompanyID", '=', "co.CompanyID")
// "co.CompanyName",

// ->join("foodtype as ft", "t.FoodTypeID", '=', "ft.FoodTypeID")
// "ft.FoodTypeName",

// ->join("entity as e", "t.EntityID", '=', "e.EntityID")
// "e.ProducerProcessorName",

// ->join("product as p", "t.ProductID", '=', "p.ProductID")
// "p.ProductName",

// ->join("measurecurrency as mc", "t.CurrencyID", '=', "mc.MCID")
// "mc.CurrencyName",

// ->join("processingstage as ps", "t.PSID", '=', "ps.PSID")
// "ps.ProcessingStageName",

// ->join("producerreference as proc", "t.ProducerReferenceID", '=', "proc.ProducerReferenceID")
// "proc.IdentifierNumber",