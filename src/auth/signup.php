<?php
require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];
$repeatpass = $_POST['repeatpass'];
$email = $_POST['email'];

// Проверка на совпадение паролей
// МОЖЕТ ДОБАВИТЬ ШИФРОВКУ ТИПО ЧТОБЫ В БД НЕ ХРАНИЛОСЬ В ОТКРЫТУЮ?
if ($pass != $repeatpass) {
    session_start();
    $_SESSION['message'] = 'Пароли не совпадают!';
    header('Location: registr.php');
} else {
    // Проверка на существование логина
    $check_login_sql = "SELECT * FROM `users` WHERE login = '$login'";
    $check_login_result = $conn->query($check_login_sql);
    if ($check_login_result->num_rows > 0) {
        session_start();
        $_SESSION['message'] = 'Данный логин занят!';
        header('Location: registr.php');
        exit();
    }

    // Проверка на существование почты
    $check_email_sql = "SELECT * FROM `users` WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_sql);
    if ($check_email_result->num_rows > 0) {
        session_start();
        $_SESSION['message'] = 'Данная почта занята!';
        header('Location: registr.php');
        exit();
    }

    // Если логин и почта уникальны, создаем нового пользователя
    $sql = "INSERT INTO `users` (login, password, email) VALUES ('$login', '$pass', '$email')";
    if ($conn->query($sql)) {
        session_start();
        $_SESSION['message'] = 'Пользователь успешно создан!';
        header('Location: ../index.php');
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
