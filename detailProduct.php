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
        <link rel="stylesheet" href="view/css/style.css">
        <style>
            .product-detail-page {
                display: flex;
                flex-wrap: wrap;
            }
            
            .content-1 {
                position: relative;
            }
            
            .img-explain {
                width: 30%;
                /* border : 1px solid red; */
                /* position: absolute; */
                /* top: 0; */
                display: flex;
                flex-wrap: wrap;
                /* display: flex; */
            }

            .img-explain img{
                width: 50%;
            }

            .img-explain .active{
                border: 1px solid black;
            }
            
            .img-main {
                float: right;
            }
            
            .content-2 {
                text-align: left;
                line-height: 2rem;
            }
            
            .content-2 h3 {
                color: var(--primary-color);
            }
            
            .content-2 .price-box {
                display: flex;
            }
            
            .content-2 .price-box div {
                margin-right: .7rem;
            }
            
            .content-2 .price-box .price {
                color: red;
                font-weight: bold;
            }
            
            .content-2 .price-box .price-bofore {
                text-decoration: line-through;
                font-size: small;
            }
            
            .content-2 .price-box .sale {
                background-color: rgba(0, 0, 0, .2);
                padding: 0 .5rem;
                font-size: small;
                color: red;
                font-weight: bold;
            }
            
            .content-2 .size,.content-2 .color {
                display: flex;
                text-transform: uppercase;
            }
            
            .content-2 .size .radio-group,.content-2 .color .radio-group {
                margin-right: 3rem;
                font-weight: bold;
            }
            
            .content-2 .selector-actions .add-cart-btn {
                padding: .3rem 0;
                /* height: 4rem; */
                background-color: var(--primary-color);
                color: white;
                font-weight: bold;
                text-align: center;
                margin-top: 1rem;

            }
            
            .content-2 .selector-actions {
                display: flex;
                flex-wrap: wrap;
                /* align-self: center; */
                /* height: 4rem; */
            }
            
            .content-2 .selector-actions .quantity-area {
                margin-top: 1rem;

                /* width: max-content; */
                border: 1px solid rgba(0, 0, 0, .2);
                font-weight: bold;
                font-size: 1.2rem;
            }
            
            .content-2 .selector-actions .quantity-area span {
                /* padding: 0 1rem; */
            }
            
            .content-2 .selector-actions .quantity-area button {
                padding: .5rem 2rem;
                font-weight: bold;
                /* padding: .7rem 3rem; */
                /* width: 1.5rem; */
                border: none;
                outline: none;
                background-color: white;
                font-size: 1.2rem;
            }
            
            .content-2 .description {
                margin-top: 1rem;
            }

            .img-main-mb{
                display: none;
                position: relative;

            }

            .img-main-mb button{
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                position: absolute;
                outline: none;

            }

            .img-main-mb #btn-pre{
                top: 50%;
                left: 0;
            }

            .img-main-mb #btn-next{
                top: 50%;
                right: 0;
            }

           

            .img-main-mb  img{
                /* float: left; */
                display: none;
                width: 100%
            }

            
        </style>
    </head>

    <body>
    <?php require_once 'view/header.php' ?>
    <?php require_once 'view/sectionDetailProduct.php'; ?>

    <?php require_once 'view/footer.php'; ?>
       
        <script src="view/js/index.js"></script>
    <?php require_once 'controller/js/detailProductJS.php'; ?>
    <script>
        $(function(){
            $slides = $('.img-main-mb img');
            $btnPre = $('.img-main-mb #btn-pre');
            $btnNext = $('.img-main-mb #btn-next');
            $slideIndex = 0;
            $slides[$slideIndex].style.display = "block";

            $btnPre.click(function(){
                $slides[$slideIndex].style.display = "none";
                if($slideIndex-1<0){
                    $slideIndex=$slides.length-1;
                }
                else{
                    $slideIndex-=1;
                }
                $slides[$slideIndex].style.display = "block";
            })
            $btnNext.click(function(){
                $slides[$slideIndex].style.display = "none";
                if($slideIndex+1>$slides.length-1){
                    $slideIndex=0;
                }
                else{
                    $slideIndex+=1;
                }
                $slides[$slideIndex].style.display = "block";
            })

            
        })
    </script>
        

    </body>

    </html>