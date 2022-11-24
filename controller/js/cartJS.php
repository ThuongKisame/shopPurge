<script>
        $(function() {
            $renderCart = $('.render-cart');
            $cartHeader=$('#quantity-cart');
            $user_id = <?php echo $_SESSION['user_id']?>;
            getData($user_id);

            function getData(userID, quantityVal, sizeVal) {
                $.ajax({
                    type: 'GET',
                    url: 'controller/handleCart.php',
                    data: {
                        user_id: userID,
                        quantity_cart:  quantityVal,
                        detail_prd_size_id: sizeVal,
                    },
                    success: function(data) {
                        $renderCart.html(data);
                        event();
                    },
                    error: function() {

                    }
                })
            }

            function delData(userID, sizeVal) {
                $.ajax({
                    type: 'GET',
                    url: 'controller/handleCart.php',
                    data: {
                        user_id: userID,
                        detail_prd_size_id_del: sizeVal,
                    },
                    success: function(data) {
                        $renderCart.html(data);
                        event();
                        
                    },
                    error: function() {

                    }
                })
            }
            function event() {
            
            $decreaseBtn = $('.item-cart-product .quantity .decrease');
            $increaseBtn = $('.item-cart-product .quantity .increase');
            $removeBtn = $('.item-cart-product .remove');
            $removeBtn.click(function(){
                prd_id = this.getAttribute('dataID');
                size = this.getAttribute('dataSize');
                console.log(size);
                if(confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng khônng?")){
                    delData($user_id, size);
                }
        
                
            })
            $decreaseBtn.click(function(){
                quantityEl = this.parentElement;
                size = quantityEl.getAttribute('dataSize');
                quantity = quantityEl.querySelector('span');
                valueQuantity = quantity.textContent;
                if(valueQuantity>1){
                    valueQuantity-=1;
                    quantity.textContent = valueQuantity;
                    getData($user_id,valueQuantity,size);
                }
            })
            $increaseBtn.click(function(){
                quantityEl = this.parentElement;
                prd_id = quantityEl.getAttribute('dataID');
                size = quantityEl.getAttribute('dataSize');
                quantity = quantityEl.querySelector('span');
                valueQuantity = parseInt(quantity.textContent);
                if(valueQuantity<100){
                    valueQuantity+=1;
                    quantity.textContent = valueQuantity;
                    getData($user_id,valueQuantity,size);

                }
            })
           
            
            // for (let i = 0; i < decreaseBtn.length; i++) {
            //     decreaseBtn[i].addListener('click', function() {
            //         console.log("ok");
            //     })
            // }
        }


        })

        function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    </script>