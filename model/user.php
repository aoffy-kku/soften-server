<?php
  class User {

    // create connection and table name first
    private $conn;
    private $table_name = "user";

    // create properties
    private $username;
    private $password;
    private $email;
    private $firstname;
    private $lastname;

    public function __construct($db) {
      $this->$conn = $db;
    }

    // add your function ex. findAll, findById, createUser
    public function read() {
      $query = "SELECT * FROM user";
      $stmt = $this->$conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }
  }
?>