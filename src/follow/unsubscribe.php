<?php
session_start();

if(isset($_SESSION['user_id'])) {
    require_once('../includes/db.php');

    $user_id = $_SESSION['user_id'];
    $subscribed_user_id = $_POST['userId'];
    $sql = "DELETE FROM follow WHERE follower_id = ? AND following_id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $user_id, $subscribed_user_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo "success";
} else {
    echo "unauthenticated";
}
