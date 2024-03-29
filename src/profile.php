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

<?php
if(isset($_SESSION['user_id'])) {

    require_once('includes/db.php');

    $user_id = $_SESSION['user_id'];

    $sql_user = "SELECT * FROM users WHERE id = $user_id";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();

    echo "<h1>Добро пожаловать, {$user['login']}!</h1>";


    $sql_posts = "SELECT * FROM posts WHERE user_id = $user_id";
    $result_posts = $conn->query($sql_posts);
    echo "<div>";
    if($result_posts->num_rows > 0) {
        echo "<h2>Посты пользователя</h2>";
        while($post = $result_posts->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h3>{$post['title']}</h3>";
            echo "<h4>{$post['content']}</h4>";
            echo "<p>{$post['likes']}</p>";
            echo "</div>";
        }
    } else {
        echo "<p>У вас нет постов.</p>";
    }
    echo "<a href='posts/create_post.php'>Создать пост</a></div>";
} else {
    header('Location: index.php');
}
?>

</body>
</html>