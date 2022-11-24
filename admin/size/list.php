<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM size";
    $result = mysqli_query($conn, $sql);
    $json = array();
    while($item = mysqli_fetch_assoc($result)){
        $json[]=["size_id"=>$item['size_id'], "size_name"=>$item['size_name']];
    }
    // print_r(json_encode($json));
        // $total = mysqli_num_rows($result);
    // $index = 0;
?>



<div class="card">
                    <div class="card-header">
                        <h3>Danh sách thể loại</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> thể loại</h6>
                        <a class="btn btn-primary" href="./index.php?menu=10&layout=add">Thêm mới</a>

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
                                    <th>Tên size</th>
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
                                        <td>${$index}</td>
                                        <td>${value['size_name']}</td>
                                        <td><a href="./index.php?menu=10&layout=edit&id=${value['size_id']}"><button type="button" class="btn btn-success">Sửa</button></a></td>
                                    <td><a onclick="return del()" href="./index.php?menu=10&layout=del&id=${value['size_id']}"><button type="button" class="btn btn-danger">Xóa</button></a></td>
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