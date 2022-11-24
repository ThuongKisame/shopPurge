<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM store group by prd_id";
    $result = mysqli_query($conn, $sql);
    $prdIDArr = array();
    if(!empty(mysqli_num_rows($result))){
        while($itemPrd = mysqli_fetch_assoc($result)){
            array_push($prdIDArr, $itemPrd['prd_id']);
        }
    }

    foreach($prdIDArr as $i){
        $sql_get_store = "SELECT * FROM store, products WHERE store.prd_id = products.prd_id AND store.prd_id = $i";
        $result_get_store = mysqli_query($conn, $sql_get_store);
        $arrPrdInfo= array();
        $countTotal = 0;
        while($itemStore = mysqli_fetch_assoc($result_get_store)){
            $countTotal+=$itemStore['quantity'];
            $prd_name = $itemStore['prd_name'];
            $image = $itemStore['image_front'];
            $category = $itemStore['category'];
            array_push($arrPrdInfo,[$itemStore['size']=>$itemStore['quantity']]);
        }
        $json[]= ["prd_id"=>$i, "prd_name"=>  $prd_name, "image"=>$image, "category"=> $category, "store"=>$arrPrdInfo, "countTotal"=>$countTotal];

    }
    // print_r(json_encode($json));
    $total =0;
    foreach($json as $i){
            $total+=$i['countTotal'];
    }

    // $total = mysqli_num_rows($result);
    $index = 0;
?>

<div class="card">
                    <div class="card-header">
                        <h3>Kho sản phẩm</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo $total; ?></span> sản phẩm</h6>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                            <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">

                                <!-- <button class="btn btn-success" type="submit">Search</button> -->
                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="quantity">
                                    <option value="" selected="selected">Sắp xếp theo số lượng</option>
                                    <option value="increase" >Tăng dần</option>
                                    <option value="decrease" >Giảm dần</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="category">
                                    <option value="" selected="selected">Sắp xếp theo thể loại</option>
                                    <option value="tee" >Tee</option>
                                    <option value="jacket" >Jacket</option>
                                    <option value="hoodie" >Hoodie</option>
                                    <option value="pants" >Pants</option>
                                    <option value="sweater" >Sweater</option>
                                    <option value="accessories" >Accessories</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <select name="newArrival" class="form-control" id="size">
                                    <option value="" selected="selected">Sắp xếp theo size</option>
                                    <option value="s" >S</option>
                                    <option value="m" >M</option>
                                    <option value="l" >L</option>
                                    <option value="xl" >XL</option>
                                    <option value="xxl" >XXL</option>
                                    </select>
                                </div> -->
                                
                            </div>
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th>Thể loại</th>
                                    <th>Kho</th>
                                    <th>Sửa</th>
                                </tr>
                            </thead>
                            <tbody>
                                


                                
                                


                            </tbody>

                        </table>
                    </div>
                </div>

                <script>
    function del(name){
        return confirm("Bạn có muốn xóa sản phẩm: "+name+"?")
    }

    $(function(){
        $quantity = $('#quantity');
        $category = $('#category');
        $search = $('#search-box');

        // $size = $('#size');
        $quantityValue = "";
        $categoryValue = "";
        // $sizeValue = "";
        $json = <?php print_r(json_encode($json)) ?>;
        renderData($json);

        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['prd_name'].search($searchValue) > -1)||(v['category'].search($searchValue) > -1));
            });
            renderData($data)
        })


        $quantity.on('change', function(){
            $quantityValue = $quantity.val();
            renderFilter($quantityValue , $categoryValue, $json);
        })

        $category.on('change', function(){
            $categoryValue = $category.val();
            renderFilter($quantityValue , $categoryValue, $json);


        })

        // $size.on('change', function(){
        //     $sizeValue = $size.val();
        //     renderFilter($quantityValue , $categoryValue, $sizeValue, $json);
        // })


        function renderFilter($quantity , $category, $json){
            $data =$json;
            if($quantity == 'decrease'){
                $data.sort(function (a, b) {
                    return b.countTotal - a.countTotal;
                });

                
            }


            if($quantity == 'increase'){
                $data.sort(function (a, b) {
                    return a.countTotal - b.countTotal;
                });

            }
            if($category!==''){
                    $data = $.grep($data, function(v) {
                return v['category'] === $category;
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
                                                <td>${value['prd_name']}</td>
                                                <td style="width: 8%"><img  src="../view/img/${value['image']}" alt=""></td>     
                                                <td>${value['category']}</td>
                                                <td id="store-${value['prd_id']}"></td>
                                                <td><a href="./index.php?menu=3&layout=edit&id=${value['prd_id']}"><button type="button" class="btn btn-success">Sửa</button></a></td>
                                            </tr>
                                `);
                $id = '#store-'+value['prd_id'];
                $storeID = $($id);
                $.each(value['store'], function(index, v){
                    $.map(v, function(val, key){
                      $storeID.append(`<div><strong style="text-transform: uppercase;">${key}: </strong>${val}</div>`);

                    })
                })
            })


           
        }








      
    })
</script>