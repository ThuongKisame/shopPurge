<?php
    require_once '../model/db.php';
    if(isset($_GET['id']) && isset($_GET['size'])){
        $id = $_GET['id'];
        $size = $_GET['size'];
        $sql = "DELETE FROM store where prd_id=$id and size = '$size'";
        $query = mysqli_query($conn, $sql);
        echo '<script> location.href = "index.php?menu=3"  </script>';
    }
?>