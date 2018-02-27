<?php
  class News {
    // create connection and table name first
    private $conn;
    private $table_name = "news";

    // create properties
    public $news_id;
    public $news_topic;
    public $news_detail;
    public $news_cover;
    public $author;
    public $created_at;
    public $updated_at;
    public $enabled;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function readByLimit($start, $end) {
      $query = "SELECT * FROM "
        .$this->table_name.
        " ORDER BY created_at DESC LIMIT :start,:end";
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue(":start", (int) $start, PDO::PARAM_INT);
      $stmt->bindValue(":end", (int) $end, PDO::PARAM_INT);
      try {
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0) {
          $news_arr = array();
          $news_arr["success"] = true;
          $news_arr["message"]  = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $news_item = array(
              "news_id" => $news_id,
              "news_topic" => $news_topic,
              "news_detail" => $news_detail,
              "news_cover" => $news_cover,
              "author" => $author,
              "created_at" => $created_at,
              "updated_at" => $updated_at,
            );
            array_push($news_arr["message"], $news_item);
          }
          return json_encode($news_arr);
        } else {
          return json_encode(array(
            "success" => false,
            "message" => "news is empty.",
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