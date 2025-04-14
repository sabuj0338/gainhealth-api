<?php

namespace App\Helpers;

use Laravel\Prompts\Table;

class TableSchema
{
  const AGE_SCHEMA = [
    [
      "name" => "AgeRange",
      "title" => "AgeRange",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const BRAND_SCHEMA = [
    [
      "name" => "BrandName",
      "title" => "BrandName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const COMPANY_SCHEMA = [
    [
      "name" => "CompanyName",
      "title" => "CompanyName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const COUNTRY_SCHEMA = [
    [
      "name" => "CountryName",
      "title" => "CountryName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const DISTRIBUTION_CHANNEL_SCHEMA = [
    [
      "name" => "DistributionChannelName",
      "title" => "DistributionChannelName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const VEHICLE_SCHEMA = [
    [
      "name" => "VehicleName",
      "title" => "VehicleName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const GENDER_SCHEMA = [
    [
      "name" => "GenderName",
      "title" => "GenderName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const MC_SCHEMA = [
    [
      "name" => "CurrencyName",
      "title" => "CurrencyName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "CurrencyValue",
      "title" => "CurrencyValue",
      "type" => "number",
      "inputType" => "number",
      "options" => null,
    ],
  ];

  const UC_SCHEMA = [
    [
      "name" => "SupplyVolumeUnit",
      "title" => "SupplyVolumeUnit",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "PeriodicalUnit",
      "title" => "PeriodicalUnit",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "UnitValue",
      "title" => "UnitValue",
      "type" => "number",
      "inputType" => "number",
      "options" => null,
    ],
  ];

  const PACKAGE_TYPE_SCHEMA = [
    [
      "name" => "PackagingTypeName",
      "title" => "PackagingTypeName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  const REFERENCE_SCHEMA = [
    [
      "name" => "ReferenceNumber",
      "title" => "ReferenceNumber",
      "type" => "number",
      "inputType" => "number",
      "options" => null,
    ],
    [
      "name" => "Source",
      "title" => "Source",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "Link",
      "title" => "Link",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "ProcessToObtainData",
      "title" => "ProcessToObtainData",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "AccessDate",
      "title" => "AccessDate",
      "type" => "string",
      "inputType" => "date",
      "options" => null,
    ],
  ];

  const YEAR_TYPE_SCHEMA = [
    [
      "name" => "YearTypeName",
      "title" => "YearTypeName",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "StartMonth",
      "title" => "StartMonth",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
    [
      "name" => "EndMonth",
      "title" => "EndMonth",
      "type" => "string",
      "inputType" => "text",
      "options" => null,
    ],
  ];

  static public function getAdultMaleEquivalentSchema()
  {
    return [
      [
        "name" => "AME",
        "title" => "AME",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "GenderID",
        "title" => "GenderID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGenderList(),
      ],
      [
        "name" => "AgeID",
        "title" => "AgeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getAgeList(),
      ],
    ];
  }

  static public function getConsumptionSchema()
  {
    return [
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "GL1ID",
        "title" => "GL1ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel1List(),
      ],
      [
        "name" => "GL2ID",
        "title" => "GL2ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel2List(),
      ],
      [
        "name" => "GL3ID",
        "title" => "GL3ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel3List(),
      ],
      [
        "name" => "GenderID",
        "title" => "GenderID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGenderList(),
      ],
      [
        "name" => "AgeID",
        "title" => "AgeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getAgeList(),
      ],
      [
        "name" => "NumberOfPeople",
        "title" => "NumberOfPeople",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "SourceVolume",
        "title" => "SourceVolume",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "VolumeMTY",
        "title" => "VolumeMTY",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "UCID",
        "title" => "UCID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getMeasureUnit1List(),
      ],
      [
        "name" => "YearTypeID",
        "title" => "YearTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getYearTypeList(),
      ],
      [
        "name" => "StartYear",
        "title" => "StartYear",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "EndYear",
        "title" => "EndYear",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "ReferenceID",
        "title" => "ReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getReferenceList(),
      ],
    ];
  }

  static public function getDistributionSchema()
  {
    return [
      [
        "name" => "DistributionChannelID",
        "title" => "DistributionChannelID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getDistributionChannelList(),
      ],
      [
        "name" => "SubDistributionChannelID",
        "title" => "SubDistributionChannelID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getSubDistributionChannelList(),
      ],
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "CountryID",
        "title" => "CountryID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCountryList(),
      ],
      [
        "name" => "StartYear",
        "title" => "StartYear",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "DistributedVolume",
        "title" => "DistributedVolume",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
    ];
  }

  static public function getSubDistributionChannelSchema()
  {
    return [
      [
        "name" => "SubDistributionChannelName",
        "title" => "SubDistributionChannelName",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "DistributionChannelID",
        "title" => "DistributionChannelID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getDistributionChannelList(),
      ],
    ];
  }

  static public function getEntitySchema()
  {
    return [
      [
        "name" => "ProducerProcessorName",
        "title" => "ProducerProcessorName",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "CompanyID",
        "title" => "CompanyID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCompanyList(),
      ],
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "GL1ID",
        "title" => "GL1ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel1List(),
      ],
      [
        "name" => "GL2ID",
        "title" => "GL2ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel2List(),
      ],
      [
        "name" => "GL3ID",
        "title" => "GL3ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel3List(),
      ],
      [
        "name" => "CountryID",
        "title" => "CountryID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCountryList(),
      ]
    ];
  }

  static public function geExtractionConversionSchema()
  {
    return [
      [
        "name" => "ExtractionRate",
        "title" => "ExtractionRate",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "FoodTypeID",
        "title" => "FoodTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getFoodTypeList(),
      ],
      [
        "name" => "ReferenceID",
        "title" => "ReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getReferenceList(),
      ],
    ];
  }

  static public function getFoodTypeSchema()
  {
    return [
      [
        "name" => "FoodTypeName",
        "title" => "FoodTypeName",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name"  => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
    ];
  }

  static public function getGeographyLevel1Schema()
  {
    return [
      [
        "name" => "AdminLevel1",
        "title" => "AdminLevel1",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "CountryID",
        "title" => "CountryID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCountryList(),
      ],
    ];
  }

  static public function getGeographyLevel2Schema()
  {
    return [
      [
        "name" => "AdminLevel2",
        "title" => "AdminLevel2",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "GL1ID",
        "title" => "GL1ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel1List(),
      ],
    ];
  }

  static public function getGeographyLevel3Schema()
  {
    return [
      [
        "name" => "AdminLevel3",
        "title" => "AdminLevel3",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "GL2ID",
        "title" => "GL2ID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getGeoLevel2List(),
      ],
    ];
  }

  static public function getIndividualConsumptionSchema()
  {
    return [
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "GenderID",
        "title" => "GenderID",
        "inputType" => "select",
        "type" => "number",
        "options" => TableQuery::getGenderList(),
      ],
      [
        "name" => "AgeID",
        "title" => "AgeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getAgeList(),
      ],
      [
        "name" => "NumberOfPeople",
        "title" => "NumberOfPeople",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "SourceVolume",
        "title" => "SourceVolume",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "VolumeMTY",
        "title" => "VolumeMTY",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "UCID",
        "title" => "UCID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getMeasureUnit1List(),
      ],
      [
        "name" => "YearTypeID",
        "title" => "YearTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getYearTypeList(),
      ],
      [
        "name" => "StartYear",
        "title" => "StartYear",
        "inputType" => "number",
        "type" => "number",
        "options" => null,
      ],
      [
        "name" => "EndYear",
        "title" => "EndYear",
        "inputType" => "number",
        "type" => "number",
        "options" => null,
      ],
      [
        "name" => "ReferenceID",
        "title" => "ReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getReferenceList(),
      ]
    ];
  }

  static public function getProcessingStageSchema()
  {
    return [
      [
        "name" => "ProcessingStageName",
        "title" => "Processing",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "ExtractionRate",
        "title" => "ExtractionRate",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
    ];
  }

  static public function getProducerProcessorSchema()
  {
    return [
      [
        "name" => "EntityID",
        "title" => "EntityID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getEntityList(),
      ],
      [
        "name" => "TaskDoneByEntity",
        "title" => "TaskDoneByEntity",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "ProductionCapacityVolumeMTY",
        "title" => "ProductionCapacityVolumeMTY",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "PercentageOfCapacityUsed",
        "title" => "PercentageOfCapacityUsed",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "AnnualProductionSupplyVolumeMTY",
        "title" => "AnnualProductionSupplyVolumeMTY",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "ProducerReferenceID",
        "title" => "ProducerReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getProducerReferenceList(),
      ],
    ];
  }

  static public function getProducerReferenceSchema()
  {
    return [
      [
        "name" => "CompanyID",
        "title" => "CompanyID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCompanyList(),
      ],
      [
        "name" => "IdentifierNumber",
        "title" => "IdentifierNumber",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "IdentifierReferenceSystem",
        "title" => "IdentifierReferenceSystem",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "CountryID",
        "title" => "CountryID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCountryList(),
      ]
    ];
  }

  static public function getProducerSKUSchema()
  {
    return [
      [
        "name" => "ProductID",
        "title" => "ProductID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getProductList(),
      ],
      [
        "name" => "CompanyID",
        "title" => "CompanyID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCompanyList(),
      ],
      [
        "name" => "SKU",
        "title" => "SKU",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "Unit",
        "title" => "Unit",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "PackagingTypeID",
        "title" => "PackagingTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getPackagingTypeList(),
      ],
      [
        "name" => "Price",
        "title" => "Price",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "CurrencyID",
        "title" => "CurrencyID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCurrencyList(),
      ],
      [
        "name" => "ReferenceID",
        "title" => "ReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getReferenceList(),
      ]
    ];
  }

  static public function getProductSchema()
  {
    return [
      [
        "name" => "ProductName",
        "title" => "ProductName",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "BrandID",
        "title" => "BrandID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getBrandList(),
      ],
      [
        "name" => "CompanyID",
        "title" => "CompanyID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCompanyList(),
      ],
      [
        "name" => "FoodTypeID",
        "title" => "FoodTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getFoodTypeList(),
      ]
    ];
  }

  static public function getSupplySchema()
  {
    return [
      [
        "name" => "VehicleID",
        "title" => "VehicleID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getVehicleList(),
      ],
      [
        "name" => "CountryID",
        "title" => "CountryID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCountryList(),
      ],
      [
        "name" => "FoodTypeID",
        "title" => "FoodTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getFoodTypeList(),
      ],
      [
        "name" => "PSID",
        "title" => "PSID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getProcessingStageList(),
      ],
      [
        "name" => "Origin",
        "title" => "Origin",
        "type" => "string",
        "inputType" => "text",
        "options" => null,
      ],
      [
        "name" => "EntityID",
        "title" => "EntityID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getEntityList(),
      ],
      [
        "name" => "ProductID",
        "title" => "ProductID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getProductList(),
      ],
      [
        "name" => "ProductReferenceID",
        "title" => "ProductReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getProducerReferenceList(),
      ],
      [
        "name" => "UCID",
        "title" => "UCID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getCurrencyList(),
      ],
      [
        "name" => "SourceVolume",
        "title" => "SourceVolume",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "VolumeMTY",
        "title" => "VolumeMTY",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "CropToFirstProcessedFoodStageConvertedValue",
        "title" => "CropToFirstProcessedFoodStageConvertedValue",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "YearTypeID",
        "title" => "YearTypeID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getYearTypeList(),
      ],
      [
        "name" => "StartYear",
        "title" => "StartYear",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "EndYear",
        "title" => "EndYear",
        "type" => "number",
        "inputType" => "number",
        "options" => null,
      ],
      [
        "name" => "ReferenceID",
        "title" => "ReferenceID",
        "type" => "number",
        "inputType" => "select",
        "options" => TableQuery::getReferenceList(),
      ],
    ];
  }

  static public function getSchemaByTableName(string $tableName)
  {
    $data = null;

    switch ($tableName) {
      case 'age':
        $data = self::AGE_SCHEMA;
        break;
      case 'brand':
        $data = self::BRAND_SCHEMA;
        break;
      case 'company':
        $data = self::COMPANY_SCHEMA;
        break;
      case 'country':
        $data = self::COUNTRY_SCHEMA;
        break;
      case 'distributionchannel':
        $data = self::DISTRIBUTION_CHANNEL_SCHEMA;
        break;
      case 'foodvehicle':
        $data = self::VEHICLE_SCHEMA;
        break;
      case 'gender':
        $data = self::GENDER_SCHEMA;
        break;
      case 'measurecurrency':
        $data = self::MC_SCHEMA;
        break;
      case 'measureunit1':
        $data = self::UC_SCHEMA;
        break;
      case 'packagingtype':
        $data = self::PACKAGE_TYPE_SCHEMA;
        break;
      case 'reference':
        $data = self::REFERENCE_SCHEMA;
        break;
      case 'yeartype':
        $data = self::YEAR_TYPE_SCHEMA;
        break;
      case 'adultmaleequivalent':
        $data = self::getAdultMaleEquivalentSchema();
        break;
      case 'consumption':
        $data = self::getConsumptionSchema();
        break;
      case 'distribution':
        $data = self::getDistributionSchema();
        break;
      case 'subdistributionchannel':
        $data = self::getSubDistributionChannelSchema();
        break;
      case 'entity':
        $data = self::getEntitySchema();
        break;
      case 'extractionconversion':
        $data = self::geExtractionConversionSchema();
        break;
      case 'foodtype':
        $data = self::getFoodTypeSchema();
        break;
      case 'geographylevel1':
        $data = self::getGeographyLevel1Schema();
        break;
      case 'geographylevel2':
        $data = self::getGeographyLevel2Schema();
        break;
      case 'geographylevel3':
        $data = self::getGeographyLevel3Schema();
        break;
      case 'individualconsumption':
        $data = self::getIndividualConsumptionSchema();
        break;
      case 'processingstage':
        $data = self::getProcessingStageSchema();
        break;
      case 'producerprocessor':
        $data = self::getProducerProcessorSchema();
        break;
      case 'producerreference':
        $data = self::getProducerReferenceSchema();
        break;
      case 'producersku':
        $data = self::getProducerSKUSchema();
        break;
      case 'product':
        $data = self::getProductSchema();
        break;
      case 'supply':
        $data = self::getSupplySchema();
        break;

      default:
        $data = null;
        break;
    }
    return $data;
  }
}


// return [
//   {
//     name: "name",
//     title: "Name",
//     type: "string",
//     inputType: "text",
//     options: null,
//   },
//   {
//     name: "description",
//     title: "Description",
//     type: "string",
//     inputType: "textarea",
//     options: null,
//   },
//   {
//     name: "type",
//     title: "Type",
//     type: "enum",
//     inputType: "select",
//     options: [
//       {
//         value: "1",
//         label: "a2v",
//       },
//       {
//         value: "2",
//         label: "t2v",
//       },
//     ],
//   },
//   {
//     name: "amount",
//     title: "Amount",
//     type: "number",
//     inputType: "number",
//     options: null,
//   },
//   {
//     name: "gender",
//     title: "Gender",
//     type: "string",
//     inputType: "radio",
//     options: [
//       {
//         value: "male",
//         label: "Male",
//       },
//       {
//         value: "female",
//         label: "Female",
//       },
//     ],
//   },
//   {
//     name: "skills",
//     title: "Skills",
//     type: "string[]",
//     inputType: "checkbox",
//     options: [
//       {
//         value: "1",
//         label: "react",
//       },
//       {
//         value: "2",
//         label: "express",
//       },
//     ],
//   },
// ];