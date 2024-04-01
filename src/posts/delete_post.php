<?php
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['postId'])) {
        $post_id = $_POST['postId'];
    
        $sql_delete_comments = "DELETE FROM comments WHERE post_id = ?";
        $stmt_delete_comments = $conn->prepare($sql_delete_comments);
        if (!$stmt_delete_comments) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt_delete_comments->bind_param("i", $post_id);
        if ($stmt_delete_comments->execute()) {
            $sql_delete_post = "DELETE FROM posts WHERE id = ?";
            $stmt_delete_post = $conn->prepare($sql_delete_post);

            if (!$stmt_delete_post) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt_delete_post->bind_param("i", $post_id);
            
            if ($stmt_delete_post->execute()) {
                echo "success";
            } else {
                echo "Ошибка при удалении поста: " . $stmt_delete_post->error;
            }
        } else {
            echo "Ошибка при удалении комментариев: " . $stmt_delete_comments->error;
        }
    } else {
        echo "Идентификатор поста не указан.";
    }
    
} else {
    echo "Неверный метод запроса.";
}

$conn->close();
