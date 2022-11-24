<?php
     require_once '../model/db.php';
      require_once './onload.php';
         $prd_id = $_GET['id'];

        $sql= "SELECT * FROM detail_product WHERE prd_id = $prd_id";
        $result = mysqli_query($conn, $sql);
        while($item = mysqli_fetch_assoc($result)){
            $detail_prd_id = $item['detail_prd_id'];
            $sql1= "DELETE FROM detail_product_size WHERE detail_prd_id = $detail_prd_id";
            $result1 = mysqli_query($conn ,$sql1);
        }
      //   addLog($conn, $staff_id, " đã xóa sản phẩm ".$prd_name);


        $sql = "DELETE FROM detail_product WHERE prd_id = $prd_id";
        $result = mysqli_query($conn ,$sql);

        $sql = "DELETE FROM products WHERE prd_id = $prd_id";
        $result = mysqli_query($conn ,$sql);

        
     
     
   
        echo '<script> location.href = "index.php?menu=1"  </script>';
?>