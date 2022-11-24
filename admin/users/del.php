<?php
    require_once '../model/db.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM users where user_id =$id ";
        $query = mysqli_query($conn, $sql);
        header('location: ./index.php?menu=2');
    }
?>