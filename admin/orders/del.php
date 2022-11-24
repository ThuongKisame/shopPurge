<?php
    require_once '../model/db.php';
    $order_id = $_GET['id'];
    $sql = "DELETE FROM orders where order_id=$order_id";
    $query = mysqli_query($conn, $sql);
    header('location: ./index.php?menu=5');
?>