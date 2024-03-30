<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новый пост</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<?php include_once("../includes/navbar.php"); ?>
    <div>
    <h1>Создание нового поста</h1>
        <form action="process_create_post.php" method="post">

            <label for="content">Содержание:</label>
            <textarea id="content" name="content" rows="8" cols="50" required></textarea><br>
            <button type="submit">Создать пост</button>
        </form>
        </div>
        <h3 class="message">
            <?php
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
    </h3>
</body>
</html>