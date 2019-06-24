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
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // ----- search photos
    function search($paramsFromSearchRequest) {
        // select all query
        $categoryFromRequest = $paramsFromSearchRequest["category"];
        $initialDateFromRequest = $paramsFromSearchRequest["initialDate"];
        $endDateFromRequest = $paramsFromSearchRequest["endDate"];
        $firstSearchOrPagination = $paramsFromSearchRequest["firstSearchOrPagination"];
        $numPageFromPagination = $paramsFromSearchRequest["numPageFromPagination"] - 1;
        $categoryFromRequestStr = implode("', '", $categoryFromRequest);
          if ($firstSearchOrPagination === 'firstSearch') {
            $query = "SELECT * FROM photos WHERE category IN ('$categoryFromRequestStr') AND date >= '".$initialDateFromRequest."' AND date <= '".$endDateFromRequest."' ORDER BY date ASC";
          } elseif ($firstSearchOrPagination === 'pagination') {
            $query = "SELECT * FROM photos WHERE category IN ('$categoryFromRequestStr') AND date >= '".$initialDateFromRequest."' AND date <= '".$endDateFromRequest."' ORDER BY date ASC limit ".$numPageFromPagination.",1";
          }
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    // ------ Edit photos:
    function edit($paramFromEditRequest) {
      $categoryFromRequest = $paramFromEditRequest["category"];
      $titleFromRequest = $paramFromEditRequest["title"];
      $dateFromRequest = $paramFromEditRequest["date"];
      $descriptionFromRequest = $paramFromEditRequest["description"];
      $idFromRequest = $paramFromEditRequest["id"];
      $query = "UPDATE photos SET date='".$dateFromRequest."', category='".$categoryFromRequest."', title='".$titleFromRequest."', description='".$descriptionFromRequest."'  WHERE id='".$idFromRequest."'";
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // Execute query:
      if($stmt->execute()){
          return true;
      }
      return false;
    }
    // ------ Delete photos:
    function delete ($paramFromDeleteRequest) {
      $idPhoto = $paramFromDeleteRequest["id"];
      // Delete file:
      $stmt1 = $this->conn->prepare("SELECT name FROM photos WHERE id='".$idPhoto."'");
      $stmt1->execute();
      // set the resulting array to associative
      $photoFileName = $stmt1->fetch(PDO::FETCH_ASSOC);
      unlink("../PhotosToShow/".$photoFileName);

      $query="DELETE FROM photos WHERE id='".$idPhoto."'";
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // Execute query:
      if($stmt->execute()){
          return true;
      }
      return false;
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
