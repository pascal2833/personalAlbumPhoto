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

// get posted data:
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty (set mandatory data send by client):
if(
    !empty($data->title) &&
    !empty($data->date) &&
    !empty($data->category)
) {


  if (move_uploaded_file($_FILES['file1']['tmp_name'], $dest))
  {
     echo 'File Has Been Uploaded !';
  }

    // set photos property values
    $photos->title = $data->title;
    $photos->date = $data->date;
    $photos->category = $data->category;
    $photos->description = $data->description;
    $creation_date = date('Y-m-d H:i:s');
    $photos->creation_date = $creation_date;
    $photos->name = 'photo_'.$creation_date;
    // create the photos
    if($photos->create()) {
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
    // if unable to create the photos, tell the user
    else {
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
    echo json_encode(array("message" => "Unable to create photos. Data is incomplete.".$data->title.$data->description));
}
?>
