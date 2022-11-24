<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id']) && isset($_GET['state'])){
        $order_id = $_GET['id'];
        $state = $_GET['state'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
        if($state == 1){
            $flag=true;
            $sqlCheck = "SELECT * FROM detail_order
            WHERE order_id=  $order_id";
            $resultCheck = mysqli_query($conn, $sqlCheck);
            while($itemCheck = mysqli_fetch_assoc($resultCheck)){ 
                $quantity = $itemCheck['quantity'];
                $detail_prd_size_id = $itemCheck['detail_prd_size_id'];
                $sql1 = "SELECT * FROM detail_product_size 
                WHERE detail_prd_size_id = $detail_prd_size_id
                AND $quantity <=quantity";
                $result1 =mysqli_query($conn, $sql1);
                if(mysqli_num_rows($result1)==0){
                    $flag = false;
                }
            }

            if($flag == false){
                echo '<script> alert("Không đủ số lượng trong kho!")</script>';
                echo '<script> location.href = "index.php?menu=5"  </script>';
            }
            else{
                $text = 2;
                $date = 'date_confirm';
                addLog($conn, $staff_id, " đã xác nhận đơn hàng ID:".$order_id);
                $sql2 = "SELECT * FROM detail_order
                WHERE order_id=  $order_id";
                $result2 = mysqli_query($conn, $sql2);
                while($item = mysqli_fetch_assoc($result2)){ 
                    $quantity = $item['quantity'];
                    $detail_prd_size_id = $item['detail_prd_size_id'];
                    $sql1 = "UPDATE detail_product_size SET quantity = quantity-$quantity WHERE detail_prd_size_id = $detail_prd_size_id";
                    $result1 =mysqli_query($conn, $sql1);
                }
            }
            
        }
        if($state == 2){
            $text = 3;
            $date = 'date_complete';
            addLog($conn, $staff_id, " đã xác nhận xử lý xong đơn hàng ID:".$order_id);

        }
        if($state == 6){
            $text = 5;
            $date = 'date_cancel';
            addLog($conn, $staff_id, " đã hủy đơn hàng ID:".$order_id);
            $sql2 = "SELECT * FROM detail_order
            WHERE order_id=  $order_id";
            $result2 = mysqli_query($conn, $sql2);
            while($item = mysqli_fetch_assoc($result2)){
                $quantity = $item['quantity'];
                $detail_prd_size_id = $item['detail_prd_size_id'];
                $sql1 = "UPDATE detail_product_size SET quantity = quantity+$quantity WHERE detail_prd_size_id = $detail_prd_size_id";
                $result1 =mysqli_query($conn, $sql1);
            }
            
        }
        $sql = "UPDATE orders SET state = $text, $date = '$getDay'  WHERE order_id = $order_id ";
        $query = mysqli_query($conn, $sql);
        // if($query){
        //     echo "ok";
        // }
        // else{
        //     echo "ndasd";
        // }
        echo '<script> location.href = "index.php?menu=5"  </script>';
    }
?>