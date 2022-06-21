<?php
namespace Src\Controllers;

use Src\Models\CountryCurrencyModel;

class CountryCurrencyController
{

    private $conn;
    private $tableName;

    function __construct($conn, $tableName)
    {
        $this->conn = $conn;
        $this->tableName = $tableName;
        $this->countryCurrency = new CountryCurrencyModel($conn);
    }

    function readRecords()
    {
        $fileName = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");
            $importCount = 0;
            fgetcsv($file); //skip the first row
            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                if (! empty($column) && is_array($column)) {
                    if ($this->hasEmptyRow($column)) {
                        continue;
                    }

                    if ($this->tableName == "currencies") {
                        if (isset($column[0], $column[1], $column[2], $column[3])) {
                            $isoCode = $column[0];
                            $isoNumericCode = $column[1];
                            $commonName = $column[2];
                            $officialName = $column[3];
                            $symbol = $column[4];
                            $insertRows = $this->insertCurrencyData($isoCode, $isoNumericCode, $commonName, $officialName, $symbol);
                            if (! empty($insertRows)) {
                                $output["type"] = "success";
                                $output["message"] = "Import completed.";
                                $importCount ++;
                            }
                        }
                    } else if ($this->tableName == "countries"){
                        if (isset($column[0], $column[1], $column[7], $column[8])) {
                            $continentCode = $column[0];
                            $currencyCode = $column[1];
                            $iso2Code = $column[2];
                            $iso3Code = $column[3];
                            $isoNumericCode = $column[4];
                            $fipsCode = $column[5];
                            $callingCode = $column[6];
                            $commonName = $column[7];
                            $officialName = $column[8];
                            $endonym = $column[9];
                            $demonym = $column[10];
                            $insertRows = $this->insertCountryData($continentCode, $currencyCode, $iso2Code, $iso3Code, $isoNumericCode, $fipsCode, $callingCode, $commonName, $officialName, $endonym, $demonym);
                            if (! empty($insertRows)) {
                                $output["type"] = "success";
                                $output["message"] = "Import completed.";
                                $importCount ++;
                            }
                        }
                    }
                } else {
                    $output["type"] = "error";
                    $output["message"] = "Problem in importing data.";
                }
            }
            if ($importCount == 0) {
                $output["type"] = "error";
                $output["message"] = "Duplicate data found.";
            }
            return $output;
        }
    }

    function hasEmptyRow(array $column)
    {
        $columnCount = count($column);
        $isEmpty = true;
        for ($i = 0; $i < $columnCount; $i ++) {
            if (! empty($column[$i]) || $column[$i] !== '') {
                $isEmpty = false;
            }
        }
        return $isEmpty;
    }

    function insertCurrencyData($isoCode, $isoNumericCode, $commonName, $officialName, $symbol)
    {
        $sql = "SELECT iso_code FROM currencies WHERE iso_code = ?";
        $paramType = "s";
        $paramArray = array(
            $isoCode
        );
        $result = $this->countryCurrency->select($sql, $paramType, $paramArray);
        $insertRows = 0;
        if (empty($result)) {
            $sql = "INSERT into currencies (iso_code, iso_numeric_code, common_name, official_name, symbol)
                       values (?,?,?,?,?)";
            $paramType = "sssss";
            $paramArray = array(
                $isoCode,
                $isoNumericCode,
                $commonName,
                $officialName,
                $symbol
            );
            $insertRows = $this->countryCurrency->insert($sql, $paramType, $paramArray);
        }
        return $insertRows;
    }

    function insertCountryData($continentCode, $currencyCode, $iso2Code, $iso3Code, $isoNumericCode, $fipsCode, $callingCode, $commonName, $officialName, $endonym, $demonym)
    {
        $sql = "SELECT iso_numeric_code FROM countries WHERE iso_numeric_code = ?";
        $paramType = "s";
        $paramArray = array(
            $isoNumericCode
        );
        $result = $this->countryCurrency->select($sql, $paramType, $paramArray);
        $insertRows = 0;
        if (empty($result)) {
            $sql = "INSERT into countries (continent_code, currency_code, iso2_code, iso3_code, iso_numeric_code, fips_code, calling_code, common_name, official_name, endonym, demonym)
                       values (?,?,?,?,?,?,?,?,?,?,?)";
            $paramType = "sssssssssss";
            $paramArray = array(
                $continentCode, 
                $currencyCode, 
                $iso2Code, 
                $iso3Code, 
                $isoNumericCode,
                $fipsCode, 
                $callingCode, 
                $commonName, 
                $officialName, 
                $endonym, 
                $demonym
            );
            $insertRows = $this->countryCurrency->insert($sql, $paramType, $paramArray);
        }
        return $insertRows;
    }
}
?>