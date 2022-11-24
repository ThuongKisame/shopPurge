<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM sale";
    $result = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($result);
    $json = array();
    while($item = mysqli_fetch_assoc($result)){
        $json[]=["sale_id"=>$item['sale_id'], "sale_name"=>$item['sale_name'], "date_start"=>$item['date_start'], "date_end"=>$item['date_end'], "percent"=>$item['percent'], "category"=>$item['category']];
    }

    // print_r(json_encode($json));
    // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách chương trình giảm giá</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> chương trình</h6>
                        <a class="btn btn-primary" href="./index.php?menu=4&layout=add">Thêm mới</a>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">
                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="time">
                                    <option value="" selected="selected">Sắp xếp theo thời gian</option>
                                    <option value="increase" >Tăng dần</option>
                                    <option value="decrease" >Giảm dần</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="percent">
                                    <option value="" selected="selected">Sắp xếp theo giá trị giảm giá</option>
                                    <option value="increase" >Tăng dần</option>
                                    <option value="decrease" >Giảm dần</option>
                                    </select>
                                </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                    <th>STT</th>
                                    <th>Tên chương trình giảm giá</th>
                                    <th>Giảm giá(%)</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Áp dụng</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                
                                


                            </tbody>

                        </table>
                    </div>
                </div>

                <script>
    function del(name){
        return confirm("Bạn có muốn xóa nhóm quyền này không?")
    }


    $(function(){
        
        $search = $('#search-box');
        $time = $('#time');
        $percent = $('#percent');
        $timeValue = "";
        $percentValue = "";
        $json = <?php print_r(json_encode($json)) ?>;
        // renderData($data);
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['sale_name'].search($searchValue) > -1)||(v['percent'].search($searchValue) > -1)||(v['date_start'].search($searchValue) > -1) || (v['date_end'].search($searchValue) > -1)||(v['category'].search($searchValue) > -1));
            });
            renderData($data)
        })
        renderData($json)



        $time.on('change', function(){
            $timeValue = $time.val();
            renderFilter($timeValue , $percentValue, $json);
        })

        $percent.on('change', function(){
            $percentValue = $percent.val();
            renderFilter($timeValue , $percentValue, $json);
        })

       

        function renderFilter($time , $percent,  $json){
            $data =$json;
            if($time == 'increase'){
                $data.sort(function (a, b) {
                    // console.log(a.date_create < b.date_create);
                    if (a.date_start < b.date_start) {
                        return -1;
                    }
                    if (a.date_start > b.date_start) {
                        return 1;
                    }
                    return 0;
                });
            }

            if($time == 'decrease'){
                $data.sort(function (a, b) {
                    // console.log(a.date_create < b.date_create);
                    if (b.date_start < a.date_start) {
                        return -1;
                    }
                    if (b.date_start > a.date_start) {
                        return 1;
                    }
                    return 0;
                });

            }

            if($percent == 'decrease'){
                $data.sort(function (a, b) {
                    return b.percent - a.percent;
                });
            }

            if($percent == 'increase'){
                $data.sort(function (a, b) {
                    return a.percent - b.percent;
                });
            }


            
            
            renderData($data)

            

        }


        function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $tbody.append(` <tr>
                                        <td>${$index}</td>
                                        <td>${value['sale_name']}</td>
                                        <td>${value['percent']}%</td>
                                        <td>${value['date_start']}</td>
                                        <td>${value['date_end']}</td>
                                        <td>${value['category']}</td>
                                        <td><a onclick="return del()" href="./index.php?menu=4&layout=del&id=${value['sale_id']}"><button type="button" class="btn btn-danger">Xóa</button></a></td>                                        
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