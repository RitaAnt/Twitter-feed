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


<!-- Лента личных постов с возможностью лайкать, редактировать и удалять их -->
<?php include_once("includes/navbar.php"); 
if(isset($_SESSION['user_id'])) {

    require_once('includes/db.php');

    //получаем нашего юзера и его данные
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM users WHERE id = $user_id";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();

    echo "<h1>Добро пожаловать, {$user['login']}!</h1>";

    //ищем посты юзера и выводим их
    $sql_posts = "SELECT * from posts where user_id = $user_id";
    $result_posts = $conn->query($sql_posts);
    if($result_posts->num_rows > 0) {
        echo "<h2>Редактирование постов</h2>";
        while($post = $result_posts->fetch_assoc()) {
            echo "<div id='posts'>";
            echo "<div id='posts-div'>";
            echo "<h3 id='posts-author'>Автор: {$user['login']}</h3>";
            echo "<p class='posts-content'>{$post['content']}</p>";
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

    <!-- Модальное окно, появляющееся при нажатии на кнопку "Изменить". -->
    <!-- НЕ ПЕРЕЗАГРУЖАЕТ СТРАНИЦУ, ТРЕБУЕТ ДОРАБОТКИ -->
    <div id="edit-post-form" class="comment-modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Редактировать пост</h2>
            <form id="edit-form" action="edit_post.php" method="post">
                <textarea name="edited-content" id="edited-content" rows="8" cols="50" placeholder="Введите отредактированный пост" required></textarea>
                <input type="hidden" name="post-id" id="edit-post-id" value="">
                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Скрипт для лайка, автоматически обновляющий данные при нажатии -->
    <!-- При существовании лайка от данного юзера на данном посте, лайк снимается -->
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

        //Скрипт для лайка, автоматически обновляющий данные при нажатии. При существовании лайка от данного юзера на данном посте, лайк снимается
        $(document).ready(function(){
            $(".posts-delete-button").click(function(){
                var postId = $(this).data("post-id"); 
                var postElement = $(this).closest("#posts"); 
                if(confirm("Вы уверены, что хотите удалить этот пост?")) {
                    $.post("posts/delete_post.php", {postId: postId}, function(data, status){
                        if (data === "success") {
                            postElement.hide(); 
                        } else {
                            alert("Ошибка при удалении поста." + data);
                        }
                    });
                }
            });
        });

        // Скрипт для 
        $(document).ready(function(){
            $(".posts-edit-button").click(function(){
                var postId = $(this).attr("data-post-id"); 
                var postContent = $(this).closest("#posts-div").find(".posts-content").text(); 
                $("#edit-post-id").val(postId); 
                $("#edited-content").val(postContent); 
                $("#edit-post-form").show(); 
            });

            $("#edit-form").submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize(); 
                $.post("posts/edit_post.php", formData, function(data, status){
                    if (data === "success") {
                        var postId = $("#edit-post-id").val();
                        var editedContent = $("#edited-content").val();
                        $(".posts-content[data-post-id='" + postId + "']").html(editedContent);
                        $(".comment-modal").hide();
                        location.reload();
                    } else {
                        alert("Ошибка при изменении поста");
                    }
                });
            })
            
            // Прячет модальное окно при нажатии на "х"
            $(".close").click(function(){
                $(".comment-modal").hide();
            });

            // Прячет модальное окно при натажии на фон
            $(window).click(function(event) {
                if (event.target == $(".comment-modal")[0]) {
                    $(".comment-modal").hide();
                }
            });
        });;
        
    </script>
</body>
</html>