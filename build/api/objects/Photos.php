<?php
class Photo{

    // database connection and table name
    private $conn;
    private $table_name = "photos";

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

    // read products
    function read() {
        // select all query
        $query = "SELECT p.id, p.name, p.date, p.price, p.key_word, p.title, p.description FROM photos ORDER B p.date DESC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }
}
