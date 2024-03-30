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

        $sql = "SELECT posts.*, users.login AS user_login FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div id='posts'>";
                echo "<div id='posts-div'>";
                echo "<h3 id='posts-author'>Автор: {$row['user_login']}</h3>";
                echo "<p id='posts-content'>{$row['content']}</p>";
                echo "<p id='posts-data'>{$row['created_at']}</p>";
                echo "<div id='like-button'><p id='posts-likes'>{$row['likes']}</p>";
                echo "<button class='posts-like-button' data-post-id='{$row['id']}'>♥</button>";
                echo "</div></div>";
                echo "<button class='show-comment-form-button' data-post-id={$row['id']}>Оставить комментарий</button></div>";

            }
        } else {
            echo "<div>Постов пока нет.</div>";
        }

    ?>
<div class="comment-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Оставить комментарий</h2>
    <form id="comment-form" action="../likes_comments/comment.php" method="post">
      <textarea name="comment" id="comment" placeholder="Введите ваш комментарий" required></textarea>
      <input type="hidden" name="post_id" id="post-id">
      <button type="submit">Отправить</button>
    </form>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $(".posts-like-button").click(function(){
        var postId = $(this).data("post-id"); 
        var likesCountElement = $(this).closest('#posts-div').find('#posts-likes');
        $.post("../likes_comments/like.php", {postId: postId}, function(data, status){
            likesCountElement.text(data);
        });
    });
});
$(document).ready(function(){
  $(".show-comment-form-button").click(function(){
    var postId = $(this).data("post-id"); 
    $("#post-id").val(postId);
    $(".comment-modal").show();
  });

  $(".close").click(function(){
    $(".comment-modal").hide();
  });

  $(window).click(function(event) {
    if (event.target == $(".comment-modal")[0]) {
      $(".comment-modal").hide();
    }
  });
});

</script>

</body>
</html>
