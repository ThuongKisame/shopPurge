<?php
    require_once '../model/db.php';
    require_once './onload.php';

    $category_id = $_GET['id'];
    $sql = "DELETE FROM category WHERE category_id = $category_id";
    $result = mysqli_query($conn, $sql);
    // addLog($conn, $staff_id, " đã xóa quyền ID:".$power_id);
    echo '<script> location.href = "index.php?menu=12"  </script>';

?>