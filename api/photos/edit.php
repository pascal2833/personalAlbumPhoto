<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
include_once '../config/database.php';
include_once '../objects/Photos.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
// get params from request:
$paramFromEditRequest = $_POST;
// initialize object
$photos = new Photos($db);
// query photos:
$stmt = $photos->delete($paramFromEditRequest);

if($photos->delete()) {
      // set response 200, OK:
      http_response_code(200);
    }
    // if unable to delete the photos, tell the user
    else {
        // set response code - 503 service unavailable
        http_response_code(503);
    }
