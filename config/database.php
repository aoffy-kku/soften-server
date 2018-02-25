<?php
  class Database {
    private $host = "10.199.66.227";
    private $db_name = "sec01_nmb";
    private $username = "Sec01_NMB";
    private $password = "B89tN0b1";
    public $conn;

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