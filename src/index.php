<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <h1>Вход в аккаунт</h1>
    <form action="auth/signin.php" method="post">
        <label>Логин:</label>
        <input type="text" placeholder="Введите логин" name="login" required>

        <label>Пароль:</label>
        <input type="password" placeholder="Введите пароль" name="pass" required>

        <button type="submit">Войти</button>
    </form>

    <div>
        <p> Впервые на сайте?<a href="auth/registr.php">Зарегистрируйся! </a></p>
    </div>
    
    <h3 class="message">
        <?php
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        ?>
    </h3>

</body>
</html>