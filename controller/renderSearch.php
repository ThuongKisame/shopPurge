<?php 
if(isset($_GET['btn-search'])){
    $data = $_GET['data'];
    $perPage = 4;
    $page = $_GET['btn-search'];
    $sql_search = "SELECT * FROM products, sale, detail_product
    WHERE products.sale_id = sale.sale_id
    AND detail_product.prd_id = products.prd_id";
    $result_search = mysqli_query($conn, $sql_search);
    $data = trim($data);
    $arrayData = explode(" ", $data);
    $dataFilter = array();
    while($product = mysqli_fetch_assoc($result_search)){
        // echo $product['']
        foreach($arrayData as $value){
            $flag = strpos($product['prd_name'], $value);
            if($flag>-1){
                array_push($dataFilter, $product);
                break;
            }
        }
    }

    // print_r(json_encode($dataFilter));

    // $totalPage =ceil(count($dataFilter)/$perPage) ;
    // $start = ($page-1)*$perPage;
    // $end = ($perPage*$page)-1;
    
}

?>

<div id="main-search">
    <div class="container">
        <h2>Tìm kiếm</h2>
        <p id="amoust-result-search">Có <span><?php echo count($dataFilter); ?></span> sản phẩm cho tìm kiếm</p>
        <hr>
        <p id="keyword-search">Kết quả tìm kiếm cho <strong>"<?php echo $data ?>"</strong></p>
        <div id="collection-search" class="row">
        </div>
        
        <div class="pagination">
            
        </div>



        
    </div>

