<?php  
    $sqlGetSale = "SELECT * FROM sale group by percent";
    $resultGetSale = mysqli_query($conn, $sqlGetSale);
    $arraySale = array();
    while($sale = mysqli_fetch_assoc($resultGetSale)){
        if(!empty($sale['check_sale'])){
            array_push($arraySale, $sale['percent']);
        }
    }
        
    

?>

<!-- TOP BAR -->
<div id="topbar">
        <div class="container">
            <div class="menu-wrap">
                <div id="info-contact-top-bar" class="h-xs col-3 h-tb top-bar-item">
                    Purge@gmail.com | Hotline: 0377739029
                </div>
                <div id="info-promotion-top-bar" class="col-6 col-xs-12 col-tb-12 top-bar-item">
                    Tặng ngay 1 túi Tote Bag khi mua sản phẩm từ 300.000 vnđ <br> Đơn hàng được FreeShip khi mua từ 1.500.000 vnđ
                </div>
                <form action="search.php" method="GET" id="search-top-bar" class="h-xs col-3 h-tb top-bar-item">
                    <input type="text" class="input" placeholder="Search..." name="data" id="data-search">
                    <button class="btn-search-product" name="btn-search" type="submit" value=1>
                        <i class='bx bx-search'></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- END TOP BAR -->
    <!-- HEADER -->
    <header id="site-header">
        <div class="container">
            <div class="menu-wrap">
                <div class="mobile-header-nav show-xs col-xs-3 show-tb col-tb-3 header-item">
                    <input type="checkbox" id="check-menu">
                    <label for="check-menu">
                        <i class="bx bx-menu" id="btn-menu"></i>
                    </label>
                    <div id="site-nav-mb">
                        <label for="check-menu">
                            <i class="bx bx-x" id="btn-cancel"></i>
                        </label>
                        <h3>menu</h3>
                        <ul class="menu-collection">
                            <li>
                                <a href="index.php">Trang chủ</a>

                            </li>
                            <li>
                                <a href="allProduct.php">Sản phẩm</a>
                                <input type="checkbox" id="check-product">
                                <label for="check-product" class="label-checkbox">
                                    <i class="bx bxs-chevron-down"></i>
                                </label>
                                <ul class="menu-collection-sub">
                                    <li><a href="allProduct.php">Shop ALL</a></li>
                                    <?php
                                    
                                        $sql="SELECT * FROM category";
                                        $result=mysqli_query($conn, $sql);
                                        while($item = mysqli_fetch_assoc($result)){
                                            ?>
                                                <li><a href="allProduct.php?category='<?php echo $item['category_id'] ?>'"><?php echo $item['category_name'] ?></a></li>
                                            <?php 
                                        }
                                    ?>
                                        <!-- <input type="checkbox" id="check-product-sub">
                                        <label for="check-product-sub" class="label-checkbox">
                                             <i class="bx bxs-chevron-down"></i>
                                        </label>
                                        <ul class="menu-collection-sub">
                                            <li><a href="">Art Work Stuff </a></li>
                                            <li><a href="">Reflection Stuff</a></li>
                                        </ul> -->
                                    
                                    <!-- <li><a href="allProduct.php?category='tee'">Tee</a></li>
                                    <li><a href="allProduct.php?category='jacket'">Jacket</a></li>
                                    <li><a href="allProduct.php?category='accessories'">Accessories</a></li>
                                    <li><a href="allProduct.php?category='pants'">Pants</a></li>
                                    <li><a href="allProduct.php?category='hoodie'">Hoodie</a></li>
                                    <li><a href="allProduct.php?category='sweater'">Sweater</a></li> -->
                                </ul>
                            </li>
                            <li>
                                <a href="sale.php"></a>
                                
                            </li>
                            <li>
                                <a href="">Hướng dẫn</a>
                                <input type="checkbox" id="check-guide">
                                <label for="check-guide" class="label-checkbox">
                                    <i class="bx bxs-chevron-down"></i>
                                </label>
                                <ul class="menu-collection-sub">
                                    <li><a href="">Bảo mật</a></li>
                                    <li><a href="">Đổi trả sản phẩm</a></li>
                                    <li><a href="">Liên hệ</a></li>
                                    <li><a href="">Hướng dẫn mua</a></li>

                                </ul>
                            </li>
                            <li>
                                <a href="">Bảng Size</a>
                            </li>
                            <li>
                                <a href="">Giới thiệu PURGE</a>
                            </li>
                        </ul>
                        <ul class="menu-collection-2">
                            <li>
                                <a href="index.php">Trang chủ</a>
                            </li>
                            <li>
                                <a href="allProduct.php">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="">Đang giảm giá</a>
                            </li>
                            <li>
                                <a href="">Hướng dẫn</a>
                            </li>
                            <li>
                                <a href="">Bảng Size</a>
                            </li>
                            <li>
                                <a href="">Giới thiệu PURGE</a>
                            </li>
                        </ul>
                        <div class="box-log-in">
                            <i class="bx bx-user-circle"></i>
                            <span><?php 
                            if(!empty($nameUser))
                            {
                                echo "Hi, " .$nameUser ;
                            }
                            else{
                                echo "Đăng nhập";
                            }
                        ?></span>
                        </div>

                    </div>

                </div>

                <div id="header-logo" class="col-2 col-xs-6 col-tb-6 header-item">
                    <div class="logo-box">
                        <a href="index.php">
                            <img src="view/img/logoPurge.png" alt="">
                        </a>
                    </div>
                </div>
                <div id="header-nav" class="h-xs h-tb col-8 header-item">
                    <ul>
                        <li><a href="index.php">trang chủ   
                        </a></li>
                        <li><a href="allProduct.php">sản phẩm
                            <i class='bx bxs-chevron-down'></i>
                        </a>
                            <ul class="sub-menu">
                                <li><a href="allProduct.php">Shop ALL
                                     <!-- <i class='bx bxs-chevron-right'></i> -->
                                </a>
                                    <!-- <ul class="sub-sub-menu">
                                        <li><a href="">Art Work Stuff </a></li>
                                        <li><a href="">Reflection Stuff</a></li>
                                    </ul>  -->
                                </li>

                                <?php
                                    
                                        $sql="SELECT * FROM category";
                                        $result=mysqli_query($conn, $sql);
                                        while($item = mysqli_fetch_assoc($result)){
                                            ?>
                                                <li><a href="allProduct.php?category='<?php echo $item['category_id'] ?>'"><?php echo $item['category_name'] ?></a></li>
                                            <?php 
                                        }
                                    ?>
                                <!-- <li><a href="allProduct.php?category='tee'">Tee</a></li>
                                <li><a href="allProduct.php?category='jacket'">Jacket</a></li>
                                <li><a href="allProduct.php?category='accessories'">Accessories</a></li>
                                <li><a href="allProduct.php?category='pants'">Pants</a></li>
                                <li><a href="allProduct.php?category='hoodie'">Hoodie</a></li>
                                <li><a href="allProduct.php?category='sweater'">Sweater</a></li> -->
                            </ul>

                        </li>
                        <li><a href="sale.php">đang giảm giá
                        </a>
                       
                            
                        </li>
                        <li><a href="">hướng dẫn
                            <i class='bx bxs-chevron-down'></i>
                        </a>
                            <ul class="sub-menu">
                                <li><a href="">Bảo mật</a></li>
                                <li><a href="">Đổi trả sản phẩm</a></li>
                                <li><a href="">Liên hệ</a></li>
                                <li><a href="">Hướng dẫn mua</a></li>

                            </ul>
                        </li>
                        <li><a href="">bảng size</a></li>
                        <li><a href="">giới thiệu</a></li>
                    </ul>
                </div>

                <div id="header-wrap-icon" class="col-2 col-xs-3 col-tb-3 header-item">

                    
                    <?php 
                            if(!empty($nameUser))
                            { ?>
                    <a href="account.php" id="icon-account" data=<?php echo $_SESSION['user_id'] ?>>
                        <i class='bx bx-user'></i>
                        <span class="h-xs h-tb">
                                <?php echo "Hi, " .$nameUser ; ?>
                           <?php }
                            else{
                                ?>

                                <a id="btn-login">
                        <i class='bx bx-user'></i>
                        <span class="h-xs h-tb">
                                <?php echo "Đăng nhập" ?>
                            <?php }
                        ?>

                        </span>
                    </a>
                    <a href="cart.php" id="icon-cart-handle">
                        <i class='bx bx-shopping-bag'></i>
                        <span id="quantity-cart"><?php  if(!empty($quantityInCart)){
                            echo $quantityInCart;
                        }
                        else{
                            echo "0";
                        } ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER -->
    <!-- SEARCH BAR MOBILE -->
    <div id="search-bar-mb" class="show-xs show-tb">
        <input type="text" placeholder="Tìm kiếm sản phẩm">
        <button>
            <i class='bx bx-search'></i>
        </button>
    </div>
    <!-- END SEARCH BAR MOBILE -->