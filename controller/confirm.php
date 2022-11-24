<?php
    require_once 'dbExtra.php';
    if(isset($_GET['order_id']) && isset($_GET['state'])){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
        $order_id = $_GET['order_id'];
        
        $state = $_GET['state'];
        if($state ==3){
            $sql = "UPDATE orders SET state = 4, date_receipt = '$getDay' where order_id = $order_id";
            $result = mysqli_query($conn, $sql);
            if($result){
                echo '<button style="padding: .5rem 1rem; font-weight: bold;"> Đã nhận hàng</button>';
            }
        }
        if($state ==1){
            $sql = "UPDATE orders SET state = 5, date_cancel = '$getDay' where order_id = $order_id";
            $result = mysqli_query($conn, $sql);
            if($result){
                echo '<button style="padding: .5rem 1rem; font-weight: bold;"> Đơn hàng đã hủy</button>';
            }
        }
        
    }
?>