<?php

require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];
$repeatpass = $_POST['repeatpass'];
$email = $_POST['email'];

if($pass != $repeatpass){
    session_start();
    $_SESSION['message'] = 'Пароли не совпадают!';
    header('Location: registr.php');

} else{
    $sql = "INSERT INTO `users` (login, password, email) VALUES ('$login', '$pass', '$email')";

    if($conn -> query($sql)){
        session_start();
        $_SESSION['message'] = 'Пользователь успешно создан!';
        header('Location: ../index.php');
    } else {
        echo "Ошибка: ". $conn -> error;
    }
}

