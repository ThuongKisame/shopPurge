<?php
    require_once '../model/db.php';
    if(isset($_GET['id'])){
        $staff_id = $_GET['id'];
        $sql = "DELETE FROM staff where staff_id=$staff_id ";
        $query = mysqli_query($conn, $sql);
        echo '<script> location.href = "index.php?menu=6"  </script>';
    }
?>