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
            $sql = "INSERT INTO posts (content, user_id) VALUES ('$content', '$user_id')";

            if($conn->query($sql) === TRUE) {
                header("Location: ../profile.php");
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    } else {
        header("Location: ../index.php");
    }
} else {
    header('Location: ../index.php');
}

