<?php
  require_once("../config/post_header.php");

  include_once("../config/database.php");

  include_once("../model/user.php");

  $database = new Database();
  $db = $database->getConnection();

  $user = new User($db);

  $data = json_decode(file_get_contents("php://input"));

  $user->username = $data->username;
  
  $result = $user->checkUsernameForResetPW();

  echo $result;
?>
