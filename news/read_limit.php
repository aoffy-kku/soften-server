<?php
  // require important headr
  include_once("../config/get_header.php");

  // get database connection
  include_once("../config/database.php");

  // get model
  include_once("../model/news.php");
  
  // create object database
  $database = new Database();

  // get connection from database
  $db = $database->getConnection();

  // create object user with database connection
  $news = new news($db);

  //$data = json_decode(file_get_contents("php://input"));

  $start = $_GET["start"];
  $end = $_GET["end"];

  $result = $news->readByLimit($start, $end);
  
  echo $result;

?>