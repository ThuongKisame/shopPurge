<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM import, staff WHERE staff.staff_id = import.staff_id";
    $result = mysqli_query($conn, $sql);
    $json = array();
    while($item = mysqli_fetch_assoc($result)){
        $import_id=$item['import_id'];
        $sql1="SELECT * FROM detail_import, detail_product_size, detail_product, products , color,size
         WHERE import_id =$import_id
         AND size.size_id = detail_product_size.size_id
         AND color.color_id = detail_product.color_id
         AND detail_product_size.detail_prd_size_id = detail_import.detail_prd_size_id 
         AND detail_product_size.detail_prd_id =detail_product.detail_prd_id
         AND  detail_product.prd_id = products.prd_id";
        $result1 = mysqli_query($conn, $sql1);
        $detail =array();
        while($item1 = mysqli_fetch_assoc($result1)){
            $detail[]=["detail_import_id"=>$item1['detail_import_id'],"size_name"=>$item1['size_name'], "amount"=>$item1['amount'], "color_name"=>$item1['color_name'], "prd_name"=>$item1['prd_name']];
        }
        $json[]=["import_id"=>$item['import_id'], "staff_name"=>$item['staff_name'], "date"=>$item['date'], "detail"=>$detail];
    }
    // print_r(json_encode($json));
        // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<style>
    .detail{
        display:flex;
        justify-content: center;
    }
    .detail li{
        width: 20%;
    }
</style>



<div class="card">
                    <div class="card-header">
                        <h3>Danh sách đơn nhập hàng</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> thể loại</h6>
                        <a class="btn btn-primary" href="./index.php?menu=13&layout=add">Nhập kho</a>

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
                                
                        </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                    <th>STT</th>
                                    <th>ID</th>
                                    <th>Thời gian</th>
                                    <th>Nhân viên</th>
                                    <th>Chi tiết</th>
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
        $timeValue = "";

        $json = <?php print_r(json_encode($json)) ?>;
       
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['staff_name'].search($searchValue) > -1));
            });
            renderData($data)
        })

        $time.on('change', function(){
            $timeValue = $time.val();
            renderFilter($timeValue, $json);
        })

        function renderFilter($time ,  $json){
            $data =$json;
            if($time == 'increase'){
                $data.sort(function (a, b) {
                    // console.log(a.date_create < b.date_create);
                    if (a.date < b.date) {
                        return -1;
                    }
                    if (a.date > b.date) {
                        return 1;
                    }
                    return 0;
                });
            }

            if($time == 'decrease'){
                $data.sort(function (a, b) {
                    // console.log(a.date_create < b.date_create);
                    if (b.date < a.date) {
                        return -1;
                    }
                    if (b.date > a.date) {
                        return 1;
                    }
                    return 0;
                });
            }

            


            
            
            renderData($data)

            

        }


      

        renderData($json)
        function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $detail='';
                $.each(value['detail'], function(ind, val){
                    $detail+=`<ul class="detail">
                                <li>${val['detail_import_id']}</li>
                                <li>${val['prd_name']}</li>
                                <li>${val['color_name']}</li>
                                <li>${val['size_name']}</li>
                                <li>${val['amount']}</li>
                            </ul>`
                })

                $tbody.append(`     <tr>
                                        <td>${$index}</td>
                                        <td>${value['import_id']}</td>
                                        <td>${value['date']}</td>
                                        <td>${value['staff_name']}</td>
                                        <td><button type="button" class="btn btn-info btn-detail">Chi tiết</button></td>
                                    </tr>
                                    <tr style="display: none">
                                        <td colspan=5>
                                        <ul class="detail">
                                            <li><strong>ID</strong></li>
                                            <li><strong>Tên sản phẩm</strong></li>
                                            <li><strong>Màu sản phẩm</strong></li>
                                            <li><strong>Size</strong></li>
                                            <li><strong>Số lượng</strong></li>
                                        </ul>
                                        ${$detail}
                                        </td>
                    
                                     </tr>
                                   
                                
                                `)
               
            })

            $btnDetail = $('.btn-detail');
            $btnDetail.on('click', function(){
                $render = $(this).parent().parent().next();
                $render.slideToggle();
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