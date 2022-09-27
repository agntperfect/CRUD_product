<?php
    date_default_timezone_set('Asia/Kathmandu'); 
    session_start();
    $host = "127.0.0.1";
    $port = 33061;
    $user = "root";
    $pass = "";
    $db = "ecom";
    $conn = mysqli_connect($host, $user, $pass, $db, $port);
?>