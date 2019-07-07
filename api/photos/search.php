<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// include database and object files
include_once '../config/database.php';
include_once '../objects/Photos.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
// get params from request:
$_POST = json_decode(file_get_contents("php://input"), true);
$paramsFromSearchRequest = $_POST;
// initialize object
$photos = new Photos($db);
// query photos:
$stmt = $photos->search($paramsFromSearchRequest);

$index = 0;
$photos_arr = array();
// Retrieve our table contents:
// fetch() is faster than fetchAll()
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// extract row. this will make $row['name'] to just $name only
    $index = $index + 1;
    extract($row);
    $photos_arr[] = array( // [] to create an array, if not, {}
    'id' => $id,
    'title' => html_entity_decode($title),
    'imageFile' => html_entity_decode($name),
    'description' => html_entity_decode($description),
    'date' => $date,
    'category' => html_entity_decode($category),
    'creation_date' => $creation_date,
    'horizontalOrVertical' => $horizontalOrVertical,
    );
}
  if (sizeof($photos_arr) >= 1) {
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($photos_arr);
  } else {
      http_response_code(400);
    }



