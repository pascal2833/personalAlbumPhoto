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

// Retrieve value from request:
$photoTitle = $_POST['title'];
$date = $_POST['date'];
$category = $_POST['category'];
$description = $_POST['description'];
$verticalOrHorizontal = $_POST['verticalOrHorizontal'];
$file = $_FILES['imageFile'];

// keep file in db:
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = '../PhotosToShow/'; // Where put photos

// make sure mandatory fields send by front are not empty:
if(
    !empty($photoTitle) &&
    !empty($date) &&
    !empty($category) &&
    !empty($description) &&
    !empty($verticalOrHorizontal) &&
    !empty($file)
) {

    // Put image in folder:
        $creation_date = date('Y-m-d H:i:s');
        $imgName = 'photo_'.$creation_date;
        $tmp = $_FILES['imageFile']['tmp_name'];
        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        // can upload same image using rand function
        $final_image = rand(1000,1000000).$imgName;
        if(in_array($ext, $valid_extensions))
        {
          $path = $path.strtolower($final_image);
          move_uploaded_file($tmp,$path);
        }
    // set photos property values
    $photos->creation_date = $creation_date;
    $photos->name = $imgName;
    $photos->title = $photoTitle;
    $photos->date = $date;
    $photos->category = $category;
    $photos->description = $description;
    $photos->verticalOrHorizontal = $verticalOrHorizontal;
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
    echo json_encode(array("message" => "Unable to create photos. Data is incomplete."));
}
?>
