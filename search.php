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
    <style>
        #main-search {
            padding: 2rem 0;
        }
        
        #main-search #keyword-search {
            text-align: left;
        }
        
        hr {
            width: 8%;
            margin: 1rem auto;
            height: .3rem;
            background-color: black;
        }
    </style>

</head>

<body>
   
<?php require_once 'view/header.php'; ?>

    <!-- SECTION MAIN -->
    <div id="breadcumb-shop">
        <div class="container">
            <ul class="breadcumb">
                <li>
                    <a href="">Trang chủ</a>
                    <span>/</span>
                </li>
                <li>
                    <a href="">Danh mục</a>
                    <span>/</span>
                </li>
                <li>Tất cả sản phẩm</li>
            </ul>
        </div>
    </div>
    <div class="filter-site container">
                    <ul class="filter-value">

                    </ul>
                    <ul class="menu-filter">
                        <li>Lọc giá <i class="bx bxs-chevron-down"></i>
                            <ul class="sub-menu-filter">
                                <li>
                                    <label for="gia-duoi-100000">
                                         <input type="checkbox" id="gia-duoi-100000" data="1" data-type="price">
                                     </label>
                                    <span>Giá dưới 100.000</span></li>
                                <li>
                                    <label for="100000-200000">
                                        <input type="checkbox" id="100000-200000" data="2" data-type="price">
                                    </label>
                                    <span>100.000 - 200.000</span></li>
                                <li>
                                    <label for="200000-300000">
                                            <input type="checkbox" id="200000-300000" data="3" data-type="price">
                                        </label>
                                    <span>200.000 - 300.000</span></li>
                                <li>
                                    <label for="300000-500000">
                                                <input type="checkbox" id="300000-500000" data="4" data-type="price">
                                            </label>
                                    <span>300.000 - 500.000</span></li>
                                <li>
                                    <label for="gia-tren-500000">
                                                    <input type="checkbox" id="gia-tren-500000" data="5" data-type="price">
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
                        <li>Thể loại <i class="bx bxs-chevron-down"></i>
                            <ul class="sub-menu-filter">
                            <?php
                                    $sql ="SELECT * FROM category";
                                    $result= mysqli_query($conn, $sql);
                                    while($item = mysqli_fetch_assoc($result)){
                                        ?>
                                            <li>
                                                <label for="<?php echo $item['category_name'] ?>">
                                                <input type="checkbox" id="<?php echo $item['category_name'] ?>" data="<?php echo $item['category_id'] ?>" data-type="category">
                                                </label>
                                                <span><?php echo $item['category_name'] ?></span></li>
                                            </li>
                                        <?php
                                    }

                                ?>
                                

                            </ul>
                        </li>
                    </ul>
                </div>
    <?php require_once 'controller/renderSearch.php'; ?>
   
    <!-- END SECTION MAIN -->
    <?php require_once 'view/footer.php'; ?>
    

    <script src="view/js/index.js"></script>
    



</body>

</html>