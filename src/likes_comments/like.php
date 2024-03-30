<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['postId'];
    $user_id = $_SESSION['user_id'];

    // Проверяем, существует ли уже лайк от этого пользователя к этому посту
    $sql_check_like = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id";
    $result_check_like = $conn->query($sql_check_like);

    if ($result_check_like->num_rows == 0) {
        // Если лайка нет, добавляем его
        $sql_add_like = "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)";
        if ($conn->query($sql_add_like) === TRUE) {
            // Увеличиваем счетчик лайков у поста
            $sql_update_likes = "UPDATE posts SET likes = likes + 1 WHERE id = $post_id";
            $conn->query($sql_update_likes);
            // Возвращаем обновленное количество лайков
            $sql_count_likes = "SELECT likes FROM posts WHERE id = $post_id";
            $result_count_likes = $conn->query($sql_count_likes);
            $row_count_likes = $result_count_likes->fetch_assoc();
            echo $row_count_likes['likes'];
        } else {
            echo "Ошибка: " . $conn->error;
        }
    } else {
        // Если лайк уже существует, удаляем его
        $sql_delete_like = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
        if ($conn->query($sql_delete_like) === TRUE) {
            // Уменьшаем счетчик лайков у поста
            $sql_update_likes = "UPDATE posts SET likes = likes - 1 WHERE id = $post_id";
            $conn->query($sql_update_likes);
            // Возвращаем обновленное количество лайков
            $sql_count_likes = "SELECT likes FROM posts WHERE id = $post_id";
            $result_count_likes = $conn->query($sql_count_likes);
            $row_count_likes = $result_count_likes->fetch_assoc();
            echo $row_count_likes['likes'];
        } else {
            echo "Ошибка: " . $conn->error;
        }
    }
}
$conn->close();
?>
