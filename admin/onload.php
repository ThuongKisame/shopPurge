<?php

if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['staff_id']);       
    header('location: login.php');
    exit();
}

if(isset($_SESSION['id'])&&$_SESSION['staff_id']){
    $staff_id =  $_SESSION['staff_id'];
    $staff_name = $_SESSION['staff_name'];

        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // $getDay= date("Y-m-d H:i:s");
        // $sql_sale = "SELECT * FROM sale WHERE date_start <= '$getDay' and date_end >= '$getDay'";
        // $result_sale = mysqli_query($conn, $sql_sale);
        // if(!empty(mysqli_num_rows($result_sale))){
        //     $itemSale = mysqli_fetch_assoc($result_sale);
        //     $sale_id = $itemSale['sale_id'];
        //     if($itemSale['category']=='all'){
        //         $sql_prd = "UPDATE products SET sale_id = $sale_id";
        //         $result_prd = mysqli_query($conn, $sql_prd);
        //     }
        //     else{
        //         $arrayCategory = explode("-", $itemSale['category']);
        //         foreach($arrayCategory as $i=>$value){
        //             $sql_prd = "UPDATE products SET sale_id = $sale_id WHERE category = '$value'";
        //             $result_prd = mysqli_query($conn, $sql_prd);
                    
        //         }
        //     }
    
            
        // }
        // else{
        //     $sql_prd = "UPDATE products SET sale_id = 0 ";
        //         $result_prd = mysqli_query($conn, $sql_prd);
        // }

       



function addLog($conn, $staff_id, $message){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
    $sql_get_staff = "SELECT * FROM staff, power WHERE staff.power_id = power.power_id AND staff_id = $staff_id";
    $result_get_staff = mysqli_query($conn, $sql_get_staff);
    $itemStaff = mysqli_fetch_assoc($result_get_staff);
    $email = $itemStaff['email'];
    $power = $itemStaff['power_name'];
    $activity = 'Tài khoản '.$email.' ('.$power.')'.$message;
    $sqlLog = "INSERT INTO log(time, activity) VALUES('$getDay', '$activity')";
    $resultLog = mysqli_query($conn, $sqlLog);
}
}
else{
    header('location: login.php');
}
?>
