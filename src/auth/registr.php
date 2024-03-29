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
    
    <form action="signup.php" method="post">
        <label>Логин:</label>
        <input type="text" required placeholder="Введите логин" name="login">

        <label>Пароль:</label>
        <input type="password" required placeholder="Введите пароль" name="pass">

        <label>Подтверждение пароля:</label>
        <input type="password" required placeholder="Подтвердите пароль" name="repeatpass">

        <label>Почта:</label>
        <input type="email" required placeholder="Введите почту" name="email">

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