<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600"); // ???
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // ???

// include database and object files
include_once '../config/database.php';
include_once '../objects/Photos.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$photos = new Photos($db);

// Retrieve value from request:
$photoTitle = $_POST['title'];
$date = $_POST['date'];
$category = $_POST['category'];
$description = $_POST['description'];
$horizontalOrVertical = $_POST['horizontalOrVertical'];
$file = $_FILES['imageFile'];
$tmp = $_FILES['imageFile']['tmp_name'];
$imgNameFromDownload = $_FILES['imageFile']['name'];
$creation_date = date('Y-m-d_H:i:s');
// var to keep file in db:
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = '../PhotosToShow/'; // Where put photos
$ext = strtolower(pathinfo($imgNameFromDownload, PATHINFO_EXTENSION));

// make sure mandatory fields send by front are not empty and image size Ok and extension file image OK:
if(
    !empty($photoTitle) &&
    !empty($date) &&
    !empty($category) &&
    !empty($horizontalOrVertical) &&
    !empty($file) &&
    $files['size'] < 4000000 &&
    in_array($ext, $valid_extensions)
) {
    // set photos property values
    $photos->creation_date = $creation_date;
    $imgName = 'photo_'.$creation_date;
    $photos->name = $imgName;
    $photos->title = $photoTitle;
    $photos->date = $date;
    $photos->category = $category;
    $photos->description = $description;
    $photos->horizontalOrVertical = $horizontalOrVertical;
    // create the photos
    if($photos->create()) {
      // Put image in folder:
      $final_imageToKeep = $imgName.'.'.$ext;
      $path = $path.strtolower($final_imageToKeep);
      move_uploaded_file($tmp,$path);
      // set response code - 201 created
      http_response_code(201);
    }
    // if unable to create the photos, tell the user
    else {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Une erreur a eu lieu, la photo n'a pas pu se garder"));
    }
}
// tell the user data is incomplete
else {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Il manque des champs pour pouvoir enregistrer la photo"));
}
