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


    $sql_posts = "SELECT * from posts where user_id = $user_id";
    $result_posts = $conn->query($sql_posts);
    if($result_posts->num_rows > 0) {
        echo "<h2>Редактирование постов</h2>";
        while($post = $result_posts->fetch_assoc()) {
            echo "<div id='posts'>";
            echo "<div id='posts-div'>";
            echo "<h3 id='posts-author'>Автор: {$user['login']}</h3>";
            echo "<p id='posts-content'>{$post['content']}</p>";
            echo "<p id='posts-data'>{$post['created_at']}</p>";
            echo "<div id='like-button'><p id='posts-likes'>{$post['likes']}</p>";
            echo "<button class='posts-like-button' data-post-id='{$post['id']}'>♥</button>";
            echo "<button class='posts-edit-button'>Изменить</button>";
            echo "<button class='posts-delete-button' data-post-id='{$post['id']}'>Удалить</button></p>";
            echo "</div></div></div>";

        }
    } else {
        echo "<div>У вас нет постов.</div>";
    }
    
} else {
    header('Location: index.php');
}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $(".posts-like-button").click(function(){
        var postId = $(this).data("post-id"); 
        var likesCountElement = $(this).closest('#posts-div').find('#posts-likes');
        $.post("likes_comments/like.php", {postId: postId}, function(data, status){
            likesCountElement.text(data);
        });
    });
});
$(document).ready(function(){
    $(".posts-delete-button").click(function(){
        var postId = $(this).data("post-id"); 
        var postElement = $(this).closest("#posts"); 
        if(confirm("Вы уверены, что хотите удалить этот пост?")) {
            $.post("posts/delete_post.php", {postId: postId}, function(data, status){
                if (data === "success") {
                    postElement.hide(); 
                } else {
                    alert("Ошибка при удалении поста.");
                }
            });
        }
    });
});


</script>
</body>
</html>