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
    public $personal_image;
    public $flname;
    public $email;
    public $birthday ;
    public $question1;
    public $answer1 ;
    public $question2;
    public $answer2 ;
    public $question3;
    public $answer3 ;

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
      $query = "INSERT INTO `user` 
      (`username`, `password`, `personal_id`, `personal_image`, `flname`, `email`, `birthday`, `question1`, `answer1`, `question2`, `answer2`, `question3`, `answer3`, `created_at`, `updated_at`) 
      VALUES 
      (:username, :password, :personal_id, :personal_image, :flname, :email, :birthday, :question1, :answer1, :question2, :answer2, :question3, :answer3, NOW(), NOW())";
        
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));
      $this->personal_id=htmlspecialchars(strip_tags($this->personal_id));
      $this->personal_image=htmlspecialchars(strip_tags($this->personal_image));
      $this->flname=htmlspecialchars(strip_tags($this->flname));
      $this->email=htmlspecialchars(strip_tags($this->email));
      $this->birthday=htmlspecialchars(strip_tags($this->birthday));
      $this->question1=htmlspecialchars(strip_tags($this->question1));
      $this->answer1=htmlspecialchars(strip_tags($this->answer1));
      $this->question2=htmlspecialchars(strip_tags($this->question2));
      $this->answer2=htmlspecialchars(strip_tags($this->answer2));
      $this->question3=htmlspecialchars(strip_tags($this->question3));
      $this->answer3=htmlspecialchars(strip_tags($this->answer3));

      $stmt->bindParam(":username", $this->username);
      $stmt->bindParam(":password", $this->password);
      $stmt->bindParam(":personal_id", $this->personal_id);
      $stmt->bindParam(":personal_image", $this->personal_image);
      $stmt->bindParam(":flname", $this->flname);
      $stmt->bindParam(":email", $this->email);
      $stmt->bindParam(":birthday", $this->birthday);
      $stmt->bindParam(":question1", $this->question1);
      $stmt->bindParam(":answer1", $this->answer1);
      $stmt->bindParam(":question2", $this->question2);
      $stmt->bindParam(":answer2", $this->answer2);
      $stmt->bindParam(":question3", $this->question3);
      $stmt->bindParam(":answer3", $this->answer3);
      
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

      $this->token=htmlspecialchars(strip_tags($this->token));
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

    public function checkUsername() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE username = :username";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $stmt->bindParam(":username", trim($this->username));

      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => true,
            "message" => "username available.",
          ));
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "username not available.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function checkEmail() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE email = :email";

      $stmt = $this->conn->prepare($query);

      $this->email=htmlspecialchars(strip_tags($this->email));
      $stmt->bindParam(":email", trim($this->email));

      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => true,
            "message" => "email available.",
          ));
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "email not available.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function checkPid() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE personal_id = :personal_id";

      $stmt = $this->conn->prepare($query);

      $this->personal_id=htmlspecialchars(strip_tags($this->personal_id));
      $stmt->bindParam(":personal_id", trim($this->personal_id));

      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        if($finduser === 0) {
          return json_encode(array(
            "success" => true,
            "message" => "personal_id available.",
          ));
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "personal_id not available.",
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