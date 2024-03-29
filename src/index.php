<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

    <form action="auth/signin.php" method="post">
        <label>Логин:</label>
        <input type="text" required placeholder="Введите логин" name="login">

        <label>Почта:</label>
        <input type="password" required placeholder="Введите пароль" name="pass">

        <button type="submit">Войти</button>
    </form>

    <div>
        <p> Впервые на сайте?<a href="auth/registr.php">Зарегистрируйся! </a></p>
    </div>
    

</body>
</html>