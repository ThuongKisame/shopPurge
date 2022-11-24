<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM orders order by date desc";
    $result = mysqli_query($conn, $sql);
    $json = array();
    while($item = mysqli_fetch_assoc($result)){
        $order_id = $item['order_id'];
        $sql_order = "SELECT * FROM detail_order WHERE order_id = $order_id";
        $result_order = mysqli_query($conn, $sql_order);
        $array = array();
        while($itemOrder = mysqli_fetch_assoc($result_order)){
            array_push($array, ["prd_name"=>$itemOrder['prd_name'], "quantity"=>$itemOrder['quantity'], "size"=>$itemOrder['size'], "sale"=>$itemOrder['percent'],  "price"=>$itemOrder['price'], "image_front"=>$itemOrder['image_front'], "color"=>$itemOrder['color']]);
        }
        $json[] = ["order_id"=>$item['order_id'], "user_id"=>$item['user_id'], "date"=>$item['date'], "name_customer"=>$item['name_customer'], "phoneNumber"=>$item['phoneNumber'], "address_detail"=>$item['address_detail'], "province"=>$item['province'], "district"=>$item['district'], "village"=>$item['village'], "state"=>$item['state'], "discount"=>$item['discount'], "date_confirm"=>$item['date_confirm'], "date_complete"=>$item['date_complete'], "date_receipt"=>$item['date_receipt'], "date_cancel"=>$item['date_cancel'], "staff_id"=>$item['staff_id'], "detail"=>$array];
    }

    // print_r(json_encode($json));
    // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách đơn hàng</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> đơn hàng</h6>
                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">
                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                            <div class="form-group">
                                <label for="">Từ</label>
                                <input type="datetime-local" id="time_start" name="date-start" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">
                                <label for="">Đến</label>
                                <input type="datetime-local" id="time_end" name="date-start" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">
                            </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="state">
                                    <option value="" selected="selected">Sắp xếp theo đơn hàng</option>
                                    <option value=1 >Chờ xác nhận</option>
                                    <option value=2 >Chờ xử lý</option>
                                    <option value=3 >Đang giao hàng</option>
                                    <option value=4 >Đơn hàng thành công</option>
                                    <option value=5 >Đơn hàng đã hủy</option>
                                    </select>
                                </div>
                               
                            </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên người nhận</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                    <th>Hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                



                            </tbody>

                        </table>
                    </div>
                </div>

                <script>
    function del(){
        return confirm("Bạn có muốn xóa đơn hàng này không");
    }

    function alertNotice(){
        alert('Bạn không thể hủy đơn hàng này');
    }

    $(function(){
        
        $search = $('#search-box');
        $state = $('#state');
        $stateValue = "";
        $json = <?php print_r(json_encode($json)) ?>;
        $time_start = $('#time_start');
        $time_end = $('#time_end');

        function input(){
            $time_startValue = $time_start.val();
            $time_endValue = $time_end.val();
            if($time_startValue!='' && $time_endValue!=''){
                renderFilter($stateValue, $time_startValue, $time_endValue, $json);
            }
        }

        
        if($time_start.on('change', function(){
            $time_end.attr('min', $time_start.val());
            input();
        }))
        if($time_end.on('change', function(){
            $time_start.attr('max', $time_end.val());
            input();
        }))
       
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['name_customer'].search($searchValue) > -1)||(v['phoneNumber'].search($searchValue) > -1)||(v['address_detail'].search($searchValue) > -1) || (v['village'].search($searchValue) > -1)||(v['district'].search($searchValue) > -1)||(v['province'].search($searchValue) > -1));
            });
            renderData($data)
        })


        $state.on('change', function(){
            $stateValue = $state.val();
            renderFilter($stateValue, $time_start.val(), $time_end.val(), $json);
        })

        //    renderFilter($priceValue , $categoryValue, $newArrivalValue, $json);


        // })

        // $newArrival.on('change', function(){
        //     $newArrivalValue = $newArrival.val();
        //     renderFilter($priceValue , $categoryValue, $newArrivalValue, $json);


        // })
        // renderFilter($priceValue , $categoryValue, $newArrivalValue, $json);


        function renderFilter($state, $time_start, $time_end, $json){
            $data =$json;
            
            if($state!==''){
                    $data = $.grep($data, function(v) {
                return v['state'] === $state;
            });
            }

            if($time_start!='' && $time_end!=''){
                $data = $.grep($data, function(v) {
                return (v['date'] >= $time_start && v['date'] <= $time_end)
                });
            }
          
            renderData($data)

            

        }
        renderData($json);

        function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $detail='';
                $.each(value['detail'], function(ind, val){
                    $totalPrice = val['price']*val['quantity']-val['price']*val['quantity']*val['sale']/100;
                    $detail+=`
                                            

                                                <ul class="col-5" style="text-align: left;">
                                                    <img style="float: left; width: 50%;" src="../view/img/${val['image_front']}" alt="" >
                                                    <li><strong>${val['prd_name']}</strong></li>
                                                    <li><strong>Color</strong> ${val['color']}</li>
                                                    <li><strong>Size</strong> ${val['size']}</li>
                                                    <li><strong>Số lượng :</strong> ${val['quantity']}</li>
                                                    <li><strong>Giá gốc:</strong> ${numberWithCommas(val['price'])}₫</li>
                                                    <li><strong>Sale: </strong> ${val['sale']}%</li>
                                                    <li><strong>Tổng: </strong> ${numberWithCommas($totalPrice)}₫</li>
                                                </ul>
                                        `
                })
                $tbody.append(`<tr>
                <td>${$index}</td>
                                    <td>${value['name_customer']}</td>
                                    <td>${value['phoneNumber']}</td>
                                    <td>${value['address_detail']} ${value['village']} ${value['district']} ${value['province']}</td>
                                    <td>
                                        <ul style="text-align: left" id="listTime-${value['order_id']}">
                                            <li><strong>Ngày đặt:</strong> ${value['date']} </li>
                                        </ul>
                                        
                                    </td>    
                                   <td><div id="btn-${value['order_id']}"><a href="./index.php?menu=5&layout=handle&id=${value['order_id']}&state=${value['state']}"><button type="button" class="btn btn-primary">Xác nhận đơn hàng</button></a></div></td>
                                    <td><button type="button" class="btn btn-info btn-detail">Chi tiết</button></td>
                                    <td id="cancel-${value['order_id']}"></td>
                                </tr>
                                <tr style="display:none">
                                <td colspan="8" id="prd-${value['order_id']}">
                                     
                                    <div style="display:flex";>
                                    ${$detail}  
                                    </div> 
                                </td>
                                    
                                        
                                    
                                </tr>
                                `)

                $text = '#listTime-'+value['order_id'];
                $textBtn = '#btn-'+value['order_id'];
                $textPrd = '#prd-'+value['order_id'];
                $textCancel  = '#cancel-'+value['order_id'];
                $listTime = $($text);
                $btnOrder = $($textBtn);
                $listPrd = $($textPrd);
                $btnCancel = $($textCancel);
                // console.log($btnOrder);
                if(value['date_confirm']!="0000-00-00 00:00:00"){
                    $listTime.append(`<li><strong>Ngày xác nhận:</strong> ${value['date_confirm']} </li>`);
                    $btnOrder.html(`<a href="./index.php?menu=5&layout=handle&id=${value['order_id']}&state=${value['state']}"><button type="button" class="btn btn-warning">Xác nhận xử lý xong</button></a>`);
                }
                if(value['date_complete']!="0000-00-00 00:00:00"){
                    $listTime.append(`<li><strong>Ngày vận chuyển:</strong> ${value['date_complete']} </li>`)
                    $btnOrder.html(`<button type="button" class="btn btn-light">Đơn hàng đang giao</button>`)
                    
                }
                if(value['date_receipt']!="0000-00-00 00:00:00"){
                    $listTime.append(`<li><strong>Ngày nhận hàng:</strong> ${value['date_receipt']} </li>`)
                    $btnOrder.html(`<button type="button" class="btn btn-success">Đơn hàng thành công</button>`)
                }
                if(value['date_cancel']!="0000-00-00 00:00:00"){
                    $listTime.append(`<li><strong>Ngày hủy:</strong> ${value['date_cancel']} </li>`)
                    $btnOrder.html(` <button type="button" class="btn btn-secondary">Đơn hàng đã bị hủy</button>`)
                
                }

                

               
                if(value['state']==4 || value['state']==5){
                    $btnCancel.html(`<button onclick="alertNotice()" type="button" class="btn btn-danger">Hủy</button>`)
                }
                else{
                    $btnCancel.html(`<a onclick="return del()" href="./index.php?menu=5&layout=handle&id=${value['order_id']}&state=6"><button type="button" class="btn btn-danger">Hủy</button></a>`)
                }

               
                                   


                


            })
            $btnDetail = $('.btn-detail');
                $btnDetail.on('click', function(){
                    $detailSide = $(this).parent().parent().next();
                    console.log($(this));
                    $detailSide.slideToggle();
                })


            
        }


        function validateData($input) {
            return $input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

        
        }
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    })
</script>