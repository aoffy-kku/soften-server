<?php
  class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __contruct() {
      $this->host = "10.199.66.227";
      $this->db_name = "sec01_nmb";
      $this->username = "Sec01_NMB";
      $this->password = "B89tN0b1";
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