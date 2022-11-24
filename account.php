<?php 
require_once 'controller/authController.php';
require_once 'controller/onload.php';
if(!isset($_SESSION['id'])){
    header ('location: login.php');
}

$user_id = $_SESSION['user_id'];


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
    <link rel="stylesheet" href="view/css/account.css">
</head>

<body>

    <?php require_once 'view/header.php' ?>
    <!-- SECTION MAIN -->
    <section id="main-account" class="container">
        <h2>Tài khoản của bạn</h2>
        <div class="wrapper-account">
            <div class="account-sidebar col-2 col-xs-12">
                <ul>
                    <li data-display="info" class="menu-left">Tài khoản</li>
                    <li data-display="order" class="menu-left">Đơn hàng</li>
                    <li><a href="account.php?logout=1">Đăng xuất</a></li>
                </ul>
            </div>
            <div class="account-content col-10 col-xs-12">
            <!-- <h4>Thông tin tài khoản</h4> -->
                <ul>
                    <li>
                        <strong>Họ và tên: </strong>
                        <?php echo $_SESSION['nameUser'] ?>
                    </li>
                    <li>
                    <strong>Email: </strong>

                        <?php echo $_SESSION['email'] ?>
                    </li>
                    <li>
                    <strong>Số điện thoại: </strong>

                        <?php echo $_SESSION['phoneNumber'] ?>
                    </li>
                </ul>
                
            </div>
        </div>
    </section>
    <!-- END SECTION MAIN -->
    <?php require_once 'view/footer.php'; ?>
    <script src="view/js/index.js"></script>
    <script>
        $(function(){
            $menu = $('.menu-left');
            $render = $('.account-content');
            // console.log($menu);
           
            $menu.on('click', function(){

                
                $a = $(this).attr('data-display')
                if($a === 'info'){
                    $render.html(`
                <ul>
                    <li>
                        <?php echo $_SESSION['nameUser'] ?>
                    </li>
                    <li>
                        <?php echo $_SESSION['email'] ?>
                    </li>
                    <li>
                        <?php echo $_SESSION['phoneNumber'] ?>
                    </li>
                </ul>`)
                }
                else{
                    if($a === 'order'){
                        $render.html(`<div class="orders">
                        <?php 
                    $sql = "SELECT * FROM orders WHERE user_id =$user_id order by order_id desc";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $order_id = $row['order_id'];
                        ?>
                        <?php 
                    
                        
                        
                        ?>
                         <div class="order">
                        <div class="info-customer col-4 col-xs-12">
                            <ul>
                                <li>
                                    <strong>Tên khách hàng: </strong>
                                    <?php echo $row['name_customer']; ?>
                                </li>
                                <li>
                                    <strong>Số điện thoại: </strong>
                                    <?php echo $row['phoneNumber']; ?>
                                </li>
                                <li>
                                     <strong>Địa chỉ: </strong>

                                    <?php echo $row['address_detail']." ".$row['province']." ".$row['district']." ".$row['village'] ; ?>
                                </li>
                                <li>
                                    <strong>Ngày đặt hàng: </strong>
                                    <?php echo $row['date']; ?>
                                </li>
                                <?php
                                $textBtn = 'Chờ xác nhận';
                                if($row['date_confirm']!="0000-00-00 00:00:00"){
                                    $textBtn = 'Chờ xử lý';
                                    ?>
                                    <li>
                                        <strong>Ngày xác nhận: </strong>
                                        <?php echo $row['date_confirm']; ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if($row['date_complete']!="0000-00-00 00:00:00"){
                                    $textBtn = 'Xác nhận đã nhận hàng';
                                    ?>
                                    <li>
                                        <strong>Ngày hoàn tất đơn hàng: </strong>
                                        <?php echo $row['date_complete']; ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if($row['date_receipt']!="0000-00-00 00:00:00"){
                                    $textBtn = 'Đã nhận hàng';
                                    ?>
                                    <li>
                                        <strong>Ngày nhận hàng: </strong>
                                        <?php echo $row['date_receipt']; ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if($row['date_cancel']!="0000-00-00 00:00:00"){
                                    $textBtn = 'Đã hủy';

                                    ?>
                                    <li>
                                        <strong>Ngày hủy đơn hàng: </strong>
                                        <?php echo $row['date_cancel']; ?>
                                    </li>
                                    <?php
                                }
                                ?>

                                
                            </ul>
                                <div id="btn-side">
                                <?php
                            if($row['state'] == 3){
                                ?>
                                    <button id="btn-receipt" data=<?php echo $order_id; ?> state=3 style="padding: .5rem 1rem; font-weight: bold;"> <?php echo $textBtn ?></button>
                                <?php
                            }
                            else{
                                ?>
                                    <button style="padding: .5rem 1rem; font-weight: bold;" > <?php echo $textBtn ?></button>
                                <?php
                            }

                            if($row['state'] == 1){
                                ?>
                                <button id="btn-receipt" data=<?php echo $order_id; ?> state=1 style="padding: .5rem 1rem; font-weight: bold;"> Hủy đơn hàng</button>
                            <?php
                            }
                            
                            ?>
                                </div>
                            
                        </div>
                          

                        <div class="products-order col-8 col-xs-12">
                        <?php
                        $sql_1 = "SELECT * FROM detail_order where order_id = $order_id " ;
                        $result_1 = mysqli_query($conn, $sql_1);
                        while($row_1 = mysqli_fetch_assoc($result_1)){ ?>
                            <div class="product-order col-12">
                                <div class="content-first col-2">
                                    <img src="view/img/<?php echo $row_1['image_front'] ?>" alt="">
                                    <div class="quantity"><span><?php echo $row_1['quantity'] ?></span></div>
                                </div>
                                <div class="content-second col-10">
                                    <div class="name">
                                    <?php echo $row_1['prd_name'] ?>
                                    </div>
                                    
                                    <div class="size" style="text-transform: uppercase;">
                                    <span>Size: </span>
                                    <?php echo $row_1['size'] ?>
                                    
                                    </div>
                                    <div class="price">
                
                                    <?php echo number_format(($row_1['price']-$row_1['price']*$row_1['percent']/100)*$row_1['quantity']) ?>₫
                                    </div>  
                                    <div class="sale"><span>SALE: </span>
                                    <?php echo $row_1['percent'] ?>%
                                    </div>
                                    
                                </div>
                            </div>
                        <?php }?>

                        </div>
                    </div>

                    
                    

                    <?php }?>
                    
                </div>`)

                    }
                }
            $btnSide = $('#btn-side');
            $receipt = $('#btn-receipt');
            $receipt.on('click', function(){
                $order_id = $receipt.attr('data');
                $state = $receipt.attr('state');
                $.ajax({
                    type: 'GET',
                    url: 'controller/confirm.php',
                    data: {order_id: $order_id,
                    state: $state},
                    success: function(data){
                        $btnSide.html(data);
                    },
                    error: function(){

                    }
                
                })
            })
            })
        })
    </script>
</body>

</html>
