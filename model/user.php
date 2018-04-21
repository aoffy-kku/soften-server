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
      (`username`, `password`, `personal_id`, `personal_image`, `flname`, `email`, `birthday`, `question1`, `answer1`, `question2`, `answer2`, `question3`, `answer3`, `created_at`, `updated_at`, `token`) 
      VALUES 
      (:username, :password, :personal_id, :personal_image, :flname, :email, :birthday, :question1, :answer1, :question2, :answer2, :question3, :answer3, NOW(), NOW()), :token";
        
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
      $stmt->bindParam(":token", $this->token);
      
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
      $query = "SELECT * FROM user WHERE username = :username";

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

      public function checkUsernameForResetPW() {
      $query = "SELECT * FROM user WHERE username = :username AND enabled = 1";

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


  public function readQuestionByUsername() {
    $query = "SELECT * FROM "
      .$this->table_name.
      " WHERE username = :username AND enabled = 1";
    $stmt = $this->conn->prepare($query);

    $this->username=htmlspecialchars(strip_tags($this->username));
    $stmt->bindParam(":username", trim($this->username));
    try {
      $stmt->execute();
      $rows = $stmt->rowCount();

      if($rows > 0) {
        $user_arr = array();
        $user_arr["success"] = true;
        $user_arr["message"]  = array();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          $user_arr["message"] = array(
            "username" => $username,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            "point" => $point,
            "role" => $role,
            "question1" => $question1,
            "question2" => $question2,
            "question3" => $question3,
            "email" => $email,
          );
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

  public function checkAnswer() {
      $query = "SELECT * FROM "
        .$this->table_name.
      " WHERE username = :username";

      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username)); 
      $stmt->bindParam(":username", trim($this->username));
      try {
        $stmt->execute();
        $finduser = $stmt->rowCount();
        $resultAns1 = false;
        $resultAns2 = false;
        $resultAns3 = false;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        if($answer1 == $this->answer1) {
          $resultAns1 = true;
        }

        if($answer2 == $this->answer2) {
          $resultAns2 = true;
        }
        
        if($answer3 == $this->answer3) {
          $resultAns3 = true;
        }

         return json_encode(array(
            "success" => true,
            "message" => array(
              "answer1" => $resultAns1,
              "answer2" => $resultAns2,
              "answer3" => $resultAns3,
            )
          ));

      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function changePassword() {
      $query = "UPDATE user SET `password` = :password, `token` = :token WHERE `username` = :username";        
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));
      $this->password=htmlspecialchars(strip_tags($this->password));

      $stmt->bindParam(":username", trim($this->username));
      $stmt->bindParam(":password", trim($this->password));
      $stmt->bindParam(":token", $this->token);

      try {
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row > 0) {
       	  $query = "SELECT * FROM `user` WHERE `username` = :username";        
          $stmt = $this->conn->prepare($query);

          $this->username=htmlspecialchars(strip_tags($this->username));;
          $stmt->bindParam(":username", trim($this->username));
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          $response = file_get_contents("https://soften-mailer.herokuapp.com/resetsuccess?receiver=".$email);
          return json_encode(array(
            "success" => true,
            "message" => $response . " " . "https://soften-mailer.herokuapp.com/resetsuccess?receiver=".$email,
          ));
          return json_encode(array(
            "success" => true,
            "message" => "Password has been changed.",
          ));
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "Password cannot change.",
          ));
        }
      } catch(PDOException $e) {
        return json_encode(array(
          "success" => false,
          "message" => $e,
        ));
      }
    }

    public function banUser() {
      $query = "UPDATE user SET `enabled` = 2 WHERE `username` = :username";        
      $stmt = $this->conn->prepare($query);

      $this->username=htmlspecialchars(strip_tags($this->username));;
      $stmt->bindParam(":username", trim($this->username));

      try {
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row > 0) {
          $query = "SELECT * FROM `user` WHERE `username` = :username";        
          $stmt = $this->conn->prepare($query);

          $this->username=htmlspecialchars(strip_tags($this->username));;
          $stmt->bindParam(":username", trim($this->username));
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);
          $response = file_get_contents("https://soften-mailer.herokuapp.com/resetfail?receiver=".$email);
          return json_encode(array(
            "success" => true,
            "message" => $response . " " . "https://soften-mailer.herokuapp.com/resetfail?receiver=".$email,
          ));
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "User cannot banned.",
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