<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $content = $_POST['comment'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO comments (content, created_at, post_id, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt->bind_param("ssii", $content, $created_at, $post_id, $user_id);
    
    
    if ($stmt->execute()) {
        echo "Комментарий успешно добавлен!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
$conn->close();
?>
