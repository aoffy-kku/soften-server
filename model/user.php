<?php
  class User {

    // create connection and table name first
    private $conn;
    private $table_name = "user";

    // create properties
    public $username;
    public $password;
    public $personal_id;
    public $admin;
    public $created_at;
    public $updated_at;
    public $enabled;
    public $point;
    public $token;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM user";
      $stmt = $this->conn->prepare($query);
      try {
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0) {
          $user_arr = array();
          $user_arr["success"] = true;
          $user_arr["message"]  = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
              "username" => $username,
              "created_at" => $created_at,
              "updated_at" => $updated_at,
              "point" => $point,
              "role" => $role,
            );
            array_push($user_arr["message"], $user_item);
          }
          return json_encode($user_arr);
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "user is empty.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function create() {
      $query = "INSERT INTO " 
        .$this->table_name. 
        " (username, password, personal_id, created_at, updated_at) VALUES (:username, :password, :personal_id, NOW(), NOW()";
      
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->personal_id=htmlspecialchars(strip_tags($this->personal_id));

      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":personal_id", $this->personal_id);

      try {
        $stmt->execute();
        return json_encode(array(
          "success" => true,
          "message" => $stmt->rowCount(). " row(s) inserted.",
        ));
      } catch(PDOExeption $e){
        return json_encode(array(
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
              "message" => $token,
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

    public function checkAuth() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE token = :token";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->token));
      $stmt->bindParam(":token", trim($this->token));

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
          return json_encode(array(
            "success" => true,
            "message" => array(
              "username" => $username,
              "admin" => $admin,
              "point" => $point,
            ),
          ));
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