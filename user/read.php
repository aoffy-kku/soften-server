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

  $stmt = $user->read();
  $rows = $stmt->rowCount();

  if($rows > 0) {
    $user_arr = array();
    $user_arr["success"] = true;
    $user_arr["data"]  = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $user_item = array(
        "username" => $username,
        "created_at" => $created_at,
        "updated_at" => $updated_at,
        "role" => $role,
      );

      array_push($user_arr["data"], $user_item);
    }
    echo json_encode($user_arr);
  } else {
    echo json_encode(array(
      "success" => false,
    ));
  }

?>