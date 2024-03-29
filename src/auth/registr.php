<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
    <h1>Регистрация</h1>
    <form action="signup.php" method="post">
        <label>Логин:</label>
        <input type="text" placeholder="Введите логин" name="login" required>

        <label>Пароль:</label>
        <input type="password" placeholder="Введите пароль" name="pass" required>

        <label>Подтверждение пароля:</label>
        <input type="password" placeholder="Подтвердите пароль" name="repeatpass" required>

        <label>Почта:</label>
        <input type="email" placeholder="Введите почту" name="email" required>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <p>
        <?php
        echo $_SESSION['message']; 
        unset($_SESSION['message'])
        ?>
    </p>

    </body>
</html>