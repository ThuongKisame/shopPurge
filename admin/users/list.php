<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);


    while($item = mysqli_fetch_assoc($result)){
        $user_id = $item['user_id'];
        $sqlOrder = "SELECT * FROM orders WHERE user_id = $user_id AND state='4'";
        $resultOrder = mysqli_query($conn, $sqlOrder);
        $countOrder = mysqli_num_rows($resultOrder);
        $json[]= ["user_id"=>$item['user_id'], "nameUser"=>$item['nameUser'], "email"=>$item['email'], "phoneNumber"=>$item['phoneNumber'],"verify"=>$item['verify'],"date_create"=>$item['date_create'], "countOrder"=>$countOrder];

    }

    // print_r(json_encode($json));
    // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách khách hàng</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json); ?></span> khách hàng</h6>
                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                            <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">

                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="dateCreate">
                                    <option value="" selected="selected">Sắp xếp theo ngày tạo tài khoản</option>
                                    <option value="increase" >Tăng dần</option>
                                    <option value="decrease" >Giảm dần</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="orders">
                                    <option value="" selected="selected">Sắp xếp theo đơn hàng</option>
                                    <option value="increase" >Tăng dần</option>
                                    <option value="decrease" >Giảm dần</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="verify">
                                    <option value="" selected="selected">Sắp xếp xác thực email</option>
                                    <option value="1" >Đã xác thực</option>
                                    <option value="0" >Chưa xác thực</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Xác thực email</th>
                                    <th>Ngày tạo tài khoản</th>
                                    <th>Đơn hàng đã mua</th>
                                    <th>Xem đơn hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                


                            </tbody>

                        </table>
                    </div>
                </div>

                <script>

            $(function(){
                $search = $('#search-box');
            $dateCreate = $('#dateCreate');
            $orders = $('#orders');
            $verify = $('#verify');
            $dateCreateValue = "";
            $ordersValue = "";
            $verifyValue = "";
                $json = <?php print_r(json_encode($json)) ?>;
                renderData($json);

                $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['nameUser'].search($searchValue) > -1)||(v['email'].search($searchValue) > -1)||(v['phoneNumber'].search($searchValue) > -1) || (v['date_create'].search($searchValue) > -1));
            });
            renderData($data)
        })


            $dateCreate.on('change', function(){
            $dateCreateValue = $dateCreate.val();
            renderFilter($dateCreateValue , $ordersValue, $verifyValue, $json);
        })

        $orders.on('change', function(){
            $ordersValue = $orders.val();
            renderFilter($dateCreateValue , $ordersValue, $verifyValue, $json);


        })

        $verify.on('change', function(){
            $verifyValue = $verify.val();
            renderFilter($dateCreateValue , $ordersValue, $verifyValue, $json);


        })


        function renderFilter($dateCreate , $orders, $verify, $json){
            $data =$json;
            if($dateCreate == 'increase'){
                $data.sort(function (a, b) {
                    // console.log(a.date_create < b.date_create);
                    if (a.date_create < b.date_create) {
                        return -1;
                    }
                    if (a.date_create > b.date_create) {
                        return 1;
                    }
                    return 0;
                });
            }

            if($dateCreate == 'decrease'){
                $data.sort(function (a, b) {
                    if (b.date_create < a.date_create) {
                        return -1;
                    }
                    if (b.date_create > a.date_create) {
                        return 1;
                    }
                    return 0;

                });

            }

            if($orders == 'decrease'){
                $data.sort(function (a, b) {
                    return b.countOrder - a.countOrder;
                });
            }

            if($orders == 'increase'){
                $data.sort(function (a, b) {
                    return a.countOrder - b.countOrder;
                });

            }

           

            if($verify!=''){
                    $data = $.grep($data, function(v) {
                return v['verify'] == $verify;
            });
            }



            
            renderData($data)

            

        }

        function validateData($input) {
            return $input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

        
        }

                function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $tbody.append(` <tr>
                                        <td>${$index}</td>
                                        <td>${value['nameUser']}</td>
                                        <td>${value['email']}</td>
                                        <td>${value['phoneNumber']}</td>
                                        <td>${value['verify']}</td>
                                        <td>${value['date_create']}</td>
                                        <td>${value['countOrder']}</td>
                                        <td><a href="./index.php?menu=2&layout=detail&id=${value['user_id']}"><button type="button" class="btn btn-success">Xem đơn hàng</button></a></td>
                                    </tr>
                                
                                `)
            })


            $btnDetail = $('.detail');
            $btnDetail.on('click', function(){
            $extra = $(this).parent().parent().next();
            console.log($extra);
            $extra.slideToggle();
        })  
        }
            })

    function del(name){
        return confirm("Bạn có muốn xóa khách hàng: "+name+"?")
    }
</script>