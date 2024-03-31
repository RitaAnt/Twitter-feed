<?php
session_start();

if(isset($_SESSION['user_id'])) {
    require_once('../includes/db.php');

    $user_id = $_SESSION['user_id'];
    $subscribed_user_id = $_POST['userId'];
    $sql = "INSERT INTO follow (follower_id, following_id) VALUES (?, ?)";

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
