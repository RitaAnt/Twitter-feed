<?php
session_start();
?>

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

        <!-- Пагинация -->
        <div class="pagination">
        <?php require_once('../includes/db.php'); 
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $total_posts_sql = "SELECT COUNT(*) AS total_posts FROM posts";
        $total_posts_result = $conn->query($total_posts_sql);
        $total_posts_row = $total_posts_result->fetch_assoc();
        $total_posts = $total_posts_row['total_posts'];
        $posts_per_page = 3; 
        $total_pages = ceil($total_posts / $posts_per_page);
        ?>

        
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo ($current_page - 1); ?>">Предыдущая</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo ($current_page + 1); ?>">Следующая</a>
        <?php endif; ?>
    </div>

    <!-- Выводит нужные посты (3 на страницу) -->
    <?php
        require_once('../includes/db.php'); 

        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $posts_per_page = 3;
        $offset = ($current_page - 1) * $posts_per_page;

        $sql = "SELECT posts.*, users.login AS user_login,
                IF(follower_id IS NULL, 'Подписаться', 'Вы подписаны') AS subscription_status
                FROM posts 
                INNER JOIN users ON posts.user_id = users.id 
                LEFT JOIN follow ON follow.following_id = posts.user_id AND follow.follower_id = ?
                ORDER BY posts.created_at DESC 
                LIMIT $offset, $posts_per_page";
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }

            $user_id = $_SESSION['user_id'];
            $stmt->bind_param("i", $userId); // "i" указывает, что тип параметра - integer
            $stmt->execute();
            $result = $stmt->get_result();
            

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div id='posts'>";
                echo "<div id='posts-div'>";
                echo "<h3 id='posts-author'>Автор: {$row['user_login']}</h3>";
                if ($row['subscription_status'] === 'Вы подписаны') {
                    echo "<button class='subscribe-button' data-user-id='{$row['user_id']}' disabled>{$row['subscription_status']}</button>";
                } else {
                    echo "<button class='subscribe-button' data-user-id='{$row['user_id']}'>{$row['subscription_status']}</button>";
                }
                echo "<p class='posts-content'>{$row['content']}</p>";
                echo "<p id='posts-data'>{$row['created_at']}</p>";
                echo "<div id='like-button'><p id='posts-likes'>{$row['likes']}</p>";
                echo "<button class='posts-like-button' data-post-id='{$row['id']}'>♥</button>";
                echo "</div></div>";
                
                // Выводит комментарии к постам
                $post_id = $row['id'];
                $comments_sql = 
                "SELECT comments.*, 
                users.login AS comment_author
                FROM comments 
                LEFT JOIN 
                    users ON comments.user_id = users.id
                WHERE 
                    comments.post_id = $post_id
                ORDER BY 
                    comments.created_at ASC;";
                $comments_result = $conn->query($comments_sql);
        
                if ($comments_result->num_rows > 0) {
                    while($comment_row = $comments_result->fetch_assoc()) {
                        $comment_user_id = $comment_row['user_id'];
                        $comment_user_sql = "SELECT login FROM users WHERE id = $comment_user_id";
                        $comment_user_result = $conn->query($comment_user_sql);
                        $comment_user_data = $comment_user_result->fetch_assoc();
                        $comment_author = $comment_user_data['login'];
                        echo "<div class='comments'>";
                        echo "<div class='comments-div'>";
                        echo "<h3 class='comments-author'>{$comment_author}</h3>"; 
                        echo "<p class='comments-content'>{$comment_row['content']}</p>";
                        echo "<p class='comments-data'>{$comment_row['created_at']}</p>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p class='comment-no'>Комментариев пока нет.</p>";
                }
                echo "<button class='show-comment-form-button' data-post-id={$row['id']}>Оставить комментарий</button></div>";
            }
        } else {
            echo "<div>Постов пока нет.</div>";
        }

    ?>

    <!-- Модальное окно, появляющееся при нажатии на кнопку "Оставить комментарий" -->
    <div class="comment-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Оставить комментарий</h2>
            <form id="comment-form" action="../likes_comments/comment.php" method="post">
            <textarea name="comment" id="comment" rows="8" cols="50" placeholder="Введите ваш комментарий" required></textarea>
            <input type="hidden" name="post_id" id="post-id">
            <button type="submit">Отправить</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Скрипт для лайка, автоматически обновляющий данные при нажатии
        // При существовании лайка от данного юзера на данном посте, лайк снимается
        $(document).ready(function(){
            $(".posts-like-button").click(function(){
                var postId = $(this).data("post-id"); 
                var likesCountElement = $(this).closest('#posts-div').find('#posts-likes');
                $.post("../likes_comments/like.php", {postId: postId}, function(data, status){
                    likesCountElement.text(data);
                });
            });
        });

        // Скрипт комментария, автоматически обновляющий данные при отправке
        $(document).ready(function(){
            $("#comment-form").submit(function(event){
                event.preventDefault();
                var formData = $(this).serialize();

                $.post("../likes_comments/comment.php", formData, function(data, status){
                    if(status === "success") {
                        $(".comment-modal").hide();
                        location.reload();
                    }
                });
            });

            // Показывает модальное окно
            $(".show-comment-form-button").click(function(){
                var postId = $(this).data("post-id"); 
                $("#post-id").val(postId);
                $(".comment-modal").show();
            });

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
        });

        // Скрипт для подписки
        $(document).ready(function(){
            $(".subscribe-button").click(function(){
                var userId = $(this).data("user-id");
                var buttonText = $(this).text();
                if (buttonText === 'Подписаться') {
                    $.post("../follow/subscribe.php", {userId: userId}, function(data, status){
                        $(".subscribe-button[data-user-id='" + userId + "']").text('Вы подписаны').prop('disabled', true);
                    });
                } else {
                    $.post("../follow/unsubscribe.php", {userId: userId}, function(data, status){
                        $(".subscribe-button[data-user-id='" + userId + "']").text('Подписаться').prop('disabled', false);
                    });
                }
            });
        });

    </script>

</body>
</html>
