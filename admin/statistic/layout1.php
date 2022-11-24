<?php
require_once '../../model/db.php';

    if(isset($_GET['from']) && isset($_GET['to'])){
        function jsonData($orderID, $conn){

            

            $category = array('tee', 'pants', 'jacket', 'hoodie', 'accessories', 'sweater');
            foreach($category as $i){
                $sql_prd= "SELECT * FROM detail_order, products WHERE products.prd_id = detail_order.prd_id and order_id in $orderID and category='$i'";
                $result_prd = mysqli_query($conn, $sql_prd);
                $amounts = 0;
                $revenue = 0;
                $prdArray = array();
                while($item_prd = mysqli_fetch_assoc($result_prd)){
                    $amounts+=$item_prd['quantity'];
                    $revenue+=$item_prd['price']*$item_prd['quantity']-$item_prd['price']*$item_prd['quantity']*$item_prd['sale']/100;
                    array_push($prdArray, ["prd_id"=> $item_prd['prd_id'], "quantity"=>$item_prd['quantity'], "sale_name"=>$item_prd['sale_name'], "percent"=>$item_prd['sale']]);
        
                }
    
                $json[] = ["category"=>"$i", "amounts"=>$amounts, "revenue"=>$revenue, "prd"=>$prdArray];
        
    
                
    
            }
            return $json;
        }


        function dataProduct($json, $conn){
            
    
            $prdAllAfter = array();
            foreach($json as $i){
                if(isset($prdAllAfter[$i['prd_id']])){
                    $prdAllAfter[$i['prd_id']]+=$i['quantity'];
                }
                else{
                    $prdAllAfter[$i['prd_id']]=$i['quantity'];
                }
            }
    
    
            $prdIDBestSeller = 0;
            $quantityBestSeller = 0;
    
            foreach($prdAllAfter as $i=>$value){
                if($value > $quantityBestSeller){
                    $quantityBestSeller = $value;
                    $prdIDBestSeller = $i;
                }
            }

            return ["prd_id" => $prdIDBestSeller, "quantity"=>$quantityBestSeller];
        }


        $time_start = $_GET['from'];
        $time_end = $_GET['to'];

        $time_start = substr($time_start, 0 , 10)." ".substr($time_start, 12 , 16).":00";
        $time_end = substr($time_end, 0 , 10)." ".substr($time_end, 12 , 16).":00";

        
        $orderID = '(';     


        $sql_time = "SELECT * FROM orders WHERE date between '$time_start' and '$time_end'";
        $result_time = mysqli_query($conn, $sql_time);
        $totalOrders = mysqli_num_rows($result_time);
        if(empty($totalOrders)){
            echo '<script>
                alert("Không có dữ liệu!!");
                // window.location.href = "./index.php?menu=7";
            </script>';
        }
        
            while($time = mysqli_fetch_assoc($result_time)){
            $orderID .= $time['order_id'].",";  
           
            
        }

        $orderID = substr($orderID, 0, -1);
        $orderID .=")";


        $sql_get_sale = "SELECT * FROM sale WHERE (date_start between '$time_start' and '$time_end') or (date_end between '$time_start' and '$time_end')";
        $result_get_sale = mysqli_query($conn, $sql_get_sale);
        while($itemSale = mysqli_fetch_assoc($result_get_sale)){
           $sale[] = ["name"=>$itemSale['sale_name'], "percent"=>$itemSale['percent']];      
        }
        
    


        

        // print_r(json_encode($data));



        // foreach($data as $i){
        //     $time = $i['date'];
        //     $orderCount = 0;
        //     foreach($i['order'] as $j){
        //         $orderCount++;

        //     }
        // }


        $json = jsonData($orderID, $conn);
        // print_r(json_encode($json));
        // print_r(dataProduct($json, $conn));


        

        foreach($json as $i){
            $dataP[] = ["label"=>$i['category'], "y"=>$i['amounts']];
        }
            
        




        
        
        
        
        
    }
    


?>


