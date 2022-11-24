<?php 
    require_once 'dbExtra.php';

    // define('EMAIL', 'haokhuy@gamil.com');
    // define('PASSWORD','ooubwhmyfbrwdaju');

    // define('DB_HOST','localhost');
    // define('DB_USER','root');
    // define('DB_PASS','');
    // define('DB_NAME','purgeshop');
    // $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // if($conn->connect_error){
    //     die('Database error: ' .$conn->connect_error);
    // }
    $text ="SELECT * FROM ";
    $table = "products,sale ";
    $where = "where sale.sale_id = products.sale_id ";
    $saleText = "";
    $perPage = 3;

    if( isset($_GET['page'])){
        $pageID=  $_GET['page'];   
        $start = ($pageID-1)*$perPage;
        if(isset($_GET['category'])){         
            $category =  $_GET['category'];
            if($category=='all'){
                // if(isset($_GET['sale'])){
                //     $sale = $_GET['sale'];
                //     if($sale == 0){
                //         echo "<script>alert($saleText)</script>";
                //     }
                //     else{
                //         $saleText = "check_sale=1 and percent=" .$sale;
                //         echo "<script>alert('$saleText')</script>";
                //     }
                // }
                if(isset( $_GET['filter'])){
                    $filter= ($_GET['filter']);
                    // echo json_encode($filter);
                    $table = "products,sale ";
                    $where = "where sale.sale_id = products.sale_id and ( ";
                    if(!empty($filter["size"])){
                        $table = "products,sale,store ";
                        $where ="where sale.sale_id = products.sale_id and store.prd_id = products.prd_id and (";
                        foreach($filter["size"] as $a){
                            $where .= "size='" .$a . "' or ";
                         }
                    }
                    if(!empty($filter["price"])){
                        foreach($filter["price"] as $a){
                            switch($a){
                                case '100000':
                                    $where.= "price<100000 or ";
                                    break;
                                case '100000-200000':
                                    $where.= "(price>=100000 and price<200000) or ";
                                    break;
                                case '200000-300000':
                                    $where.= "(price>=200000 and price<300000) or ";
                                    break;
                                case '300000-500000':
                                    $where.= "(price>=300000 and price<=500000) or ";
                                    break;
                                case '500000':
                                    $where.= "price>500000 or ";
                                    break;
                            }

                            
                         }
                    }
        
                    if(!empty($filter["color"])){
                        foreach($filter["color"] as $a){
                            $where .= "color='" .$a . "' or ";
                         }
                    }
        
                    
                    
                    // echo $text;
                    
                    
                    
                    $where=substr($text, 0, -4);
                    $where.=")";
                    // echo $text. "---";
                    $sql = "$text $table $where limit $start, $perPage";  
                    // echo $sql;
                    $result = mysqli_query($conn, $sql);
                    $sql_pagination = "$text $table $where";  
                    // echo $sql_pagination;
                    $result_pagination = mysqli_query($conn, $sql_pagination);
                }
                else{
                    $sql = "SELECT * FROM products,sale where sale.sale_id = products.sale_id limit $start, $perPage";
                    $result = mysqli_query($conn, $sql);
                    $sql_pagination = "SELECT * FROM products,sale where sale.sale_id = products.sale_id";  
                    $result_pagination = mysqli_query($conn, $sql_pagination);
                }
            }
            else{
               
                if(isset( $_GET['filter'])){
                $text ="SELECT * FROM products, sale where category='" .$category. "' and sale.sale_id = products.sale_id  and ( " ;

                    $filter= ($_GET['filter']);
                    // echo json_encode($filter);
                    if(!empty($filter["size"])){
                         $text ="SELECT * FROM products, sale, store where category='" .$category. "' and sale.sale_id = products.sale_id and products.prd_id = store.prd_id  and ( " ;
                        foreach($filter["size"] as $a){
                            $text .= "size='" .$a . "' or ";
                         }
                    }
                    if(!empty($filter["price"])){
                        foreach($filter["price"] as $a){
                            switch($a){
                                case '100000':
                                    $text .= "price<100000 or ";
                                    break;
                                case '100000-200000':
                                    $text .= "(price>=100000 and price<200000) or ";
                                    break;
                                case '200000-300000':
                                    $text .= "(price>=200000 and price<300000) or ";
                                    break;
                                case '300000-500000':
                                    $text .= "(price>=300000 and price<=500000) or ";
                                    break;
                                case '500000':
                                    $text .= "price>500000 or ";
                                    break;
                            }

                            
                         }
                    }
        
                    if(!empty($filter["color"])){
                        foreach($filter["color"] as $a){
                            $text .= "color='" .$a . "' or ";
                         }
                    }
        
                    
                    
                    // echo $text;
                    
                    
                    
                     $text=substr($text, 0, -3);
                     $text.=" )";
                     echo $text. "////";
                    $sql = "$text  limit $start, $perPage";  
                    echo $sql;      
                 $result = mysqli_query($conn, $sql);
                 $sql_pagination = "$text";  
                    $result_pagination = mysqli_query($conn, $sql_pagination);
                }
                else{
                    $sql = "SELECT * FROM products, sale where category = '$category' and sale.sale_id = products.sale_id  limit $start, $perPage";
                    $result = mysqli_query($conn, $sql);
                    $sql_pagination = "SELECT * FROM products, sale where category = '$category' and sale.sale_id = products.sale_id";  
                    $result_pagination = mysqli_query($conn, $sql_pagination);
                }
            }
           
                      
        
            
        }
        
        
          
    }


    
?>




<div class="row" id="content-products">
<?php while($row = mysqli_fetch_assoc($result)){?>
    <div class="product-img col-4 col-xs-6 col-tb-4 play-on-scroll start">
        <a href="detailProduct.php?id=<?php echo $row['prd_id']?>">
        <img src="view/img/<?php echo $row['image_front']?>" alt="">
        <div class="name-product">
            <?php echo $row['prd_name'];?>
        </div>
        <div class="price-product">
            <?php echo number_format($row['price']);?>₫
        </div>      
        <span class="state-product"><?php if(!empty($row['check_sale'])){ echo $row['percent']. "%";}?></span>
        </a>
    </div>
    <?php } ?>
</div>


<?php $totalProduct = mysqli_num_rows($result_pagination);
        $totalPages = ceil($totalProduct/$perPage);
        // echo $totalPages;?>


<?php if(!empty($totalPages)){ ?>
    <div class="pagination">
                            <ul>
                                <li class="previous-pag"><i class="bx bxs-chevrons-left"></i></li>
                                <?php 
                            for($i=1;$i<=$totalPages;$i++)
                            {?>
                                    <?php if($i==$pageID){?>
                                    <li class="page-index active">
                                        <?php echo $i; ?>
                                    </li>
                                    <?php }else{ ?>
                                        <li class="page-index">
                                        <?php echo $i; ?>
                                    </li>
                                    <?php } ?>
                                <?php } ?>

                                <li class="next-pag"><i class="bx bxs-chevrons-right"></i></li>
                            </ul>
                        </div>
    


<?php } ?>


