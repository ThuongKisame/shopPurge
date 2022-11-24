<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM staff, power WHERE staff.power_id = power.power_id";
    $result = mysqli_query($conn, $sql);
    while($item = mysqli_fetch_assoc($result)){
        $json[]=["staff_id"=>$item['staff_id'], "email"=>$item['email'], "staff_name"=>$item['staff_name'], "power_id"=>$item['power_id'], "phoneNumber"=>$item['phoneNumber'], "date_create"=>$item['date_create'], "power_name"=>$item['power_name']];

    }

    // print_r(json_encode($json));
    // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách tài khoản nhân viên</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> tài khoản</h6>
                        <a class="btn btn-primary" href="index.php?menu=6&layout=add">Thêm mới</a>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">
                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="time">
                                    <option value="" selected="selected">Sắp xếp theo ngày tạo</option>
                                    <option value="increase" >Giá tăng dần</option>
                                    <option value="decrease" >Giá giảm dần</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="power">
                                    <option value="" selected="selected">Sắp xếp theo nhóm quyền</option>
                                    <?php
                                        $sql_power = "SELECT * FROM power";
                                        $result_power = mysqli_query($conn, $sql_power);
                                        while($itemPower = mysqli_fetch_assoc($result_power)){
                                            ?>
                                            <option value="<?php echo $itemPower['power_id'] ?>" ><?php echo $itemPower['power_name'] ?></option>

                                            <?php
                                        }
                                    
                                    ?>
                                    <!--  -->
                                    </select>
                                </div>
                                
                            </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Tên nhóm quyền</th>
                                    <th>Ngày tạo</th>
                                    <th>Sửa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($product = mysqli_fetch_assoc($result)){
                                    $index++;
                                    ?>
                                    <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo $product['staff_name'] ?></td>
                                    <td><?php echo $product['email'] ?></td>
                                    <td><?php echo $product['phoneNumber'] ?></td>
                                    <td><?php echo $product['power_name'] ?></td>
                                    <td><?php echo $product['date_create'] ?></td>                                       
                                    <td><a href="./index.php?menu=6&layout=edit&id=<?php echo $product['staff_id'] ?>"><button type="button" class="btn btn-success">Sửa</button></a></td>
                                </tr>                                  
                                    <?php 
                                } ?>
                                
                                


                            </tbody>

                        </table>
                    </div>
                </div>

                <script>
    function del(name){
        return confirm("Bạn có muốn xóa sản phẩm: "+name+"?")
    }

    $(function(){
        
        $search = $('#search-box');
        $power = $('#power');
        $time = $('#time');
        // $newArrival = $('#newArrival');
        $powerValue = "";
        $timeValue = "";
        // $newArrivalValue = "";
        $json = <?php print_r(json_encode($json)) ?>;
       
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['staff_name'].search($searchValue) > -1)||(v['email'].search($searchValue) > -1)||(v['phoneNumber'].search($searchValue) > -1) || (v['power_name'].search($searchValue) > -1)||(v['date_create'].search($searchValue) > -1));
            });
            renderData($data)
        })


        $time.on('change', function(){
            $timeValue = $time.val();
            renderFilter($timeValue , $powerValue, $json);
        })

        $power.on('change', function(){
            $powerValue = $power.val();
            renderFilter($timeValue , $powerValue, $json);

        })

        // $newArrival.on('change', function(){
        //     $newArrivalValue = $newArrival.val();
        //     renderFilter($priceValue , $categoryValue, $newArrivalValue, $json);


        // })
        // renderFilter($priceValue , $categoryValue, $newArrivalValue, $json);


        function renderFilter($time , $power, $json){
            $data =$json;
            if($time == 'increase'){
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

            if($time == 'decrease'){
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
            if($power!==''){
                    $data = $.grep($data, function(v) {
                return v['power_id'] === $power;
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
                $tbody.append(` <tr>
                                    <td>${$index}</td>
                                    <td>${value['staff_name']}</td>
                                    <td>${value['email']}</td>
                                    <td>${value['phoneNumber']}</td>
                                    <td>${value['power_name']}</td>
                                    <td>${value['date_create']}</td>                                       
                                    <td><a href="./index.php?menu=6&layout=edit&id=${value['staff_id']}"><button type="button" class="btn btn-success">Sửa</button></a></td>
                                </tr>    
                                
                                `)
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