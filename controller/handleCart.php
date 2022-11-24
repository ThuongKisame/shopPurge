<?php
    require_once 'dbExtra.php';
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        if(isset($_GET['quantity_cart'])&&isset($_GET['detail_prd_size_id']))
        {

            $quantity_cart = $_GET['quantity_cart'];
            $detail_prd_size_id = $_GET['detail_prd_size_id'];
            $sql_update = "UPDATE cart SET quantity_cart = $quantity_cart WHERE user_id = $user_id AND detail_prd_size_id = $detail_prd_size_id ";
            $result_update = mysqli_query($conn, $sql_update);
           
           

               
            
        }
        if(isset($_GET['detail_prd_size_id_del']))
        {
            $detail_prd_size_id = $_GET['detail_prd_size_id_del'];
            $sql_del = "DELETE FROM cart  WHERE user_id = $user_id AND detail_prd_size_id = $detail_prd_size_id";
            $result_del = mysqli_query($conn, $sql_del);
        }
        
        $sql = "SELECT * FROM cart, products, detail_product, detail_product_size, color, size, sale
         where cart.user_id = $user_id 
         AND cart.detail_prd_size_id = detail_product_size.detail_prd_size_id
         AND detail_product_size.detail_prd_id = detail_product.detail_prd_id
         AND products.prd_id = detail_product.prd_id
         AND products.sale_id = sale.sale_id
        AND detail_product.color_id= color.color_id
        AND detail_product_size.size_id = size.size_id
         ";
        $result = mysqli_query($conn, $sql);
        $totalPrice = 0;
        if($result){
            $error = true;
            $quantityInCart=0;
     
            
    
            $row = mysqli_num_rows($result);
            if(!empty($row)){ ?>
<div class="title-cart">
                <h2>Giỏ hàng</h2>
                <p>Có <span><?php echo $row ?></span> sản phẩm trong giỏ hàng</p>
            </div>
            <div class="row cart-products">
                <?php while($item = mysqli_fetch_assoc($result)){
                    $error ="";
                    if(empty(checkStore($item['quantity_cart'], $item['detail_prd_size_id'], $conn))){
                        $error = "error";
                    }
                    $quantityInCart += $item['quantity_cart'];
                    $priceAfterSale = $item['price']-$item['price']*$item['percent']/100;
                    ?>
                <div class="item-cart-product col-12 <?php echo $error; ?>">
                    <a href="detailProduct.php?id=<?php echo $item['prd_id'] ?>" class="img-cart-product col-2 col-xs-3 col-tb-3">
                        <img src="view/img/<?php echo $item['image_front'] ?>" alt="">
                    </a>
                    <div class="col-10 item col-xs-9 col-tb-9">
                        <a href="detailProduct.php?id=<?php echo $item['prd_id'] ?>"  class="nameProduct"><?php echo $item['prd_name'] ?></a>
                        <p id="price-default"><span><?php echo number_format($priceAfterSale) ?>₫</span></p>
                        <p><span style="text-transform: uppercase;"><?php echo $item['color_name'] ?></span></p>
                        <p><span style="text-transform: uppercase;"><?php echo $item['size_name'] ?></span></p>

                        <div class="price">
                            <!-- <span class="text">Thành tiền</span> -->
                            <span class="line-item-total"><?php echo number_format( $priceAfterSale*$item['quantity_cart']);$totalPrice+=$priceAfterSale*$item['quantity_cart'] ?>₫</span>
                        </div>
                        <div class="sale">Sale: <?php echo $item['percent'] ?>%</div>

                        <div class="quantity" dataSize="<?php echo $item['detail_prd_size_id'] ?>">
                            <button type="button" class="decrease">-</button>
                            <span><?php echo $item['quantity_cart'] ?></span>
                            <button type="button" class="increase">+</button>
                        </div>
                        <small>Sản phẩm không đủ số lượng</small>

                        <div class="remove" dataID="<?php echo $item['prd_id'] ?>" dataSize="<?php echo $item['detail_prd_size_id'] ?>">
                            <i class="bx bx-trash"></i>
                        </div>
                        
                        

                    </div>
                </div>
                <?php  } ?>
                
            </div>
            <div class="box-total">
                <p>Tổng tiền: <span class="total-price"><?php echo number_format($totalPrice); ?>₫</span> </p>
            </div>
            <div class="cart-btn">
                <button><a href="allProduct.php"><i class="bx bx-undo"></i>Tiếp tục mua sắm</a></button>
                
                    <?php if(empty($error)){?>
                        <button><a href="checkout.php"></i> Thanh toán</a></button>
                  <?php  } ?>
                
                    
            </div>
            <?php }else{ ?>
                <img class="col-xs-12 col-6" style="margin: 0 auto;" src="view/img/empty_cart .png">
                <div>Chưa có sản phẩm nào trong giỏ hàng</div>
            <?php } 
            
        }
        
    }
    

    function checkStore($quantity_cart, $detail_prd_size_id, $conn){
        $sql_store = "SELECT * FROM detail_product_size WHERE detail_prd_size_id = $detail_prd_size_id  AND quantity >= $quantity_cart";
        $result_store = mysqli_query($conn, $sql_store);
        $row_store = mysqli_num_rows($result_store);
        return $row_store;
    }
?>

<script>
$cartHeader.text(<?php echo $quantityInCart; ?>);
 </script>

