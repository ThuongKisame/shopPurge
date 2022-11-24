<?php
        

    require_once '../model/db.php';
    require_once './onload.php';
    $sql ="SELECT * FROM products";
    $result  = mysqli_query($conn, $sql);
    $array = array();
    while($item = mysqli_fetch_assoc($result)){
        array_push($array, $item['prd_name']);
    }
    if(isset($_POST['sbm'])){
        
        $prd_name = $_POST['prd_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $newArrival = $_POST['newArrival'];
        $category_id = $_POST['category'];
        

        $sql ="INSERT INTO products(prd_name, price, description, newArrival, category_id, sale_id)
        VALUES('$prd_name', $price,'$description', $newArrival, $category_id, 0)";
        $result = mysqli_query($conn, $sql);

       


        
        // addLog($conn, $staff_id, " đã tạo sản phẩm mới ".$prd_name);


        
        



      
        echo '<script> location.href = "index.php?menu=1"  </script>';
    }

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?layout=add&menu=1" method="POST" enctype="multipart/form-data" id="form-add-product">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="prd_name" id="prd_name" class="form-control">
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Giá sản phẩm</label>
                                    <input type="text" name="price" id="price" class="form-control">
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Mô tả sản phẩm</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Hiển thị sản phẩm mới</label>
                                    <select name="newArrival" class="form-control" id="newArrival">
                                    <option value="1" selected="selected">Có</option>
                                    <option value="0" >Không</option>
                                </select>
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Thể loại</label>
                                    <select name="category" class="form-control" id="category">
                                    <option value="" selected="selected">Thể loại</option>
                                    <?php 
                                        $sql = "SELECT * FROM category";
                                        $result = mysqli_query($conn, $sql);
                                        while($item = mysqli_fetch_assoc($result)){
                                            ?>
                                            <option value="<?php echo $item['category_id'] ?>" ><?php echo $item['category_name'] ?></option>

                                            <?php
                                        }
                                    ?>
                                </select>
                                    <small>error</small>
                                </div>
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddProduct = document.querySelector('#form-add-product');
    const prd_name = document.querySelector('#prd_name');
    const price = document.querySelector('#price');
    const description = document.querySelector('#description');
    const newArrival = document.querySelector('#newArrival');
    const category = document.querySelector('#category');
    // const title = document.querySelectorAll('.title');
    // const li = document.querySelector('.validate-li');
    let array = <?php print_r(json_encode($array)) ?>;

    




    formAddProduct.addEventListener('submit', e => {
        let isSend = true;
       
        let error=true;
        array.forEach(function(item, index){
            if(item.toUpperCase()==prd_name.value.toUpperCase()){
                error = false;
            }
        })

             
        if (prd_name.value === '') {
            setErrorFor(prd_name, 'Chưa có thông tin tên sản phẩm');
            isSend = false;
        } else {
            if(!error){
            setErrorFor(prd_name, 'Đã có tên sản phẩm này trong danh sách');
            isSend = false;
            }else {
            setSuccessFor(prd_name);
            prd_name.value = validateData(prd_name.value);
            }
            
        }

        
        

        // if (image_front.value === '') {
        //     setErrorFor(image_front, 'Chưa có thông tin hình mặt trước sản phẩm');
        //     isSend = false;
        // } else {
        //     setSuccessFor(image_front);
        // }

        // if (image_back.value === '') {
        //     setErrorFor(image_back, 'Chưa có thông tin hình mặt sau sản phẩm');
        //     isSend = false;
        // } else {
        //     setSuccessFor(image_back);
        // }

        if (price.value === '') {
            setErrorFor(price, 'Chưa có thông tin giá sản phẩm');
            isSend = false;
        } else {
            if(isNaN(price.value) || price.value <= 0){
                setErrorFor(price, 'Giá tiền không hợp lệ');
                isSend = false;
            }
            else
                setSuccessFor(price);
        }

       

        if (description.value === '') {
            setErrorFor(description, 'Chưa có thông tin mô tả sản phẩm');
            isSend = false;
        } else {
            description.value = validateData(description.value);
            setSuccessFor(description);
        }

        if (newArrival.value === '') {
            setErrorFor(newArrival, 'Chưa có thông tin sản phẩm mới ');
            isSend = false;
        } else {
            setSuccessFor(newArrival);
        }

        if (category.value === '') {
            setErrorFor(category, 'Chưa có thông tin thể loại sản phẩm');
            isSend = false;
        } else {
            setSuccessFor(category);
        }

        if (!isSend) {
            e.preventDefault();
        }

    })

    let setErrorFor = (input, message) => {
        const formControl = input.parentElement;
        const small = formControl.querySelector('small');
        formControl.classList = 'form-group error';
        small.innerText = message;
    }

    let setSuccessFor = (input) => {
        const formControl = input.parentElement;
        formControl.classList = 'form-group';
    }

    function validateData(input) {
        return input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

    }

    
</script>
