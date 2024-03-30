<?php
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['postId'])) {
        $post_id = $_POST['postId'];

        $sql_delete_comments = "DELETE FROM comments WHERE post_id = $post_id";

        if ($conn->query($sql_delete_comments) === TRUE) {
            
            $sql_delete_post = "DELETE FROM posts WHERE id = $post_id";

            if ($conn->query($sql_delete_post) === TRUE) {
                echo "Пост и связанные с ним комментарии успешно удалены.";
            } else {
                echo "Ошибка при удалении поста: " . $conn->error;
            }
        } else {
            echo "Ошибка при удалении комментариев: " . $conn->error;
        }
    } else {
        echo "Идентификатор поста не указан.";
        print_r($_POST);
    }
} else {
    echo "Неверный метод запроса.";
}

$conn->close();
