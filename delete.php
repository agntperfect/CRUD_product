<?php
    include "DB/index.php";
    if (isset($_GET['code'])) {
        $itemcode = (int) $_GET['code'];
        $sql = "UPDATE product SET is_delete=1 WHERE product_code = '$itemcode'";
        mysqli_query($conn, $sql);
        header('location: index.php');
    } else {
        header('location: index.php');
    }
?>