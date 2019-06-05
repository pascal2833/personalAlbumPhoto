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

// query photos:
$stmt = $photos->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // photos array
    $photos_arr=array();
    $photos_arr["records"]=array();

    // Retrieve our table contents:
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row. this will make $row['name'] to just $name only
        extract($row);

        $photos_item=array(
            "id" => $id,
            "name" => html_entity_decode($name),
            "date" => $date,
            "$key_word" => $key_word,
            "title" => html_entity_decode($title),
            "description" => html_entity_decode($description),
        );

        array_push($photos_arr["records"], $photos_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($products_arr);
}

// no products found:
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
