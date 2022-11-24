<?php
        

    require_once '../model/db.php';
    require_once './onload.php';
    if(isset($_GET['id']) && isset($_GET['idDetail'])){
        $prd_id = $_GET['id'];
        $detail_prd_id = $_GET['idDetail'];
        $sql_get = "SELECT * FROM detail_product, products, color WHERE color.color_id = detail_product.color_id AND products.prd_id = detail_product.prd_id AND products.prd_id = $prd_id AND detail_prd_id = $detail_prd_id";
        // echo $sql_get;
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=1"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
        // $prd_id = $product['prd_id'];
        
    }
    else{
        echo '<script> location.href = "index.php?menu=1"  </script>';
    }
    
    
    if(isset($_POST['sbm'])&&isset($_GET['id']) && isset($_GET['idDetail'])){
        $prd_id = $_GET['id'];
        $detail_prd_id = $_GET['idDetail'];

        if(!empty($_FILES['image_front']['name'])){
            $image_front = $_FILES['image_front']['name'];
            $path_front = '../view/img/'.$image_front; 
            $tmp_image_front = $_FILES['image_front']['tmp_name'];
            move_uploaded_file($tmp_image_front, $path_front);
            $sql = "UPDATE detail_product SET image_front = '$image_front' WHERE prd_id = $prd_id AND detail_prd_id = $detail_prd_id";
            $result = mysqli_query($conn, $sql);

        }

        if(!empty($_FILES['image_back']['name'])){
            $image_back = $_FILES['image_back']['name'];
            $path_back = '../view/img/'.$image_back; 
            $tmp_image_back = $_FILES['image_back']['tmp_name'];
            move_uploaded_file($tmp_image_back,  $path_back); 
            $sql = "UPDATE detail_product SET image_back = '$image_back' WHERE prd_id = $prd_id AND detail_prd_id = $detail_prd_id";
            $result = mysqli_query($conn, $sql);
        }
       

        

       


        
        // addLog($conn, $staff_id, " đã tạo sản phẩm mới ".$prd_name);


        
        



      
        echo '<script> location.href = "index.php?menu=1"  </script>';
    }

?>




<div class="card">
                        <div class="card-header">
                            <h2>Sửa chi tiết sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?layout=edit-detail&menu=1&id=<?php echo $prd_id ?>&idDetail=<?php echo $detail_prd_id; ?>" method="POST" enctype="multipart/form-data" id="form-add-product">
                                <div class="form-group">
                                    <label for="">Sản phẩm</label>
                                    <div class="form-control"><?php echo $product['prd_name'] ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Màu</label>
                                    <div class="form-control"><?php echo $product['color_name'] ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh mặt trước</label><br>
                                    <div class="form-control"><?php echo $product['image_front'] ?></div>
                                    <input type="file" name="image_front" id="image_front" >
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh mặt sau</label><br>
                                    <div class="form-control"><?php echo $product['image_back'] ?></div>
                                    <input type="file" name="image_back" id="image_back" >
                                    <small>error</small>
                                </div>
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddProduct = document.querySelector('#form-add-product');
    const image_front = document.querySelector('#image_front');
    const image_back = document.querySelector('#image_back');

    // const title = document.querySelectorAll('.title');
    // const li = document.querySelector('.validate-li');
    let array = <?php print_r(json_encode($array)) ?>;

    




    formAddProduct.addEventListener('submit', e => {
        let isSend = true;
       
       

             
       

        
        

        if (image_front.value === '') {
            setErrorFor(image_front, 'Chưa có thông tin hình mặt trước sản phẩm');
            isSend = false;
        } else {
            setSuccessFor(image_front);
        }

        if (image_back.value === '') {
            setErrorFor(image_back, 'Chưa có thông tin hình mặt sau sản phẩm');
            isSend = false;
        } else {
            setSuccessFor(image_back);
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
