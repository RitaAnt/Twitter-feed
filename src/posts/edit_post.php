<?php
require_once('../includes/db.php');
print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post-id']) && isset($_POST['edited-content'])) {
    $post_id = $_POST['post-id'];
    $edited_content = $_POST['edited-content'];

    $sql_update_post = "UPDATE posts SET content = '$edited_content' WHERE id = $post_id";

    if ($conn->query($sql_update_post) === TRUE) {
        echo "success"; 
    } else {
        echo "Ошибка при удалении поста: " . $conn->error;
        print_r($_POST);
    }
} else {
    echo "Неверный метод запроса.";
    print_r($_POST);
}
$conn->close();
