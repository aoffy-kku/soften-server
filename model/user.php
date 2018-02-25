<?php
  class User {

    // create connection and table name first
    private $conn;
    private $table_name = "user";

    // create properties
    public $username;
    public $password;
    public $personal_id;
    public $role;
    public $created_at;
    public $updated_at;
    public $enabled;

    public function __construct($db) {
      $this->conn = $db;
    }

    // add your function ex. findAll, findById, createUser
    public function read() {
      $query = "SELECT * FROM user";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO " 
        .$this->table_name. 
        " (username, password, personal_id) VALUES (:username, :password, :personal_id)";
      
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->personal_id=htmlspecialchars(strip_tags($this->personal_id));

      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":personal_id", $this->personal_id);

      try {
        $stmt->execute();
        return echo json_encode(array(
          "success" => true,
          "data" => $stmt->rowCount();
        ));
      } catch(PDOExeption $e){
        return echo json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function signin() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE username=:username";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $stmt->bindParam(":username", $this->username);

      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => false,
            "message" => "username not correct.",
          ));
        } else {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          if($password === $this->password) {
            return json_encode(array(
              "success" => true,
              "data" => array(
                "username" => $username,
                "role" => $role,
              ),
            ));
          } else {
            return json_encode(array(
              "success" => false,
              "message" => "password not correct.",
            ));
          }
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }
  }
?>