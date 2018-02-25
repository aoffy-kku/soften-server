<?php
  require_once("../config/post_header.php");

  include_once("../config/database.php");

  include_once("../model/user.php");

  $database = new Database();
  $db = $database->getConnection();

  $user = new User($db);

  $user->username = $_POST["username"];
  $user->password = $_POST["password"];
  
  $result = $user->signin();

  echo $result;
?>