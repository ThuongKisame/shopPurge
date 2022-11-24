<script>
            $(function() {
                $radio = $('input[name=color]');
                        $renderSize = $('.size');
                        $radio.on('change', function(){
                            $detail_prd_id = $(this).attr('data');
                            $prd_id = <?php echo $prd_id ?>;
                            console.log($prd_id);
                            $.ajax({
                                type: 'GET',
                                url: 'getSize.php',
                                data: {
                                    detail_prd_id: $detail_prd_id,
                                    prd_id:  $prd_id
                                },
                                success: function(data){
                                    $renderSize.html(data);
                                    $sizeElement = $('input[name="size"]');

                                },
                                error: function(){

                                }
                            })







                        })



                $img = $('.img-explain img');
                $imgMain = $('.img-main img');
                $img.click(function(){
                    $src = $(this).attr('src');
                    $img.removeClass('active');
                    $(this).addClass('active');
                    $imgMain.attr('src', $src);


                })
                $prd_id = <?php echo $_GET['id']?>;
                
                let productData = {
                    "prd_id": $prd_id
                   
                }
                $cartHeader=$('#quantity-cart');
                $addCartBtn = $('.add-cart-btn');
                $btnIncrease = $('.increase');
                $btnDecrease = $('.decrease');
                $quantityElement = $('.quantity-area span');
                $quantity = parseInt($('.quantity-area span').text());
                $btnIncrease.click(function() {
                    $quantity += 1;
                    $quantityElement.text($quantity);
                })
                $btnDecrease.click(function() {
                    if ($quantity > 1) {
                        $quantity -= 1;
                        $quantityElement.text($quantity);
                    }
                })

                $addCartBtn.click(function(){
                    console.log('dsadsad');
                    $btnLogIn =  $('#btn-login');
                    console.log($btnLogIn);
                    if($btnLogIn.length > 0){
                        alert('Đăng nhập để mua sản phẩm!!!');
                        $('#btn-login').click();
                    }
                    else{
                        $user_id = $('#icon-account').attr('data');
                    }
                    
                    $color='';
                    $size = '';
                    $colorElement = $('input[name="color"]');
                    $.each($colorElement, function(index, item){
                         if(item.checked){
                            $color = 'color';
                         }
                    })
                    if($color == ''){
                        alert('Vui lòng chọn màu!');
                    }
                    else{
                        $sizeElement = $('input[name="size"]');
                    
                    if(!$sizeElement.length){
                        alert('Hết hàng!');
                    }else{
                        $.each($sizeElement, function(index, item){
                            if(item.checked){
                             productData.detail_prd_size_id=item.value;
                             $size = 'size';
                         }
                    })
                    }
                    


                     
                     
                     productData.user_id = $user_id;
                     productData.quantity = $quantity;
                     if($size == '' ){
                         alert('Vui lòng chọn size!');
                     }
                     else{
                        console.log(productData);
                         getData(productData);
                     }

                    }



                    
                    
                    
                    
                    
                })




                function getData(productData){
                    $cartHeader=$('#quantity-cart');
                    $.ajax({
                        type: 'GET',
                        url: 'controller/addToCart.php',
                        data: productData,
                        success: function(data){  
                            alert('Thêm giỏ hàng thành công');
                            $cartHeader.html(data);
                        },
                        error: function(){
                            alert('F');
                        }

                    })
                }
            })

            
            function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
        </script>