<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $content = $_POST['comment'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO comments (content, created_at, post_id, user_id) VALUES ('$content', '$created_at', '$post_id', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Комментарий успешно добавлен!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
$conn->close();
?>
