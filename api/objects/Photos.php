<?php
class Photos{
    // database connection and table name
    private $conn;
    // object properties
    public $id;
    public $title;
    public $date;
    public $category;
    public $description;
    public $creation_date;
    public $name;
    public $verticalOrHorizontal;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // search photos
    function search(paramsFromRequest) {
        // select all query
        $query = "SELECT * FROM photos WHERE category= "paramsFromRequest.category" ORDER BY date ASC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }
    // create photos
    function create(){
        // query to insert record
        $query = "INSERT INTO photos SET title=:title, date=:date, category=:category, description=:description, creation_date=:creation_date, name=:name, verticalOrHorizontal=:verticalOrHorizontal";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->creation_date=htmlspecialchars(strip_tags($this->creation_date));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->verticalOrHorizontal=htmlspecialchars(strip_tags($this->verticalOrHorizontal));
        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":creation_date", $this->creation_date);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":verticalOrHorizontal", $this->verticalOrHorizontal);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
