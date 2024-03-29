<?php
session_start();


if(isset($_SESSION['user_id'])) {
    require_once('includes/db.php');



} else {

    header('Location: index.php');
}
?>
