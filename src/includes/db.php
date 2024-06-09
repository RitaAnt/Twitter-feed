<?php

$servername = "db";
$username = "user";
$password = "pass";
$dbname = "db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("connection failed".mysqli_connect_error());
} else {
    "success";
}
