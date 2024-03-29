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

        <label>Почта:</label>
        <input type="password" placeholder="Введите пароль" name="pass" required>

        <button type="submit">Войти</button>
    </form>

    <div>
        <p> Впервые на сайте?<a href="auth/registr.php">Зарегистрируйся! </a></p>
    </div>
    

</body>
</html>