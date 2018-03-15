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
    $user->personal_image = $_POST["personal_image"];
    $user->flname = $_POST["flname"];
    $user->email = $_POST["email"];
    $user->birthday = $_POST["birthday"];
    $user->answer1 = $_POST["answer1"];
    $user->answer2 = $_POST["answer2"];
    $user->answer3 = $_POST["answer3"];
   
    $result = $user->create();
    echo $result;
?>