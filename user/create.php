<?php
    require_once("../config/post_header.php");
    include_once("../config/database.php");

    include_once("../model/user.php");

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $user->username = $data->username;
    $user->password = $data->password;
    $user->personal_id = $data->personal_id;
    $user->personal_image = $data->personal_image;
    $user->flname = $data->flname;
    $user->email = $data->email;
    $user->birthday = $data->birthday;
    $user->question1 = $data->question1;
    $user->answer1 = $data->answer1;
    $user->question2 = $data->question2;
    $user->answer2 = $data->answer2;
    $user->question3 = $data->question3;
    $user->answer3 = $data->answer3;

    
   
    $result = $user->create();
    echo $result;
?>