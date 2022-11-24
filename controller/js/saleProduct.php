<script>
        const filterValue = document.querySelectorAll('.menu-filter input[type="checkbox"]');
        const filterSite = document.querySelector('.filter-value');
        let pageID = 1;
        let array = [];
        let json = {
            "price": [],
            "color": []
        };
        for (let i = 0; i < filterValue.length; i++) {
            filterValue[i].addEventListener('change', function() {
                const grandParent = this.parentElement.parentElement;
                const value = grandParent.querySelector('span').textContent;
                const dataFilter = this.getAttribute("data");
                const type = this.getAttribute("data-type");
                // console.log(type);
                if (this.checked) {
                    array.push(value);
                    switch (type) {
                        
                        case 'price':
                            json.price.push(dataFilter);
                            break;
                        case 'color':
                            json.color.push(dataFilter);
                            break;
                    }

                } else {
                    array = array.filter(item => item !== value)
                    switch (type) {
                        
                        case 'price':
                            json.price = json.price.filter(item => item !== dataFilter);
                            break;
                        case 'color':
                            json.color = json.color.filter(item => item !== dataFilter);
                            break;
                    }


                }
                filterSite.innerHTML = '';
                array.forEach((e) => {
                    filterSite.innerHTML += `<li>${e}</li>`
                });
                console.log(json);
                getData(pageID, json);
            })
        }
        $(function() {
            $category = <?php if(isset($_GET['category']))
                         {echo $_GET['category'];}
                         else{ ?>
            'all';
            <?php }?>;
            <?php if(isset($_GET['sale']))
                         {?>$sale = <?php echo $_GET['sale']; }
                         else{ ?>
            $sale = 0;
            <?php }?>;

            
            $select = '#left-menu-site li #' + $category ;
            $leftMenu = $($select);
            $leftMenu.css({"text-decoration": "underline", "font-weight":"bold"});            
            $contentProducts = $('.renderProduct');
            getData(pageID, json);
            // $pageBtn = $('.pagination .page-index');
            // console.log($contentProducts);
            // $pageBtn.click(function() {
            //     console.log("click");
            //     pageID = parseInt(this.textContent);
            //     getData(pageID, array)
            // })

            // function getData(pageID) {
            //     $.get("renderProduct.php", {
            //         category: $category,
            //         page: pageID
            //     }, (data) => {
            //         $contentProducts.html(data);
            //     })
            // }

        });

        function getData(pageID, data) {

            $.ajax({
                type: 'GET',
                url: 'controller/renderSale.php',
                data: {
                    category: $category,
                    page: pageID,
                    filter: data
                },
                success: function(data) {
                    $contentProducts.html(data);
                    $pageBtn = $('.pagination .page-index');
                    $previous = $('.previous-pag');
                    $next = $('.next-pag');
                    $previous.click(function() {
                        if (pageID > 1) {
                            pageID -= 1;
                            getData(pageID, json);
                        }
                    });
                    $next.click(function() {
                        if (pageID < $pageBtn.length) {
                            pageID += 1;
                            getData(pageID, json);
                        }
                    })
                    $pageBtn.click(function() {
                        pageID = parseInt(this.textContent);
                        getData(pageID, json);

                    })

                },
                error: function() {
                    alert('error');
                }

            })


           
            



        }
    </script>