<?php
    require_once '../model/db.php';
    require_once './onload.php';

    $sale_id = $_GET['id'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $getDay= date("Y-m-d H:i:s");
    $sql_sale = "SELECT * FROM sale WHERE date_start <= '$getDay' and date_end >= '$getDay' AND sale_id = $sale_id";
    $result_sale = mysqli_query($conn, $sql_sale);
    if(!empty(mysqli_num_rows($result_sale))){
        $sql_prd = "UPDATE products SET sale_id = 0";
        $result_prd = mysqli_query($conn, $sql_prd);
    }

    addLog($conn, $staff_id, " đã xóa chương trình giảm giá ID: ".$sale_id);

    $sql = "DELETE sale FROM sale  WHERE sale_id = $sale_id";
    $query = mysqli_query($conn, $sql);
        echo '<script> location.href = "index.php?menu=4"  </script>';
?>