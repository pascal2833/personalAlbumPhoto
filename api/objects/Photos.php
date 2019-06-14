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
    public $horizontalOrVertical;
    public $paramsFromRequest;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // ----- search photos
    function search($paramsFromRequest) {
        // select all query
        $categoryFromRequest = $paramsFromRequest["category"];
        $initialDateFromRequest = $paramsFromRequest["initialDate"];
        $endDateFromRequest = $paramsFromRequest["endDate"];
        $query = "SELECT * FROM photos WHERE category='".$categoryFromRequest."' AND date >= '".$initialDateFromRequest."' AND date <= '".$endDateFromRequest."' ORDER BY date ASC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    // ------ create photos
    function create(){
        // query to insert record
        $query = "INSERT INTO photos SET title=:title, date=:date, category=:category, description=:description, creation_date=:creation_date, name=:name, horizontalOrVertical=:horizontalOrVertical";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->creation_date=htmlspecialchars(strip_tags($this->creation_date));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->horizontalOrVertical=htmlspecialchars(strip_tags($this->horizontalOrVertical));
        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":creation_date", $this->creation_date);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":horizontalOrVertical", $this->horizontalOrVertical);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
