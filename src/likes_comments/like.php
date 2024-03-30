<?php
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['postId'];
    $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $post_id";

    if ($conn->query($sql) === TRUE) {
        $sql_count = "SELECT likes FROM posts WHERE id = $post_id";
        $result = $conn->query($sql_count);
        $row = $result->fetch_assoc();
        echo $row['likes'];
    } else {

        echo "Ошибка: " . $conn->error;
    }
}
?>
