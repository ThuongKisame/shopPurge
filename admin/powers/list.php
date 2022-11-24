<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM power";
    $result = mysqli_query($conn, $sql);

    while($item = mysqli_fetch_assoc($result)){
        $power_id = $item['power_id'];
        $sql_detail = "SELECT * FROM power_detail, title WHERE power_id = $power_id AND title.title_id = power_detail.title_id";
        $result_detail = mysqli_query($conn, $sql_detail);
        $array = array();
        while($itemDetail = mysqli_fetch_assoc($result_detail)){
            array_push($array, $itemDetail['title_name']);
        }
        $json[]=["power_id"=>$item['power_id'], "power_name"=>$item['power_name'], "title"=>$array];
    }
        // $total = mysqli_num_rows($result);
    // $index = 0;
?>

<style>
    .title-box{
        display: flex;
        flex-wrap: wrap;
    }

    .title-box .title-name{
        /* background-color: rgba(0,0,0,0.2); */
        border-radius: 10px;
        display:flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 5px;
        border: 1px solid blue;
        
    }

</style>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách nhóm quyền</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> nhóm quyền</h6>
                        <a class="btn btn-primary" href="./index.php?menu=8&layout=add">Thêm mới</a>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">
                            <h4>Tìm kiếm theo danh mục</h4>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                    <th>STT</th>
                                    <th>Tên nhóm quyền</th>
                                    <th>Danh mục</th>
                                    <th>Sửa</th>
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
        
        $json = <?php print_r(json_encode($json)) ?>;
       
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['power_name'].search($searchValue) > -1));
            });
            renderData($data)
        })


      

        renderData($json)
        function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $tbody.append(` <tr>
                                        <td>${index}</td>
                                        <td>${value['power_name']}</td>
                                        <td><button type="button" class="btn btn-primary title">Danh mục</button></td>
                                        <td><a href="./index.php?menu=8&layout=edit&id=${value['power_id']}"><button type="button" class="btn btn-success">Sửa</button></a></td>
                                    <td><a onclick="return del()" href="./index.php?menu=8&layout=del&id=${value['power_id']}"><button type="button" class="btn btn-danger">Xóa</button></a></td>
                                    </tr>
                                    <tr style="display: none">
                                        <td colspan = 4 >
                                            <div class="title-box" id="title-${value['power_id']}">
                                                
                                            </div>
                                        </td>
                                    </tr>
                                
                                `)
                $textTitle = '#title-'+value['power_id'];
                $titleRender = $($textTitle);
                $.each(value['title'], function(i, v){
                    $titleRender.append(`<div class="title-name col-2">${v}
                                                </div>`)

                })
            })
            $title = $('.title');
        $title.on('click', function(){
            $renderSide = $(this).parent().parent().next();
            $renderSide.slideToggle();
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