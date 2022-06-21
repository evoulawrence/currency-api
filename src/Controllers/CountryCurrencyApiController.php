<?php
namespace Src\Controllers;

use Src\Models\CountryCurrencyApiModel;

class CountryCurrencyApiController {

    private $db;
    private $requestMethod;
    private $table;
    private $limit;
    private $offset;
    private $search;

    public function __construct($db, $requestMethod, $table, $limit, $offset, $search)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->table = $table;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->search = $search;

        $this->countryCurrency = new CountryCurrencyApiModel($db);
    }

    public function processRequest()
    {
        if ($this->requestMethod == 'GET') {
            $response = $this->getAllData($this->table, $this->limit, $this->offset, $this->search);
        }        
        else {       
            $response = $this->notFoundResponse();
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllData($table, $limit, $offset, $search)
    {
        $result = $this->countryCurrency->findAll($table, $limit, $offset, $search);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
?>