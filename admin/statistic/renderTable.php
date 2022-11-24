<?php

require_once '../../model/db.php';



if(isset($_GET['category']) && isset($_GET['typeStatistic']) && isset($_GET['to']) && isset($_GET['from']) ){
    $type= $_GET['typeStatistic'];
    $time_start = $_GET['from'];
    $time_end = $_GET['to'];
    $timeArray = array();

    $sql_time = "SELECT * FROM orders WHERE date between '$time_start' and '$time_end'";
        $result_time = mysqli_query($conn, $sql_time);
        $totalOrders = mysqli_num_rows($result_time);
        while($time = mysqli_fetch_assoc($result_time)){
            switch($type){
                case 'date': 
                    array_push($timeArray, substr($time['date'], 0, 10));
                    break;
                case 'month':
                    array_push($timeArray, substr($time['date'], 0, 7));
                    break;
                case 'year':
                    array_push($timeArray, substr($time['date'], 0, 4));
                    break;
            }
            
        }

        $timeArray = array_unique($timeArray);


    $category = $_GET['category'];
    if($category!='all'){
        $whereCategory = " and category='".$category."'";
    }
    else 
    {
        $whereCategory='';
    }
    // $timeArray = $_GET['timeArray'];
    // $type = $_GET['type'];

    foreach($timeArray as $i){
            
        switch($type){
            case 'date': 
                $date = $i." 00:00:00' and '".$i." 23:59:59";
                break;
            case 'month':
                $date = $i."-01 00:00:00' and '".$i."-31 23:59:59";
                break;
            case 'year':
                $date = $i."-01-01 00:00:00' and '".$i."-12-31 23:59:59";
                break;
        }
        

        $sql = "SELECT * FROM orders 
        WHERE date between '$date'";
        $result = mysqli_query($conn, $sql);
        $totalOrders = mysqli_num_rows($result);


        $totalPrd = 0;
        $revenue = 0;
        $bestSeller = 'None';
        $bestSeller_quantity = 0;
        $sql1 = "SELECT sum(quantity*price - quantity*price*percent/100) as 'revenue', sum(quantity) as 'quantity'  FROM orders, detail_order 
        WHERE date between '$date'
        AND detail_order.order_id = orders.order_id 
        $whereCategory";
        $result1 = mysqli_query($conn, $sql1);
        if(!empty(mysqli_num_rows($result1))){
            
            $item = mysqli_fetch_assoc($result1);
            if($item['quantity']!=''){
                $totalPrd = $item['quantity'];
                $revenue=$item['revenue'];
            }
            }
            
        

        $sql = "SELECT prd_name, sum(quantity) as 'quantity'  FROM orders, detail_order 
        WHERE date between '$date'
        AND detail_order.order_id = orders.order_id
        $whereCategory 
        group by prd_name order by quantity desc";
        $result = mysqli_query($conn, $sql);
        if(!empty(mysqli_num_rows($result))){
            $item = mysqli_fetch_assoc($result);
            $bestSeller = $item['prd_name'];
            $bestSeller_quantity=$item['quantity'];
        }
        

        $json[]=["date"=>$i, "totalOrders"=>$totalOrders, "totalPrd"=>$totalPrd, "revenue"=>$revenue, "bestSeller"=>$bestSeller, "bestSeller_quantity"=>$bestSeller_quantity];

    }

    // print_r(json_encode($json));
        
        // $arrayProduct = array();
        // while($item = mysqli_fetch_assoc($result)){
        //     $arrayProduct[]=["category_name"=>$item['category'], "quantity"=>$item['quantity'], "revenue"=>$item['revenue']];
        // }



        // while($itemType = mysqli_fetch_assoc($result_get_date_type)){
        //     $order_id = $itemType['order_id'];
        //     $countOrder++;
        //     $sqlPrd = "SELECT *  FROM detail_order, products WHERE order_id = $order_id AND products.prd_id = detail_order.prd_id $whereCategory";
        //     $resultPrd = mysqli_query($conn, $sqlPrd);
        //     while($itemPrd = mysqli_fetch_assoc($resultPrd)){
        //         $quantity+=$itemPrd['quantity'];
        //         $revenue+=$itemPrd['quantity']*$itemPrd['price'];
        //         array_push($prd, ["prd_id"=>$itemPrd['prd_name'], "quantity"=>$itemPrd['quantity']]);
        //     }

        // }
    //     // print_r($prd);
    //     $bestSeller = dataProduct($prd, $conn);
    //     $dataStatistic[] = ["date"=>$i, "order"=>$countOrder, "quantity"=>$quantity, "revenue"=>"$revenue", "bestSellerName"=>$bestSeller['prd_id'], "bestSellerQuantity"=>$bestSeller['quantity']]; 
    // }





}

foreach($json as $i){
    $dataPoints[] = ["y" => $i['totalOrders'], "label" => $i['date']];
}

foreach($json as $i){
    $dataPoints1[] = ["y" => $i['totalPrd'], "label" => $i['date']];
}
// $dataPoints = array(
// 	array("y" => 25, "label" => "Sunday"),
// 	array("y" => 15, "label" => "Monday"),
// 	array("y" => 25, "label" => "Tuesday"),
// 	array("y" => 5, "label" => "Wednesday"),
// 	array("y" => 10, "label" => "Thursday"),
// 	array("y" => 0, "label" => "Friday"),
// 	array("y" => 20, "label" => "Saturday")
// );

    
?>
    
<table class="table">
<thead class="thead-dark">
        <tr>
            <th>STT</th>
            <th>Thời gian</th>
            <?php if($category!='all'){
                ?>
                    <th><?php echo $category ?></th>

                <?php
            }else{
                ?>
                    <th>Đơn hàng</th>
                    <th>Tất cả sản phẩm</th>
                <?php 
            } ?>
            <th>Bán nhiều nhất</th>
            <th>Doanh thu</th>
        </tr>
    </thead>
    <tbody>

    <?php
        $stt=0;
        foreach($json as $i){
            $stt++;
            ?>
            <tr>
                <td><?php echo $stt; ?></td>
                <td><?php echo $i['date'] ?></td>
                <?php if($category=='all'){
                ?>
                    <td><?php echo $i['totalOrders'] ?></td>


                <?php
            }
             ?>
                
                <td><?php echo $i['totalPrd'] ?></td>
                <th><?php echo $i['bestSeller']."(".$i['bestSeller_quantity'].")" ?></th>
                <td><?php echo number_format($i['revenue']) ?>VND</td>
                </tr>

            <?php

        }
                
    ?>
        
    </tbody>
    </table>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>

    <?php
 

 
?>

<script>


 




var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Chart <?php echo $category; ?> products "
	},
	axisY: {
		title: "Số lượng sản phẩm"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## đơn hàng",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	},
    {
		type: "line",
        yValueFormatString: "#,##0.## sản phẩm",
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 

</script>
    
    
