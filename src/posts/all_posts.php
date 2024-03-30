<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лента постов пользователей</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<?php include_once("../includes/navbar.php"); ?>
    <h1>Лента постов пользователей</h1>
    
    <?php
        require_once('../includes/db.php'); 

        $sql = "SELECT posts.*, users.login AS user_login FROM posts INNER JOIN users ON posts.user_id = users.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div id='posts'>";
                echo "<div id='posts-div'>";
                echo "<h3 id='posts-author'>Автор: {$row['user_login']}</h3>";
                echo "<p id='posts-content'>{$row['content']}</p>";
                echo "<p id='posts-data'>{$row['created_at']}</p>";
                echo "<p id='posts-likes'>{$row['likes']}<button id='posts-like-button' data-post-id='{$row['id']}'>♥</button></p>";
                echo "</div></div>";
            }
        } else {
            echo "<div>Постов пока нет.</div>";
        }

    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $("#posts-like-button").click(function(){
        var postId = $(this).data("post-id"); 
        var likesCountElement = $(this).closest('#posts-div').find('#posts-likes');
        $.post("../likes_comments/like.php", {postId: postId}, function(data, status){
           
            likesCountElement = data[1];
            alert("Данные: " + data + "\nСтатус: " + status);
        });
    });
});

</script>

</body>
</html>
