<script>
        $(function(){
            $totalPage = <?php echo $totalPage;?>;
            $resultSearch = $('#collection-search');
            $page = $('.pagination .page-index');
            $pageValue = 1;
            $btnNext =$('.next-pag');
            $btnPre =$('.previous-pag');

            $btnNext.click(function(){
                if($pageValue < $totalPage){
                    $pageValue+=1;
                    }
                $page.removeClass('active');
                $page.each( function(){

                        if($(this).text() == $pageValue ){
                            $(this).addClass('active');
                            content($pageValue);
                        }
                    
               })
            })

            $btnPre.click(function(){
                if($pageValue > 1){
                    $pageValue-=1;
                    }
                $page.removeClass('active');
                $page.each( function(){

                        if($(this).text() == $pageValue ){
                            $(this).addClass('active');
                            content($pageValue);
                        }
                    
               })
            })
            
            $page.click(function(){
                $pageValue = $(this).text();
                $page.removeClass('active');
                $(this).addClass('active');
                content($pageValue);
            })


            function content(page){
                $perPage =4;
                $pageValue = page;
                $start = ($pageValue-1)*$perPage;
                $end = ($perPage*$pageValue)-1;
                $dataFilter = <?php echo json_encode($dataFilter); ?>;

                $data ='';
                for($i=$start; $i<=$end;$i++){
                    if($dataFilter[$i]){
                        $data+= `<div class="product-img col-3 col-xs-6 col-tb-4 play-on-scroll start">
                    <img src="view/img/${$dataFilter[$i]['image_front']}" alt="">
                    <div class="name-product">
                    ${$dataFilter[$i]['prd_name']}
                    </div>
                    <div class="price-product">
                    ${numberWithCommas($dataFilter[$i]['price'])}
                    </div>
                    <span class="state-product">-${$dataFilter[$i]['percent']}%</span>
                </div>`;
                    }
                    
                }
                $resultSearch.html($data);

            }
            function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
        })
    </script>