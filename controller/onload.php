<?php

require_once 'model/db.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
        $sql_sale = "SELECT * FROM sale WHERE date_start <= '$getDay' and date_end >= '$getDay'";
        // echo $sql_sale;
        $result_sale = mysqli_query($conn, $sql_sale);
        if(!empty(mysqli_num_rows($result_sale))){
            $itemSale = mysqli_fetch_assoc($result_sale);
            $sale_id = $itemSale['sale_id'];
            if($itemSale['category']=='all'){
                $sql_prd = "UPDATE products SET sale_id = $sale_id";
                $result_prd = mysqli_query($conn, $sql_prd);
            }
            else{
                $arrayCategory = explode("-", $itemSale['category']);
                foreach($arrayCategory as $i=>$value){
                    $sql_prd = "UPDATE products, category SET sale_id = $sale_id 
                    WHERE category.category_name = '$value'
                    AND category.category_id = products.category_id";
                    $result_prd = mysqli_query($conn, $sql_prd);
                    
                }
            }
    
            
        }
        else{
            $sql_prd = "UPDATE products SET sale_id = 0 ";
                $result_prd = mysqli_query($conn, $sql_prd);
        }



if(isset($_SESSION['id']) && isset($_SESSION['user_id']) ){
    // echo 'sadsad';
        $user_id = $_SESSION['user_id'];
    $nameUser = $_SESSION['nameUser'];
    $sql = "SELECT * FROM cart where user_id = $user_id";
    $resultInCart= mysqli_query($conn, $sql);
    $quantityInCart=0;
     while($row = mysqli_fetch_assoc($resultInCart)){
        $quantityInCart += $row['quantity_cart'];
    }
}

$sql_sale = "SELECT * FROM sale";
$result_sale = mysqli_query($conn, $sql_sale);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");
// echo $date_start. " ";
// echo $date_end. " ";
// echo $today;

while($sale = mysqli_fetch_assoc($result_sale)){
    $date_start = $sale['date_start'];
    $date_end = $sale['date_end'];
    $sale_id = $sale['sale_id'];
    if($date_start <= $today and $today <= $date_end){
        $sql_update = "UPDATE sale SET check_sale = 1 WHERE sale_id=$sale_id";
        $result_update = mysqli_query($conn, $sql_update);
    }
    else{
        $sql_update = "UPDATE sale SET check_sale = 0 WHERE sale_id=$sale_id";
        $result_update = mysqli_query($conn, $sql_update);
    }

}







?>