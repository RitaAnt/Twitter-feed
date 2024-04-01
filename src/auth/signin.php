<?php
session_start();
require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM `users` WHERE login = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        header('Location: ../profile.php');
    } else {
        $_SESSION['message'] = "Пароль неправильный";
        header('Location: ../index.php');
    }
} else {
    $_SESSION['message'] = "Такого пользователя нет";
    header('Location: ../index.php');
}
