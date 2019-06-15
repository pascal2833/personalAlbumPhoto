<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
// include_once '../config/database.php';
include_once '../objects/Photos.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
// get params from request:
$indexPhotoToRetrieve = $_GET;
// initialize object
$photos = new Photos($db);
// set photos property values
$photos->indexPhotoToRetrieve = $indexPhotoToRetrieve;
// query photos:
$stmt = $photos->getDataAfterSearch();