</div>
<script>
    $data =<?php echo json_encode($dataFilter) ?>;
    console.log($data);
    const filterValue = document.querySelectorAll('.menu-filter input[type="checkbox"]');
    const filterSite = document.querySelector('.filter-value');
    let pageID = 1;
    let array = [];

    let json = {
        "price": [],
        "color": [],
        "category": []
    };
    for (let i = 0; i < filterValue.length; i++) {
        filterValue[i].addEventListener('change', function() {
            const grandParent = this.parentElement.parentElement;
            const value = grandParent.querySelector('span').textContent;
            const dataFilter = this.getAttribute("data");
            const type = this.getAttribute("data-type");
            
            if (this.checked) {
                array.push(value);
                switch (type) {
                    case 'price':
                        json.price.push(dataFilter);
                        break;
                    case 'color':
                        json.color.push(dataFilter);
                        break;
                    case 'category':
                        json.category.push(dataFilter);
                        break;
                }

            } else {
                array = array.filter(item => item !== value);

                switch (type) {
                    case 'price':
                        json.price = json.price.filter(item => item !== dataFilter);
                        break;
                    case 'color':
                        json.color = json.color.filter(item => item !== dataFilter);
                        break;
                    case 'category':
                        json.category = json.category.filter(item => item !== dataFilter);
                        break;
                }


            }
            filterSite.innerHTML = '';
            array.forEach((e) => {
                filterSite.innerHTML += `<li>${e}</li>`
            });
            filter(json.category ,json.color, json.price, $data)

        })
    }

    function filter($category ,$color, $price, $json){
        $data = $json;
        console.log($data);
        

        
        $tmp = [];
        $.each($data, function(index, value){
            $.each($category, function(ind, val){
                if(value['category_id']==val){
                    $tmp.push(value);
                }
            })
        })
        if(!$category.length){
            $tmp = $data;
        }
        
        $tmp1=[];
        $.each($tmp, function(index, value){
            $.each($color, function(ind, val){
                if(value['color_id']==val){
                    $tmp1.push(value);
                }
            })
        })

        if(!$color.length){
            $tmp1 = $tmp;
        }
        

        $tmp2=[];
        $.each($tmp1, function(index, value){
            $.each($price, function(ind, val){
                
                switch(val){
                    case "1": 

                        if(value['price'] < 100000){
                            $tmp2.push(value);
                        }
                        break;
                    case "2": 
                        if(value['price'] >= 100000 && value['price'] < 200000){
                            $tmp2.push(value);
                        }
                        break;
                    case '3': 
                        if(value['price'] >= 200000 && value['price'] < 300000){
                            $tmp2.push(value);
                        }
                        break;
                    case '4': 
                        if(value['price'] >= 300000 && value['price'] < 500000){
                            $tmp2.push(value);
                        }
                        break;
                    case '5': 
                        if(value['price'] >= 500000){
                            $tmp2.push(value);
                        }
                        break;
                        
                }

                
            })
        })
        if(!$price.length){
            $tmp2 = $tmp1;
        }
            
        console.log($tmp2);
        render($tmp2);
        // $.each($color, function(index, value){
        //     if(value!==''){
        //         $data = $.grep($data, function(v) {
        //     return v['category_id'] === value;
        // });
        // }
        // })

        // $.each($price, function(index, value){
        //     if(value!==''){
        //         $data = $.grep($data, function(v) {
        //     return v['category_id'] === value;
        // });
        // }
        // })
    }
   


    
        render($data);


        function render($data) {
            $dataFilter = $data;
            $totalPage = Math.ceil($data.length/4);
            $titleResult = $('#amoust-result-search span');
            $sidePagination = $('.pagination');
            $titleResult.html($data.length);
            $text='';
            for($i=1;$i<=$totalPage;$i++){
                if($i == 1){
                    $text+=`<li class="page-index active">
                    ${$i}
                </li>`
                }
                else{
                    $text+=`<li class="page-index">
                    ${$i}
                </li>`
                }
            }
            $sidePagination.html(`<ul>
                <li class="previous-pag"><i class="bx bxs-chevrons-left"></i></li>
                ${$text}
                <li class="next-pag"><i class="bx bxs-chevrons-right"></i></li>
            </ul>`);


            $page = $('.pagination .page-index');
            $pageValue = 1;
            $btnNext = $('.next-pag');
            $btnPre = $('.previous-pag');

            $btnNext.click(function() {
                if ($pageValue < $totalPage) {
                    $pageValue += 1;
                }
                $page.removeClass('active');
                $page.each(function() {
                    if ($(this).text() == $pageValue) {
                        $(this).addClass('active');
                        content($pageValue, $dataFilter);
                    }

                })
            })

            $btnPre.click(function() {
                if ($pageValue > 1) {
                    $pageValue -= 1;
                }
                $page.removeClass('active');
                $page.each(function() {

                    if ($(this).text() == $pageValue) {
                        $(this).addClass('active');
                        content($pageValue, $dataFilter);
                    }

                })
            })

            $page.click(function() {
                $pageValue = $(this).text();
                $page.removeClass('active');
                $(this).addClass('active');
                content($pageValue, $dataFilter);
            })
            content(1, $dataFilter);

            
        }

        function content(page, $dataFilter) {
                $resultSearch = $('#collection-search');
                $perPage = 4;
                $pageValue = page;
                $start = ($pageValue - 1) * $perPage;
                $end = ($perPage * $pageValue) - 1;
                $data1 = '';
                for ($i = $start; $i <= $end; $i++) {
                    if ($dataFilter[$i]) {
                        $data1 += `<div class="product-img col-3 col-xs-6 col-tb-4 play-on-scroll start">
                    <a href="detailProduct.php?id=${$dataFilter[$i]['prd_id']}">
                    <img src="view/img/${$dataFilter[$i]['image_front']}" alt="">
                    <div class="name-product">
                    ${$dataFilter[$i]['prd_name']}
                    </div>
                    <div class="price-product">
                    ${numberWithCommas($dataFilter[$i]['price'])}₫
                    </div>
                    <span class="state-product">-${$dataFilter[$i]['percent']}%</span>
                    
                    </a>
                </div>`;
                    }

                }
                $resultSearch.html($data1);

            }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    
</script>