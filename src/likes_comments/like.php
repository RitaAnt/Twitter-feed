<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['postId'];
    $user_id = $_SESSION['user_id'];

    // проверяем, существует ли уже лайк от этого пользователя к этому посту
    $sql_check_like = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt_check_like = $conn->prepare($sql_check_like);
    if (!$stmt_check_like) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt_check_like->bind_param("ii", $post_id, $user_id);
    $stmt_check_like->execute();
    $result_check_like = $stmt_check_like->get_result();

    if ($result_check_like->num_rows == 0) {
        // если лайка нет, добавляем его
        $sql_add_like = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt_add_like = $conn->prepare($sql_add_like);
        if (!$stmt_add_like) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt_add_like->bind_param("ii", $post_id, $user_id);
    
        if ($stmt_add_like->execute()) {

            // увеличиваем счетчик лайков у поста
            $sql_update_likes = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
            $stmt_update_likes = $conn->prepare($sql_update_likes);
            if (!$stmt_update_likes) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt_update_likes->bind_param("i", $post_id);
            $stmt_update_likes->execute();

            // возвращаем обновленное количество лайков
            $sql_count_likes = "SELECT likes FROM posts WHERE id = ?";
            $stmt_count_likes = $conn->prepare($sql_count_likes);
            if (!$stmt_count_likes) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt_count_likes->bind_param("i", $post_id);
            $stmt_count_likes->execute();

            $result_count_likes = $stmt_count_likes->get_result();
            $row_count_likes = $result_count_likes->fetch_assoc();

            echo $row_count_likes['likes'];
        } else {
            echo "Ошибка: " . $stmt_add_like->error;
        }
    }
    else {
        $sql_delete_like = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt_delete_like = $conn->prepare($sql_delete_like);
        if (!$stmt_delete_like) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt_delete_like->bind_param("ii", $post_id, $user_id);

        if ($stmt_delete_like->execute()) {

            // уменьшаем счетчик лайков у поста
            $sql_update_likes = "UPDATE posts SET likes = likes - 1 WHERE id = ?";
            $stmt_update_likes = $conn->prepare($sql_update_likes);
            if (!$stmt_update_likes) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt_update_likes->bind_param("i", $post_id);
            $stmt_update_likes->execute();

            // возвращаем обновленное количество лайков
            $sql_count_likes = "SELECT likes FROM posts WHERE id = ?";
            $stmt_count_likes = $conn->prepare($sql_count_likes);
            if (!$stmt_count_likes) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt_count_likes->bind_param("i", $post_id);
            $stmt_count_likes->execute();

            $result_count_likes = $stmt_count_likes->get_result();
            $row_count_likes = $result_count_likes->fetch_assoc();
            
            echo $row_count_likes['likes'];
        } else {
            echo "Ошибка: " . $stmt_delete_like->error;
        }
    }
}
$conn->close();