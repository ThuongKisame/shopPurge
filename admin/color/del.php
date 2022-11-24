<?php
    require_once '../model/db.php';
    require_once './onload.php';

    $color_id = $_GET['id'];
    $sql = "DELETE FROM color WHERE color_id = $color_id";
    $result = mysqli_query($conn, $sql);
    // addLog($conn, $staff_id, " đã xóa quyền ID:".$power_id);
    echo '<script> location.href = "index.php?menu=11"  </script>';

?>