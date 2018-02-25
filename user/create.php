<?php
    require_once("../config/post_header.php");
    include_once("../config/database.php");

    include_once("../model/user.php");

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    // get posted data
    // $data = json_decode(file_get_contents("php://input"));
    // print_r($data);
    $user->username = $_POST["username"];
    $user->password = $_POST["password"];
    $user->personal_id = $_POST["personal_id"];
    
    $result = $user->create();
    echo $result;
?>