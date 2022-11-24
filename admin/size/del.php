<?php
    require_once '../model/db.php';
    require_once './onload.php';

    $size_id = $_GET['id'];
    $sql = "DELETE FROM size WHERE size_id = $size_id";
    $result = mysqli_query($conn, $sql);
    // addLog($conn, $staff_id, " đã xóa quyền ID:".$power_id);
    echo '<script> location.href = "index.php?menu=10"  </script>';

?>