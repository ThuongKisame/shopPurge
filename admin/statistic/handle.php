<?php
require_once '../../model/db.php';
    if(isset($_GET['type']) && isset($_GET['from']) && isset($_GET['to'])){
        $type = $_GET['type'];
        $time_start = $_GET['from'];
        $time_end = $_GET['to'];

        $time_start = substr($time_start, 0 , 10)." ".substr($time_start, 12 , 16).":00";
        $time_end = substr($time_end, 0 , 10)." ".substr($time_end, 12 , 16).":00";

       
        $sql = "SELECT * FROM orders ORDER BY date DESC";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        $item = mysqli_fetch_assoc($result);
        echo $time_start."  ".$item['date'];
        if($time_start > $item['date']){
            echo "ok";
        }
        else{
            echo "no";
        }
        $products = 0;
        $totalPrice=0;
        $amounts=0;
        $num=0;
        switch($type){
            case 'date':
                $num = 10;
                break;
            case 'month':
                $num = 7;
                break;
            case 'year':
                $num = 4;
                break;
        }
        $key = substr($item['date'], 0, $num);
        if(!empty($key)){
            $order_id = $item['order_id'];
            $sql_prd = "SELECT * FROM detail_order, products WHERE detail_order.prd_id = products.prd_id AND detail_order.order_id = $order_id";
            $result_prd = mysqli_query($conn, $sql_prd);
            $products = mysqli_num_rows($result_prd);
            while($prd= mysqli_fetch_assoc($result_prd)){
                $totalPrice += $prd['price']*$prd['quantity'];
            }
            $amounts++;
        }
        while($item = mysqli_fetch_assoc($result)){
            if($time_start <= $item['date'] && $item['date']<=$time_end){
                // echo $item['date']."  ".$time_start."  ".$time_end;
                
                $i = substr($item['date'], 0, $num);
                if($i == $key){
                    $order_id = $item['order_id'];
                    $sql_prd = "SELECT * FROM detail_order, products WHERE detail_order.prd_id = products.prd_id AND detail_order.order_id = $order_id";
                    $result_prd = mysqli_query($conn, $sql_prd);
                    $products = mysqli_num_rows($result_prd);
                     while($prd= mysqli_fetch_assoc($result_prd)){
                    $totalPrice += $prd['price']*$prd['quantity'];
                    }
                    $amounts++;
                }
                else{
                    $arr[] = ['date' => $key, 'amounts' => $amounts, 'products' => $products, 'totalPrice' => $totalPrice];
                    $products = 0;
                    $totalPrice=0;
                    $amounts=0;
                    $key = $i;
                    if($i == $key){
                        $order_id = $item['order_id'];
                        $sql_prd = "SELECT * FROM detail_order, products WHERE detail_order.prd_id = products.prd_id AND detail_order.order_id = $order_id";
                        $result_prd = mysqli_query($conn, $sql_prd);
                        $products = mysqli_num_rows($result_prd);
                        while($prd= mysqli_fetch_assoc($result_prd)){
                            $totalPrice += $prd['price']*$prd['quantity'];
                        }
                            $amounts++;
                    }
                }
            }
        }
        $arr[] = ['date' => $key, 'amounts' => $amounts, 'products' => $products, 'totalPrice' => $totalPrice];

        
        $json = json_encode($arr);

        print_r($json);


    }
    


?>
