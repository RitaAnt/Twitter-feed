<?php
require_once('../includes/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post-id']) && isset($_POST['edited-content'])) {
    $post_id = $_POST['post-id'];
    $edited_content = $_POST['edited-content'];
    
    $sql_update_post = "UPDATE posts SET content = ? WHERE id = ?";
    $stmt_update_post = $conn->prepare($sql_update_post);

    if (!$stmt_update_post) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt_update_post->bind_param("si", $edited_content, $post_id);

    if ($stmt_update_post->execute()) {
        echo "success";
    } else {
        echo "Ошибка при изменении поста: " . $stmt_update_post->error;
    }
}
 else {
    echo "Неверный метод запроса.";
}
$conn->close();
