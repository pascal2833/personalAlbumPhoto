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
// initialize object
$photos = new Photos($db);

// get params from request:
$paramsFromRequest = $_GET;
var_dump($paramsFromRequest); die();

// query photos:
$stmt = $photos->search($paramsFromRequest);

$photos_arr = array();
// Retrieve our table contents:
// fetch() is faster than fetchAll()
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// extract row. this will make $row['name'] to just $name only
    extract($row);
    $photos_arr[] = array( // [] to create an array, if not, {}
    'id' => $id,
    'imageFile' => html_entity_decode($name),
    'description' => html_entity_decode($description),
    'date' => $date,
    'category' => html_entity_decode($category),
    'creation_date' => $creation_date,
    'horizontalOrVertical' => $horizontalOrVertical,
    );
}

// set response code - 200 OK
   http_response_code(200);
// show products data in json format
   echo json_encode($photos_arr);

