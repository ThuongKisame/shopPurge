<!-- SECTION MAIN -->
<?php 



// $sqlSale = "SELECT * FROM products, sale WHERE sale.sale_id = products.sale_id AND check_sale = 1 LIMIT 8";
// $resultSale = mysqli_query($conn, $sqlSale);

// $sqlCategory = "SELECT * FROM products, store  where products.prd_id = store.prd_id group by category";

// $resultCategory = mysqli_query($conn, $sqlCategory);
// $category = array();

// while($row = mysqli_fetch_assoc($resultCategory)){
//     array_push($category, $row['category']);
// }



?>

<main id="mainContainer_theme">
    <!-- home slider -->
    <section id="home-slider">
        <img src="view/img/tretrau2.jpg" alt="">

    </section>
    <section id="banner-home-outer" class="play-on-scroll">
        <div class="container">
            <div class="row">
                <div class="banner-home-item col-4">
                    <div class="fade-box">
                        <a href=""><img src="view/img/tretrau.jpg" alt=""></a>
                    </div>
                </div>
                <div class="banner-home-item col-4">
                    <div class="fade-box">
                        <a href=""><img src="view/img/tretrau1.jpg" alt=""></a>
                    </div>
                </div>
                <div class="banner-home-item col-4">
                    <div class="fade-box">
                        <a href=""><img src="view/img/tretrau.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end home slider -->
    <!-- section collection home -->
    <section id="collection-home">
        <div class="wrapper-heading-home">
            <div class="container">
                <h2 class="play-on-scroll">sản phẩm mới</h2>
                <p class="play-on-scroll">Mỗi tuần PURGE đều có sản phẩm mới</p>
            </div>
        </div>
        <div class="wrapper-collection-1">
            <div class="container">
                <div class="row">
                    <?php
                    $sqlNewArrival = "SELECT * FROM products, sale, detail_product 
                    WHERE newArrival = 1 
                    and sale.sale_id = products.sale_id 
                    AND detail_product.prd_id = products.prd_id 
                    group by products.prd_id";
                    $resultNewArrival = mysqli_query($conn, $sqlNewArrival);
                    while($rowNewArrival = mysqli_fetch_assoc($resultNewArrival)){
                        ?>
                        <div class="product-img col-3 col-xs-6 col-tb-4 play-on-scroll ">
                        <a href="detailProduct.php?id=<?php echo $rowNewArrival['prd_id']?>">
                        <img src="view/img/<?php echo $rowNewArrival['image_front']?>" alt="">
                        <div class="name-product">
                        <?php echo $rowNewArrival['prd_name'];?>
                        </div>
                        <div class="price-product">
                            <?php echo number_format($rowNewArrival['price']);?>₫
                        </div>      
                        <span class="state-product"><?php  echo $rowNewArrival['percent']. "%";?></span>
                        </a>
                        </div>


                    <?php } ?>



                </div>
            </div>
        </div>
    </section>
    <!-- end section collection home -->
    <!-- collection info -->
    <section id="collection-info">
        <div class="container">
            <div class="row">
            <?php
                $sql = "SELECT category_name, image_front, sum(quantity) as 'quantity' 
                FROM category, products, detail_product, detail_product_size 
                WHERE products.prd_id = detail_product.prd_id 
                AND detail_product.detail_prd_id = detail_product_size.detail_prd_id 
                AND category.category_id = products.category_id group by category_name";
                $result = mysqli_query($conn, $sql);
                while($item = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="product-img col-3 col-xs-12 col-tb-6 play-on-scroll">
                        <div class="effect-box">
                            <a href="allProduct.php?category='<?php echo $item['category_name'] ?>'"><img src="view/img/<?php echo $item['image_front'] ?>" alt=""></a>
                        </div>
                        <div class="wrapper-product-store">
                            <div class="category-collection-info" style="text-transform: uppercase;"><?php echo $item['category_name'] ?></div>
                            <div><span class="quantity-collection-info"><?php echo $item['quantity'] ?></span> sản phẩm</div>
                        </div>
                    </div>

                    <?php
                }
                ?>
               




                


            </div>
        </div>
    </section>
    <!-- end collection info -->
    <!-- section collection home -->
    <section id="collection-home">
        <div class="wrapper-heading-home">
            <div class="container">
                <h2 class="play-on-scroll">Đang giảm giá</h2>
                <p class="play-on-scroll">Sản phẩm chỉ còn một vài size và không sản xuất lại khi bán hết</p>
            </div>
        </div>
        <div class="wrapper-collection-1">
            <div class="container">
                <div class="row">

                <?php
                    $sql = "SELECT * FROM products, detail_product, sale WHERE products.prd_id = detail_product.prd_id  AND sale.sale_id = products.sale_id AND products.sale_id >0";
                    $result = mysqli_query($conn, $sql);
                
                while($item = mysqli_fetch_assoc($result)){
                        ?>
                        <div class="product-img col-3 col-xs-6 col-tb-4 play-on-scroll ">
                        <a href="detailProduct.php?id=<?php echo $item['prd_id']?>">
                        <img src="view/img/<?php echo $item['image_front']?>" alt="">
                        <div class="name-product">
                        <?php echo $item['prd_name'];?>
                        </div>
                        <div class="price-product">
                            <?php echo number_format($item['price']);?>₫
                        </div>      
                        <span class="state-product"><?php  echo $item['percent']. "%";?></span>
                        </a>
                        </div>


                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end section collection home -->


</main>
<!-- FOOTER -->