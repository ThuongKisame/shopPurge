<?php 
    require_once 'dbExtra.php';

    $text ="SELECT * FROM ";
    $table = "products,sale,category, detail_product ";
    $where = "where sale.percent > 0 AND detail_product.prd_id = products.prd_id and sale.sale_id = products.sale_id and category.category_id = products.category_id  ";
    $saleText = "";
    // $saleText = "";
    $perPage = 3;

    if( isset($_GET['page'])){
        $pageID=  $_GET['page'];   
        $start = ($pageID-1)*$perPage;
        if(isset($_GET['category'])){         
            $category =  $_GET['category'];
            if($category!=='all'){
                $where.= "and products.category_id=$category ";
            }
        }
            if(isset( $_GET['filter'])){
                $filter= ($_GET['filter']);
                // echo json_encode($filter);
                
                if(!empty($filter["price"])){
                     $where .= "and ( ";
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
                     $where=substr($where, 0, -4);
                    $where.=")";
                }
        
                if(!empty($filter["color"])){
                    $table.=', color';
                    $where.='and detail_product.color_id = color.color_id and ( ';

                    foreach($filter["color"] as $a){
                        $where .= "color.color_id=" .$a . " or ";
                     }
                     $where=substr($where, 0, -4);
                    $where.=")";
                }
                

            
            }         
        
        
        $where.=' group by products.prd_id';
        $sql = "$text $table $where $saleText limit $start, $perPage";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        $sql_pagination = "$text $table $where $saleText";  
        $result_pagination = mysqli_query($conn, $sql_pagination);    
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
        <span class="state-product"><?php  echo $row['percent']. "%";?></span>
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


