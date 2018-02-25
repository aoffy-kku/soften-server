<?php
  class Database {
    private $host = "localhost";
    private $db_name = "sec01_nmb";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __contruct() {
      $this->host = getenv("DB_HOST", true)? getenv("DB_HOST", true): getenv("DB_HOST");
      $this->db_name = getenv("DB_NAME", true)? getenv("DB_NAME", true): getenv("DB_NAME");
      $this->username = getenv("DB_USERNAME", true)? getenv("DB_USERNAME", true): getenv("DB_USERNAME");
      $this->password = getenv("DB_PASSWORD", true)? getenv("DB_PASSWORD", true): getenv("DB_PASSWORD");
    }

    public function getConnection() {
      $this->conn = null;
      try {
        $this->conn = new PDO(
          "mysql:host=" .$this->host. ";"
          ."dbname=" .$this->db_name,
          $this->username,
          $this->password
        );
        $this->conn->exec("set names utf8");
      } catch(PDOException $e) {
        echo "Connection error: " .$e->getMessage();
      }
      return $this->conn;
    }
  }
?>