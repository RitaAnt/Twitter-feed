<?php

require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM `users` WHERE login = '$login' AND password = '$pass'";
$result = $conn -> query($sql);

if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()){
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['id'];
        echo $user;
        //header('Location: ../../src/profile.php');
    }
} else{
    header('Location: ../../src/index.php');
}