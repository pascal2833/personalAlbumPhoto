<?php
class Photos{

    // database connection and table name
    private $conn;
    // object properties
    public $id;
    public $name;
    public $date;
    public $key_word;
    public $title;
    public $description;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read photos
    function read() {
        // select all query
        $query = "SELECT p.id, p.name, p.date, p.key_word, p.title, p.description FROM photos ORDER B p.date DESC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }
    // create photos
    function create(){
        // query to insert record
        $query = "INSERT INTO photos SET name=:name, title=:title, description=:description";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;

    }
}
