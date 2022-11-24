 <?php require_once 'controller/authController.php';
require_once 'controller/onload.php';
if(!isset($_SESSION['id'])){
    header ('location: login.php');

}
else{
    // $user_id = $_SESSION['user_id'];
    // $sql = "SELECT * FROM cart, products, detail_product, detail_product_size, color, size, sale
    //      where cart.user_id = $user_id 
    //      AND cart.detail_prd_size_id = detail_product_size.detail_prd_size_id
    //      AND detail_product_size.detail_prd_id = detail_product.detail_prd_id
    //      AND products.prd_id = detail_product.prd_id
    //      AND products.sale_id = sale.sale_id
    //     AND detail_product.color_id= color.color_id
    //     AND detail_product_size.size_id = size.size_id
    //      ";
    // $result = mysqli_query($conn, $sql);
    // while($item = mysqli_fetch_assoc($result)){
    //     if(empty(checkStore($item['quantity'], $item['prd_id'], $item['size'], $conn))){
    //         header ('location: cart.php');
    //     }
    // }
}

// function checkStore($quantity, $prd_id, $size, $conn){
//     $sql_store = "SELECT * FROM store WHERE prd_id = $prd_id  AND size = '$size' and quantity >= $quantity";
//     $result_store = mysqli_query($conn, $sql_store);
//     $row_store = mysqli_num_rows($result_store); 
//     return $row_store;
// } 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purge</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne+Mono&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="view/css/style.css">
    <link rel="stylesheet" href="view/css/checkout.css">
</head>

<body>
<?php require_once 'view/header.php' ?>

    <!-- SECTION MAIN -->
    <div id="check-out">
        <form action="checkout.php" class="container form-check-out" method="POST">
            <div class="content-1 col-7 col-xs-12 col-tb-12">
                <h2>PUGRE</h2>
                <div class="step-content">
                    <h5>Thông tin giao hàng</h5>
                    <!-- <p class="text">Bạn đã có tài khoản? <a href="/html/login.html">Đăng nhập</a></p> -->
                    <div class="info-content">
                        <div class="info-box col-12">
                        <div class="form-control" >
                            <input type="text" placeholder="Họ và tên" id="name" name="name"> 
                            <br>    
                            <small>Error</small>
                        </div>
                        
                        <div class="form-control">
                            <input type="text" placeholder="Số điện thoại" id="phoneNum" name="phoneNum">
                            <small>Error</small>
                        </div>
                        <div class="form-control">
                            <input type="text" placeholder="Địa chỉ" id="addressDetail" name="addressDetail">
                            <small>Error</small>
                        </div>
                        </div>
                        <div class="box-address col-4">
                        <div class="form-control">
                            <select name="province" id="province" size="1">
                                <option value="" selected="selected">Tỉnh Thành</option>
                            
                        </select>
                        <input type="hidden" name="province-hidden">
                            
                            <small>Error</small>
                        </div>
                        </div>
                        <div class="box-address col-4">
                        <div class="form-control">
                        <select name="district" id="district" size="1" >
                    <option value="" selected="selected">Quận Huyện</option>
                </select>
                <input type="hidden" name="district-hidden">

                            <small>Error</small>
                        </div>
                        </div>
                        <div class="box-address col-4">
                        <div class="form-control">
                        <select name="village" id="village" size="1" >
                     <option value="" selected="selected">Phường Xã</option>
                </select>
                <input type="hidden" name="village-hidden">

                            <small>Error</small>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="step-content">
                    <h5>Phương thức vận chuyển</h5>
                    <div class="content-transport">
                        <i class="bx bx-box"></i>
                        <p>Giao hàng tiết kiệm</p>
                    </div>
                </div>
                <div class="step-content">
                    <h5>Phương thức thanh toán</h5>
                    <div class="content-pay-method">
                        <div class="method"><i class="bx bx-radio-circle-marked"></i> <span>Thanh toán khi giao hàng</span></div>
                        <p>Shipper đến nhận hàng, vui lòng trả tiền trực tiếp cho Shipper !</p>
                    </div>
                </div>
                <!-- <div class="step-content-footer">
                    <span><a href="cart.php"><i class="bx bxs-chevron-left"></i>Quay lại giỏ hàng</a></i></span>
                    <button type="submit" name="btn-check-out">Hoàn tất đơn hàng</button>
                </div> -->
            </div>
            <?php require_once 'controller/checkoutProduct.php'; ?>
        </form>
    </div>
    <!-- FOOTER -->
    <?php require_once 'view/footer.php'; ?>
    <script src="view/js/index.js"></script>
    <?php require_once 'controller/js/checkoutJS.php'; ?>
    

</body>

</html>