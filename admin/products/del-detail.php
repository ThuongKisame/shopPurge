<?php
     require_once '../model/db.php';
      require_once './onload.php';
         $detail_prd_id = $_GET['idDetail'];

        
      //   addLog($conn, $staff_id, " đã xóa sản phẩm ".$prd_name);


        $sql = "DELETE FROM detail_product_size WHERE detail_prd_id = $detail_prd_id";
        $result = mysqli_query($conn ,$sql);

        $sql = "DELETE FROM detail_product WHERE detail_prd_id = $detail_prd_id";
        $result = mysqli_query($conn ,$sql);

        echo '<script> location.href = "index.php?menu=1"  </script>';
?>