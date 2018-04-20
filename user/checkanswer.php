<?php
  require_once("../config/post_header.php");

  include_once("../config/database.php");

  include_once("../model/user.php");

  $database = new Database();
  $db = $database->getConnection();

  $user = new User($db);

  $data = json_decode(file_get_contents("php://input"));

  $user->username = $data->username;
  $user->answer1 = $data->answer1;
  $user->answer2 = $data->answer2;
  $user->answer3 = $data->answer3;
  
  $result = $user->checkAnswer();

  echo $result;
?>