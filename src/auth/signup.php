<?php
require_once('../includes/db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];
$repeatpass = $_POST['repeatpass'];
$email = $_POST['email'];

// Проверка на совпадение паролей
if ($pass != $repeatpass) {
    session_start();
    $_SESSION['message'] = 'Пароли не совпадают!';
    header('Location: registr.php');
    exit();
} else {
    // Хэширование пароля
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Проверка на существование логина
    $check_login_sql = "SELECT * FROM `users` WHERE login = ?";
    $stmt_check_login = $conn->prepare($check_login_sql);
    if (!$stmt_check_login) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt_check_login->bind_param("s", $login);
    $stmt_check_login->execute();
    $check_login_result = $stmt_check_login->get_result();
    if ($check_login_result->num_rows > 0) {
        session_start();
        $_SESSION['message'] = 'Данный логин занят!';
        header('Location: registr.php');
        exit();
    }

    // Проверка на существование почты
    $check_email_sql = "SELECT * FROM `users` WHERE email = ?";
    $stmt_check_email = $conn->prepare($check_email_sql);
    if (!$stmt_check_email) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $check_email_result = $stmt_check_email->get_result();
    if ($check_email_result->num_rows > 0) {
        session_start();
        $_SESSION['message'] = 'Данная почта занята!';
        header('Location: registr.php');
        exit();
    }

    // Если логин и почта уникальны, создаем нового пользователя
    $sql = "INSERT INTO `users` (login, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt->bind_param("sss", $login, $hashedPassword, $email);
    if ($stmt->execute()) {
        session_start();
        $_SESSION['message'] = 'Пользователь успешно создан!';
        header('Location: ../index.php');
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}
?>
