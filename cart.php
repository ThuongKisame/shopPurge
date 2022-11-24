<?php 
require_once 'controller/authController.php';
require_once 'controller/onload.php';
if(!isset($_SESSION['id'])){
    header ('location: login.php');
}


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
    <link rel="stylesheet" href="view/css/cart.css">
</head>

<body>

<?php require_once 'view/header.php' ?>
    <!-- SECTION MAIN -->
    <div id="breadcumb-shop">
        <div class="container">
            <ul class="breadcumb">
                <li>
                    <a href="index.php">Trang chủ</a>
                    <span>/</span>
                </li>
                <li>
                    <a href="">Giỏ hàng</a>
                    
                </li>
                
            </ul>
        </div>
    </div>
    <div id="layout-cart">
        <div class="container render-cart">



        </div>
    </div>
    <?php require_once 'view/footer.php'; ?>
    
    <?php require_once 'controller/js/cartJS.php'; ?>
    
    <script src="view/js/index.js"></script>



</body>

</html>