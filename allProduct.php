<?php 

require_once 'controller/authController.php';
require_once 'controller/onload.php';

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
    <link rel="stylesheet" href="view/css/product.css">
    <link rel="stylesheet" href="view/css/style.css">


</head>

<body>

    
<?php require_once 'view/header.php'; ?>   

<?php
if(isset($_GET['category'])){
$category = $_GET['category'];
$sql="SELECT * FROM category WHERE category_id =$category";
$result=mysqli_query($conn, $sql);
if(!empty(mysqli_num_rows($result))){
    $item = mysqli_fetch_assoc($result);
    $show = $item['category_name'];
}
}
else{
    $show = 'Tất cả sản phẩm';
}
?>
    <!-- SECTION MAIN -->
    <div id="breadcumb-shop">
        <div class="container">
            <ul class="breadcumb">
                <li>
                    <a href="index.php">Trang chủ</a>
                    <span>/</span>
                </li>
                <li>
                    <a href="allProduct.php">Sản phẩm</a>
                    <span>/</span>
                </li>
                <li>
                    <a href=""><?php echo $show; ?></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div id="collection">
        <div id="banner-collection-header">
            <img src="img/ezgif-4-68118868f100.jpg" alt="">
        </div>
        <div class="main-content container">
            <div class="col-2 h-xs h-tb" id="left-nav">
                <h2>Danh mục sản phẩm</h2>
                <ul id="left-menu-site">
                    <li><a href="allProduct.php" id="all">Shop ALL</a></li>

                    <?php
                        $sql="SELECT * FROM category";
                        $result=mysqli_query($conn, $sql);
                        while($item = mysqli_fetch_assoc($result)){
                            ?>
                                 <li><a href="allProduct.php?category=<?php echo $item['category_id'] ?>" id="<?php echo $item['category_id'] ?>"><?php echo $item['category_name'] ?></a></li>
                            <?php
                        }
                    
                    ?>
                    <!-- <li><a href="allProduct.php?category='tee'" id="tee">Tee</a></li>
                    <li><a href="allProduct.php?category='jacket'" id="jacket">Jacket</a></li>
                    <li><a href="allProduct.php?category='accessories'" id="accessories">Accessories</a></li>
                    <li><a href="allProduct.php?category='pants'" id="pants">Pants</a></li>
                    <li><a href="allProduct.php?category='hoodie'" id="hoodie">Hoodie</a></li>
                    <li><a href="allProduct.php?category='sweater'" id="sweater">Sweater</a></li> -->
                </ul>
            </div>
            <div class="col-10 col-xs-12 col-tb-12">
                <div class="filter-site">
                    <ul class="filter-value">

                    </ul>
                    <ul class="menu-filter">
                        <li>Lọc giá <i class="bx bxs-chevron-down"></i>
                            <ul class="sub-menu-filter">

                              
                                <li>
                                    <label for="gia-duoi-100000">
                                         <input type="checkbox" id="gia-duoi-100000" data="100000" data-type="price">
                                     </label>
                                    <span>Giá dưới 100.000</span></li>
                                <li>
                                    <label for="100000-200000">
                                        <input type="checkbox" id="100000-200000" data="100000-200000" data-type="price">
                                    </label>
                                    <span>100.000 - 200.000</span></li>
                                <li>
                                    <label for="200000-300000">
                                            <input type="checkbox" id="200000-300000" data="200000-300000" data-type="price">
                                        </label>
                                    <span>200.000 - 300.000</span></li>
                                <li>
                                    <label for="300000-500000">
                                                <input type="checkbox" id="300000-500000" data="300000-500000" data-type="price">
                                            </label>
                                    <span>300.000 - 500.000</span></li>
                                <li>
                                    <label for="gia-tren-500000">
                                                    <input type="checkbox" id="gia-tren-500000" data="500000" data-type="price">
                                                </label>
                                    <span>Giá trên 500.000</span></li>

                            </ul>
                        </li>
                        
                        <li>Colour <i class="bx bxs-chevron-down"></i>
                            <ul class="sub-menu-filter">
                            <?php
                                    $sql ="SELECT * FROM color";
                                    $result= mysqli_query($conn, $sql);
                                    while($item = mysqli_fetch_assoc($result)){
                                        ?>
                                            <li>
                                                <label for="<?php echo $item['color_name'] ?>">
                                                <input type="checkbox" id="<?php echo $item['color_name'] ?>" data="<?php echo $item['color_id'] ?>" data-type="color">
                                                </label>
                                                <span><?php echo $item['color_name'] ?></span></li>
                                            </li>
                                        <?php
                                    }

                                ?>
                                

                            </ul>
                        </li>
                    </ul>
                </div>
                <h2>Tất cả sản phẩm </h2>
                <div class="renderProduct">

                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION MAIN -->
    <?php require_once 'view/footer.php'; ?>

    <?php require_once 'controller/js/allProductJS.php'; ?>
    <script src="view/js/index.js"></script>




</body>

</html>