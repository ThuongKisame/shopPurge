<?php 
if(!isset($_SESSION['id'])){
    // echo "ánd";
    header ('location: login.php');
}
else{
    $user_id = $_SESSION['user_id'];
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
    if($result){
        $tmpTotal = 0;
        $transport = 30000;
        

    }
    else{
        echo "not";
    }
}

?>

<div class="content-2 col-5 col-xs-12 col-tb-12">
                <div class="products-checkout">
                        <?php while($row = mysqli_fetch_assoc($result)){
                            $tmpTotal += $row['price']*$row['quantity_cart']-$row['price']*$row['quantity_cart']*$row['percent']/100; ?>
                    <div class="product-checkout col-12">
                        <div class="content-first col-2">
                            <img src="view/img/<?php echo $row['image_front'] ?>" alt="">
                            <div class="quantity"><span><?php echo $row['quantity_cart'] ?></span></div>
                        </div>
                        <div class="content-second col-10">
                            <div class="name"><?php echo $row['prd_name'] ?></div>
                            <div class="price"><?php echo number_format($row['price']*$row['quantity_cart']-$row['price']*$row['quantity_cart']*$row['percent']/100) ?>₫</div>
                            <div class="size" style="text-transform: uppercase;"><?php echo $row['color_name'] ?></div>
                            <div class="size" style="text-transform: uppercase;"><?php echo $row['size_name'] ?></div>
                            <div class="size" style="text-transform: uppercase;"><?php echo $row['percent'] ?>%</div>

                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="discount-code">
                    <input type="text" placeholder="Mã giảm giá">
                    <button>Sử dụng</button>
                </div>
                <div class="total-line">
                    <p>
                        <span>Tạm tính</span>
                        <span class="temp-pay"><?php echo number_format($tmpTotal) ?>₫</span>
                    </p>
                    <p>
                        <span>Phí vận chuyển</span>
                        <span class="pay-transport"><?php echo number_format($transport) ?>₫</span>
                    </p>
                </div>
                <div class="total-end">
                    <span>Tổng cộng: </span>
                    <span class="total-price"><?php echo number_format($tmpTotal+$transport) ?>₫</span>
                </div>
                <div class="step-content-footer">
                    <span><a href="cart.php"><i class="bx bxs-chevron-left"></i>Quay lại giỏ hàng</a></i></span>
                    <button type="submit" name="btn-check-out">Hoàn tất đơn hàng</button>
                </div>
            </div>