<div class="row">
    <div class="col-4">
        <div href="#0" class="button-blue">
            <span class="style"></span>
            <div class="digit"><?php echo $totalOrders; ?></div>
            <h6><span>đơn hàng</span></h6>
            <!-- <ul class="listItem">
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>


            </ul> -->
            <span class="style-right"></span>
        </div>
    </div>
    <div class="col-4">
        <div href="#0" class="button-blue">
            <span class="style"></span>
            <div class="digit"><?php $sum=0; foreach($json as $i){
                    $sum+=$i['amounts'];
            } echo $sum;?></div>
            <h6><span>sản phẩm</span><i class='bx bxs-chevron-down'></i></h6>
            <ul class="listItem">

            <?php
                foreach($json as $i){
                    ?>
                        <li><strong><?php echo $i['category'] ?>: </strong><span><?php echo $i['amounts'] ?></span></li>
                    <?php
                }
            
            ?>
                <!-- <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li> -->


            </ul>
            <span class="style-right"></span>
        </div>
    </div>
    <div class="col-4">
        <div href="#0" class="button-blue">
        
            <span class="style"></span>
            <div class="digit"><?php echo count($sale); ?></div>
            <h6><span>Chương trình giảm giá</span><i class='bx bxs-chevron-down'></i></h6>
            <ul class="listItem">

            <?php
                foreach($sale as $i){
                    ?>
                            <li><strong><?php echo $i['name']; ?>: </strong><span><?php echo $i['percent']; ?>%</span></li>


                    <?php
                }
            
            ?>
                <!-- <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li> -->


            </ul>
            <span class="style-right"></span>
        </div>
    </div>
    <div class="col-6">
        <div href="#0" class="button-blue">
        <?php
            $arrayPrd = array();
            foreach($json as $i){
                foreach($i['prd'] as $j){
                    array_push($arrayPrd, $j);
                }
            }


            $objPrd = dataProduct($arrayPrd, $conn);
            $prd_id = $objPrd['prd_id'];
            $sqlBestSeller = "SELECT * FROM products WHERE prd_id = $prd_id";
            $resultBestSeller = mysqli_query($conn, $sqlBestSeller);
            $itemBestSeller = mysqli_fetch_assoc($resultBestSeller);
        ?>
            <span class="style"></span>
            <div class="digit">
            <img style="width: 20%" src="../view/img/<?php echo $itemBestSeller['image_front'] ?>" alt="">

                <p><?php echo $itemBestSeller['prd_name'] ?></p>
                <span><?php echo $objPrd['quantity'] ?></span>

            </div>
            <h6><span>Bán chạy nhất</span><i class='bx bxs-chevron-down'></i></h6>
            <ul class="listItem">

                <?php
                    foreach($json as $i ){
                        $prd = dataProduct($i['prd'], $conn);
                        $prd_id = $prd['prd_id'];
                        $sqlBestSeller = "SELECT * FROM products WHERE prd_id = $prd_id";
                        $resultBestSeller = mysqli_query($conn, $sqlBestSeller);
                        $itemBestSeller = mysqli_fetch_assoc($resultBestSeller);

                        ?>
                             <li><strong><?php echo $i['category'] ?>: </strong><span><?php if(!empty($itemBestSeller['prd_name'])){echo $itemBestSeller['prd_name'];}else{echo 'None';} echo '('.$prd['quantity'].')'; ?></span></li>
                        <?php
                        
                    }
            
                    
                
                ?>
                <!-- <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li>
                <li><strong>Tee: </strong><span>0</span></li> -->


            </ul>
            <span class="style-right"></span>
        </div>
    </div>
    <div class="col-6">
        <div href="#0" class="button-blue">
            <?php
                $sum=0;
                foreach($json as $i){
                    $sum+=$i['revenue'];
                }
            
            ?>
            <span class="style"></span>
            <div class="digit"><?php  echo number_format($sum) ?>VND</div>
            <h6><span>Doanh thu</span><i class='bx bxs-chevron-down'></i></h6>
            <ul class="listItem">
            <?php
                foreach($json as $i){
                    ?>
                        <li><strong><?php echo $i['category'] ?>: </strong><span><?php echo number_format($i['revenue']); ?>VND</span></li>

                    <?php
                }
            
            ?>
               


            </ul>
            <span class="style-right"></span>
        </div>
    </div>
</div>
<div id="chartCircleContainer" style="height: 370px; width: 100%;"></div>
<div class="form-group">
    <select name="type" class="form-control" id="typeStatistic" >
        <option value="date" selected="selected">Thống kê theo ngày</option>
        <option value="month" >Thống kê theo tháng</option>
        <option value="year" >Thống kê theo năm</option>                                   
    </select>
<div class="form-group">
    <select name="type" class="form-control" id="category">
        <option value="all" selected="selected">Tất cả sản phẩm</option>
        <option value="tee" >Tee</option>
        <option value="jacket" >Jacket</option>
        <option value="hoodie" >Hoodie</option>      
        <option value="sweater" >Sweater</option>                                  
        <option value="pants" >Pants</option>
        <option value="accessories" >Accessories</option>                                  
    </select>
</div>
<div id="renderTable" >
    
</div>


<script>

var chartCircle = new CanvasJS.Chart("chartCircleContainer", {
	animationEnabled: true,
	title: {
		text: "Chart products"
	},
	subtitles: [{
		text: "<?php echo $time_start."    -    ".$time_end;?>"
	}],
	data: [{
		type: "pie",
        indexLabel: "{label} - #percent%",
		yValueFormatString: "#,##0.00\"%\"",
		// indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataP, JSON_NUMERIC_CHECK); ?>
	}]
});
chartCircle.render();


    $(function() {
        $btn = $('.button-blue h6 i');
        $btn.on('click', function() {
            $parentsEl = $(this).parent().parent();
            $list = $parentsEl.find('.listItem');
            $list.slideToggle();
        })

       
        $to = '<?php echo $time_end;?>';
        $from = '<?php echo $time_start;?>';



        $category = $('#category');
        $typeStatistic = $('#typeStatistic');
        $tableEl = $('#renderTable');
        getDataTable($category.val(), $typeStatistic.val(),$to, $from);

        $category.on('change', function(){
            getDataTable($category.val(), $typeStatistic.val(),$to, $from);
        })
        $typeStatistic.on('change', function(){
            getDataTable($category.val(), $typeStatistic.val(),$to, $from);
        })

        function getDataTable($category, $typeStatistic, $to, $from){
            $.ajax({
                type: 'GET',
                url: './statistic/renderTable.php',
                data: {
                    category: $category,
                    typeStatistic: $typeStatistic,
                    to: $to,
                    from: $from
                },
                success: function(data){
                    $tableEl.html(data);
                },
                error: function(){

                }
            })
        }
    })


    
</script>

