<?php
session_start();

if(isset($_SESSION['user_id'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('../includes/db.php');

        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO posts (content, user_id) VALUES ('$content', '$user_id')";

        if($conn->query($sql) === TRUE) {
            header("Location: ../profile.php");
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    } else {
        header("Location: create_post.php");
    }
} else {
    header('Location: index.php');
}
?>
