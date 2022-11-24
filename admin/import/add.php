<?php
    require_once '../model/db.php';
    require_once './onload.php';
    $sql = "SELECT * FROM products, category, sale WHERE products.category_id = category.category_id AND products.sale_id = sale.sale_id";
    $result = mysqli_query($conn, $sql);
    $json1 = new StdClass();
    while($item = mysqli_fetch_assoc($result)){
        $infoPrd = new StdClass();
        $prd_id = $item['prd_id'];
        $sql1 = "SELECT * FROM detail_product, color WHERE prd_id = $prd_id AND detail_product.color_id = color.color_id";
        $result1 = mysqli_query($conn, $sql1);
        $detail1 = new StdClass();

        while($item1 = mysqli_fetch_assoc($result1)){
            $infoColor = new StdClass();
            $detail_prd_id = $item1['detail_prd_id'];
            $sql2= "SELECT * FROM detail_product_size, size WHERE detail_prd_id = $detail_prd_id AND detail_product_size.size_id = size.size_id";
            $result2 = mysqli_query($conn, $sql2);
            $size1 = new StdClass();
            while($item2 = mysqli_fetch_assoc($result2)){
                $infoSize = new StdClass();
                $infoSize->size_name=$item2['size_name'];
                $detail_prd_size_id=$item2['detail_prd_size_id'];
                $size1->$detail_prd_size_id=$infoSize;
            }
            
            $infoColor->color_name=$item1['color_name'];
            $infoColor->size=$size1;
            $color_id = $item1['color_id'];
            $detail1->$color_id=$infoColor;
        }
        
        $infoPrd->prd_name = $item['prd_name'];
        $infoPrd->color = $detail1;
        $prd_id = $item['prd_id'];
        $json1->$prd_id =$infoPrd;
    }
    // print_r(json_encode($json1));


    
    if(isset($_POST['sbm'])){
            $size_id = $_POST['size_id']; 
            $quantity = $_POST['quantity'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $getDay= date("Y-m-d H:i:s");

            $sql = "SELECT * FROM import order by import_id desc LiMIT 1";
            $result =mysqli_query($conn, $sql);
            $item = mysqli_fetch_assoc($result);
            $import_id = $item['import_id'];
            $import_id++;


            $sql = "INSERT INTO import(import_id, date, staff_id) VALUES($import_id, '$getDay', $staff_id)";
            $result = mysqli_query($conn, $sql);
            echo $sql;


            foreach($size_id as $i=>$value){
                $sql = "UPDATE detail_product_size SET quantity = quantity+$quantity[$i] WHERE detail_prd_size_id = $value";
                $result = mysqli_query($conn, $sql);
                $sql = "INSERT INTO detail_import(import_id, amount, detail_prd_size_id)
                VALUES($import_id, $quantity[$i], $value)";
                $result = mysqli_query($conn, $sql);
            }
            // SELECT IDENT_CURRENT('import');
            

            
            // $sql = "INSERT INTO color(color_name) VALUES('$color_name')";
            // $result = mysqli_query($conn, $sql);
                  
            // addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            echo '<script> location.href = "index.php?menu=13"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form  action="index.php?menu=13&layout=add" method="POST" enctype="multipart/form-data" id="form-add-power">
                            <div id="renderInput">
                                <div class="box-input" style="display:flex">
                                    
                                    <div class="form-group col-3">
                                        <label for="">Tên sản phẩm</label>
                                        <select name="prd_id" class="form-control prd_id" id="prd_id">
                                            <option value="" selected="selected">Thể loại</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Màu sắc</label>
                                        <select name="color_id" class="form-control color_id" id="color_id">
                                            <option value="" selected="selected">Chọn màu</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Size</label>
                                        <select name="size_id[]" class="form-control size_id" id="size_id">
                                            <option value="" selected="selected">Chọn size</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="">Số lượng</label>
                                        <input type="text" name="quantity[]" id="quantity" class="form-control quantity" value="" >
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-1">
                                        <label for="">---</label>
                                        <button type="button" class="btn btn-danger btn-del">Xóa</button>
                                    </div>
                                    

                                    
                                </div>
                            
                            </div>
                                <button type="button" id="btn-add" class="btn btn-primary">Thêm</button>
                                <button type="submit" name="sbm" class="btn btn-success">Lưu</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddPower = document.querySelector('#form-add-power');
    // const color_name = document.querySelector('#color_name');

    




    formAddPower.addEventListener('submit', e => {
        const quantity =  document.querySelectorAll('.quantity');
        const size_id =  document.querySelectorAll('.size_id');
        const prd_id =  document.querySelectorAll('.prd_id');
        const color_id =  document.querySelectorAll('.color_id');

        let isSend = true;
        for(let i=0; i<quantity.length; i++){
            if (quantity[i].value === '') {
                setErrorFor(quantity[i], 'Chưa có thông tin số lượng');
            isSend = false;
            } else {
                if(isNaN(quantity[i].value) || quantity[i].value <= 0){
                setErrorFor(quantity[i], 'Số lượng không hợp lệ');
                isSend = false;
                }
                else{setSuccessFor(quantity[i]);
                quantity[i].value = validateData(quantity[i].value);}
                
            }
        }

        for(let i=0; i<prd_id.length; i++){
            if (prd_id[i].value === '') {
                setErrorFor(prd_id[i], 'Chưa có thông tin tên sản phẩm');
            isSend = false;
            } else {
                setSuccessFor(prd_id[i]);
                prd_id[i].value = validateData(prd_id[i].value);
            }
        }
        for(let i=0; i<color_id.length; i++){
            if (color_id[i].value === '') {
                setErrorFor(color_id[i], 'Chưa có thông tin màu sản phẩm');
            isSend = false;
            } else {
                setSuccessFor(color_id[i]);
                color_id[i].value = validateData(color_id[i].value);
            }
        }
        for(let i=0; i<size_id.length; i++){
            if (size_id[i].value === '') {
                setErrorFor(size_id[i], 'Chưa có thông tin size');
            isSend = false;
            } else {
                setSuccessFor(size_id[i]);
                size_id[i].value = validateData(size_id[i].value);
            }
        }
        

    
        if (!isSend) {
            e.preventDefault();
        }

    })

    let setErrorFor = (input, message) => {
        const formControl = input.parentElement;
        const small = formControl.querySelector('small');
        formControl.classList.add('error');
        small.innerText = message;
    }

    let setSuccessFor = (input) => {
        const formControl = input.parentElement;
        formControl.classList.remove('error');
    }

    function validateData(input) {
        return input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

    }

    $(function(){
            $json= <?php print_r(json_encode($json1)) ?>;
            $renderInput = $('#renderInput');
            $btnAdd = $('#btn-add');
            $btnDel = $('.btn-del');

            function callback(){
                $btnAdd = $('#btn-add');
                 $btnDel = $('.btn-del');
                 $prd_id = $('.prd_id');
                $color_id =$('.color_id');
                $btnDel.on('click', function(){
                    $del = $(this).parent().parent();
                    console.log($del);
                    $del.remove();   
                })
                $.each($prd_id, function(ind, val){
                    console.log(val);
                    if(val.options.length==1){
                        $.each($json, function(index, value){
                        val.options[val.options.length] = new Option(value["prd_name"],index);
                        })
                    }
                })
                    
                
            
            $prd_id.on('change', function(){
                $color_id = $(this).parent().next().children('select');
                $size_id = $(this).parent().next().next().children('select');
                $color_id.html(`<option value="" selected="selected">Chọn màu</option>`);
                $size_id.html(`<option value="" selected="selected">Chọn size</option>`);

                $.each($json[$(this).val()]['color'], function(index, value){
                    $color_id.append(new Option(value["color_name"], index));
                })

            })
            
            $color_id.on('change', function(){
                $prd_id = $(this).parent().prev().children('select');

                $size_id = $(this).parent().next().children('select');
                $size_id.html(`<option value="" selected="selected">Chọn size</option>`);

                $.each($json[$prd_id.val()]['color'][$(this).val()]['size'], function(index, value){
                    $size_id.append(new Option(value["size_name"], index));
                })
            })
            }
            $prd_id = $('.prd_id');
            $color_id =$('.color_id');
            callback();

            $btnAdd.on('click', function(){
                $renderInput.append(`<div class="box-input" style="display:flex">
                                    
                                    <div class="form-group col-3">
                                        <label for="">Tên sản phẩm</label>
                                        <select name="prd_id" class="form-control prd_id" id="prd_id">
                                            <option value="" selected="selected">Thể loại</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Màu sắc</label>
                                        <select name="color_id" class="form-control color_id" id="color_id">
                                            <option value="" selected="selected">Chọn màu</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="">Size</label>
                                        <select name="size_id[]" class="form-control size_id" id="size_id">
                                            <option value="" selected="selected">Chọn size</option>
                                            
                                    
                                        </select>
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="">Số lượng</label>
                                        <input type="text" name="quantity[]" id="quantity" class="form-control quantity" value="" >
                                        <small>error</small>
                                    </div>
                                    <div class="form-group col-1">
                                        <label for="">---</label>
                                        <button type="button" class="btn btn-danger btn-del">Xóa</button>
                                    </div>
                                    

                                    
                            </div>`)
                            callback();
            

            })


            
            

        
    })

    
</script>
