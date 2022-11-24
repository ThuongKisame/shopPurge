<?php
require_once 'controller/authController.php';
require_once 'controller/onload.php';
    if(isset($_GET['detail_prd_id'])&&isset($_GET['prd_id'])){
        
        $detail_prd_id = $_GET['detail_prd_id'];
        $prd_id = $_GET['prd_id'];
        $sql = "SELECT detail_product_size.detail_prd_size_id, size_name,  sum(quantity) as 'quantity' 
        FROM  products, detail_product, detail_product_size, size 
        WHERE products.prd_id = $prd_id  
        AND detail_product.prd_id = products.prd_id
        AND detail_product.detail_prd_id = detail_product_size.detail_prd_id 
        AND size.size_id = detail_product_size.size_id 
        AND detail_product.detail_prd_id = $detail_prd_id
        group by size_name";
        $result = mysqli_query($conn, $sql);
        $span = '<span>HẾT HÀNG</span>';
        while($item = mysqli_fetch_assoc($result)){
            if($item['quantity']>0){
                $span='';
                ?>
                <div class="radio-group">
                    <input type="radio" id="<?php echo $item['size_name']?>" name="size" value="<?php echo $item['detail_prd_size_id']?>">
                    <label for="<?php echo $item['size_name']?>"><?php echo $item['size_name']?></label><br>
                </div>
                <?php
            }
        }
        echo $span;
    }
                               
                                ?>