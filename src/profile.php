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
            echo "<button class='posts-edit-button' data-post-id='{$post['id']}'>Изменить</button>";
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

<div id="edit-post-form" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Редактировать пост</h2>
        <form id="edit-form" action="edit_post.php" method="post">
            <textarea name="edited-content" id="edited-content" placeholder="Введите отредактированный пост" required></textarea>
            <input type="hidden" name="post-id" id="edit-post-id" value="">
            <button type="submit">Сохранить изменения</button>
        </form>
    </div>
</div>



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
$(document).ready(function(){
    $(".posts-edit-button").click(function(){
        var postId = $(this).attr("data-post-id"); 
        console.log("Post ID:", postId); // Отладочная информация
        var postContent = $(this).closest("#posts-div").find("#posts-content").text(); 
        $("#edit-post-id").val(postId); 
        $("#edited-content").val(postContent); 
        $("#edit-post-form").show(); 
    });

    $("#edit-form").submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize(); 
        $.post("posts/edit_post.php", formData, function(data, status){
            console.log("Response data:", data); // Отладочная информация
            if (data === "success") {
                // Обновление содержимого поста на странице
                var postId = $("#edit-post-id").val();
                var editedContent = $("#edited-content").val();
                console.log("Post ID:", postId); // Отладочная информация
                console.log("Edited content:", editedContent); // Отладочная информация
                var postContentElement = $("#posts-content[data-post-id='" + postId + "']");
                console.log("Post content element:", postContentElement); // Отладочная информация
                postContentElement.text(editedContent);
                
                // Скрыть модальное окно
                $("#edit-post-form").hide();
                alert("Пост успешно изменен");
            } else {
                alert(data);
            }
        });
    });
});


</script>
</body>
</html>