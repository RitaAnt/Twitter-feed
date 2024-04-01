<?php
session_start();

if(isset($_SESSION['user_id'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('../includes/db.php');

        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];

        if(strlen($content) > 512) {
            $_SESSION['message'] = "Содержимое поста слишком длинное. Максимальное количество символов - 512.";
            header("Location: create_post.php");
            exit;
        } else {
            $sql = "INSERT INTO posts (content, user_id) VALUES (?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("si", $content, $user_id);

            if($stmt->execute()) {
                header("Location: ../profile.php");
            } else {
                echo "Ошибка: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        header("Location: ../index.php");
    }
} else {
    header('Location: ../index.php');
}
?>
