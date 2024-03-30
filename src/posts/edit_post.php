<?php
require_once('../includes/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post-id']) && isset($_POST['edited-content'])) {
    $post_id = $_POST['post-id'];
    $edited_content = $_POST['edited-content'];

    $sql_update_post = "UPDATE posts SET content = '$edited_content' WHERE id = $post_id";

    if ($conn->query($sql_update_post) === TRUE) {
        echo "success"; 
    } else {
        echo "Ошибка при изменении поста: " . $conn->error;
    }
} else {
    echo "Неверный метод запроса.";
}
$conn->close();
