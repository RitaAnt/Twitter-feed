<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваша страница</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
<?php include_once("includes/navbar.php"); ?>
<?php
if(isset($_SESSION['user_id'])) {

    require_once('includes/db.php');

    $user_id = $_SESSION['user_id'];

    $sql_user = "SELECT * FROM users WHERE id = $user_id";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();

    echo "<h1>Добро пожаловать, {$user['login']}!</h1>";


    $sql_posts = "SELECT posts.*, users.login AS user_login FROM posts INNER JOIN users ON posts.user_id = users.id";
    $result_posts = $conn->query($sql_posts);
    if($result_posts->num_rows > 0) {
        echo "<h2>Ваши посты:</h2>";
        while($post = $result_posts->fetch_assoc()) {
            echo "<div id='posts'>";
            echo "<div id='posts-div'>";
            echo "<h3 id='posts-author'>Автор: {$post['user_login']}</h3>";
            echo "<p id='posts-content'>{$post['content']}</p>";
            echo "<p id='posts-data'>{$post['created_at']}</p>";
            echo "<p id='posts-likes'>{$post['likes']}<button id='posts-like-button'>♥</button></p>";
            echo "</div></div>";
        }
    } else {
        echo "<div>У вас нет постов.</div>";
    }
    
} else {
    header('Location: index.php');
}
?>
</body>
</html>