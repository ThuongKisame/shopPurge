<?php
    require_once '../model/db.php';
    require_once './onload.php';

    $power_id = $_GET['id'];
    $sql = "DELETE FROM power_detail  WHERE power_id = $power_id";
    $query = mysqli_query($conn, $sql);
    $sql = "DELETE FROM power  WHERE power_id = $power_id";
    $query = mysqli_query($conn, $sql);
    addLog($conn, $staff_id, " đã xóa quyền ID:".$power_id);
    echo '<script> location.href = "index.php?menu=8"  </script>';

?>