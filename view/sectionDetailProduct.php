<?php 
if(isset($_GET['id'])){
    $prd_id = $_GET['id'];
    $sql = "SELECT * FROM  products, sale, detail_product 
    WHERE products.prd_id = $prd_id  
    AND sale.sale_id = products.sale_id
    AND detail_product.prd_id = products.prd_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}




?>

 <!-- SECTION MAIN -->
 <section id="mainContent">
            <div class="product-detail-page container">
                <div class="content-1 col-6 col-xs-12">
                    <div class="img-main col-8 h-xs">
                        <img src="view/img/<?php echo $product['image_front']?>" alt="">
                    </div>
                    <div style="display: none" class="img-main-mb col-xs-12 show-xs">
                        <button id="btn-pre">&#10094;</button>
                        <img src="view/img/<?php echo $product['image_front']?>" alt="">
                        <img src="view/img/<?php echo $product['image_back']?>" alt="">
                        <?php
                            $imgDetail='';
                            while($item = mysqli_fetch_assoc($result)){
                                $imgDetail .='<img  src="view/img/'.$item['image_front'].'" alt="">
                                <img  src="view/img/'.$item['image_back'].'" alt="">';
                            }
                        
                        ?>
                        <?php echo $imgDetail; ?>
                        <button id="btn-next">&#10095;</button>

                    </div>
                    <div class="img-explain col-2 h-xs">
                        <img class="active" src="view/img/<?php echo $product['image_front']?>" alt="">
                        <img src="view/img/<?php echo $product['image_back']?>" alt="">
                        <?php echo $imgDetail; ?>
                    </div>
                </div>
                <div class="content-2 col-6 col-xs-12">

                    <h3>
                        <?php echo $product['prd_name']?>
                    </h3>
                    <div class="price-box">
                        <div class="sale">
                        <?php echo $product['percent']?>%</div>
                        <div class="price">
                        <?php echo number_format($product['price']-$product['price']*$product['percent']/100)?>₫</div>
                        <div class="price-bofore">
                            <?php echo number_format($product['price'])?>₫</div>
                    </div>
                    <h4>Color</h4>
                    <div class="color">
                    <?php
                                $sql = "SELECT * 
                                FROM  products, detail_product, color 
                                WHERE products.prd_id = $prd_id  
                                AND detail_product.prd_id = products.prd_id
                                AND detail_product.color_id = color.color_id
                                ";
                                $result = mysqli_query($conn, $sql);
                                while($item = mysqli_fetch_assoc($result)){
                                   
                                        ?>
                                        <div class="radio-group">
                                            <input type="radio" data='<?php echo $item['detail_prd_id']; ?>' id="<?php echo $item['detail_prd_id']; ?>" name="color" value="<?php echo $item['color_id']?>">
                                            <label for="<?php echo $item['color_name']?>"><?php echo $item['color_name']?></label><br>
                                        </div>
                                        <?php
                                    
                                }
                                ?>
                    </div>

                    
                    <h4>Size</h4>
                    <div class="size">
                           
                            
                               
                            

                             

                    </div>
                    
                    <div class="selector-actions">
                    <div class="quantity-area">
                            <button type="button" class="decrease">-</button>
                            <span>1</span>
                            <button type="button" class="increase">+</button>
                        </div>
                        <div  class="add-cart-btn col-6 col-xs-12">Thêm vào giỏ</div>

                        

                    </div>
                    <div class="description">
                        <h4>Mô tả</h4>
                        <p>
                            <?php echo $product['description']?>
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <script>
                       
                        
        </script>
        <!-- END LIST SHARING -->