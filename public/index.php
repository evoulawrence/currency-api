<?php
require "../bootstrap.php";
use Src\Controllers\CountryCurrencyApiController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// API ENDPOINT
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$endpoint = $uri[1].'/'.$uri[2];
$table = '';
if ($endpoint == "agpay/countries") {
    $table = "countries";
}
elseif ($endpoint == "agpay/currencies") {
    $table = "currencies";
}
elseif ($endpoint == "agpay") {
    $table = null;
}

if ($uri[1].'/'.$uri[2] !== $endpoint) {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("Error" => "Endpoint is invalid. Refer to README file"));
    exit();
}

$offset = "";
$limit = "";
$search = "";

if (isset($_GET['limit']) && !empty($_GET["limit"])) {
    $limit = $_GET['limit'];
}
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("Error" => "Limit parameter not set. Refer to README file"));
    exit();
}

if (isset($_GET['offset']) && $_GET["offset"] != "") {
    $offset = $_GET['offset'];
}
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("Error" => "Offset parameter not set. Refer to README file"));
    exit();
}

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$apiController = new CountryCurrencyApiController($dbConnection, $requestMethod, $table, $limit, $offset, $search);
$apiController->processRequest();

?>
