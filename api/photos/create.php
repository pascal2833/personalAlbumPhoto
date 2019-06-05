<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate photos object
include_once '../objects/Photos.php';

$database = new Database();
$db = $database->getConnection();

$photos = new Photos($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->title) &&
    !empty($data->description)
) {

    // set photos property values
    $photos->name = $data->name;
    $photos->title = $data->title;
    $photos->description = $data->description;
    // create the photos
    if($photos->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }

    // if unable to create the photos, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create photos."));
    }
}
// tell the user data is incomplete
else {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create photos. Data is incomplete."));
}
?>
