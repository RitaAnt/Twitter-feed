<?php
session_start();
require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM `users` WHERE login = '$login' AND password = '$pass'";
$result = $conn -> query($sql);

if($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    session_start();
    $_SESSION['user_id'] = $user['id'];

    header('Location: ../profile.php');
} else {
    $_SESSION['message'] = "Такого пользователя нет(";
    header('Location: ../index.php');
}
