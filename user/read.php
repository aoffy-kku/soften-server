<?php
  // require important headr
  include_once("../config/get_header.php");

  // get database connection
  include_once("../config/database.php");

  // get model
  include_once("../model/user.php");
  
  // create object database
  $database = new Database();

  // get connection from database
  $db = $database->getConnection();

  // create object user with database connection
  $user = new User($db);

  $result = $user->read();
  
  echo $result;

?>