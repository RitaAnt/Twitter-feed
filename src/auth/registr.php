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
    <form class="registr-form" action="signup.php" method="post">
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


    <div class="registr-link">
        <p>Уже есть аккаунт?</p>
        <a href="../index.php">Войти</a>
    </div>

    <!-- Показывает ошибку в случае проблемы с регистрацией -->
    <h3 class="message">
        <?php
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        ?>
    </h3>

</body>
</html>