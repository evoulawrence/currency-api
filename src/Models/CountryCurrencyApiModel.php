<?php
namespace Src\Models;

class CountryCurrencyApiModel {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * To get database results
     *
     * @param string $table
     * @param string $limit
     * @param string $offset
     * @param string $search
     * @return array
     */
    public function findAll($table, $limit, $offset, $search)
    {
        try {
            if ($table != null) {
                $statement = "SELECT * 
                    FROM 
                    $table 
                    WHERE
                    common_name LIKE '%$search%' OR official_name LIKE '%$search%'
                    LIMIT $offset, $limit"
                ;

                $statement = $this->db->prepare($statement);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
            }
            else {
                $statement = "SELECT *,
                    currencies.iso_numeric_code AS inc, 
                    currencies.common_name AS cn,
                    currencies.official_name AS ofn 
                    FROM 
                    currencies 
                    INNER JOIN 
                    countries
                    ON 
                    countries.currency_code = currencies.iso_code 
                    WHERE 
                    countries.common_name LIKE '%$search%' OR countries.official_name LIKE '%$search%' OR currencies.common_name LIKE '%$search%' OR currencies.official_name LIKE '%$search%'
                    ORDER BY 
                    currencies.iso_code
                    LIMIT $offset, $limit"
                ;

                $statement = $this->db->prepare($statement);
                $statement->execute();
                $dataRows = $statement->get_result();
                $data = array();
            
                foreach($dataRows as $row)
                {
                    $currencyCode = $row['iso_code'];
                    if (isset($data[$currencyCode])) {
                        $dataRow = $data[$currencyCode];
                    }
                    else {
                        $dataRow= array(
                            'iso_code' => $currencyCode,
                            'iso_numeric_code' => $row['inc'],
                            'common_name' => $row['cn'],
                            'official_name' => $row['ofn'],
                            'symbol' => $row['symbol'],
                            'countries' => array()
                        );
                    }

                    $dataRow['countries'][] = array(
                        'continent_code' => $row['continent_code'],
                        'currency_code' => $row['currency_code'],
                        'iso2_code' => $row['iso2_code'],
                        'iso3_code' => $row['iso3_code'],
                        'iso_numeric_code' => $row['iso_numeric_code'],
                        'fips_code' => $row['fips_code'],
                        'calling_code' => $row['calling_code'],
                        'common_name' => $row['common_name'],
                        'official_name' => $row['official_name'],
                        'endonym' => $row['endonym'],
                        'demonym' => $row['demonym']
                    ); 
                    $data[$currencyCode] = $dataRow;
                }
            }
            return $data;
        } catch (\Exception $e) {
            exit($e->getMessage());
        }  
    }
}

?>