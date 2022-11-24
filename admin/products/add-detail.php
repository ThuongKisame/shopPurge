<?php
        

    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id'])){
        $prd_id = $_GET['id'];
        $sql ="SELECT color_id FROM color  EXCEPT SELECT color_id FROM detail_product WHERE prd_id = $prd_id";
        $result  = mysqli_query($conn, $sql);
        $array = array();
        while($item = mysqli_fetch_assoc($result)){
            $color_id = $item['color_id'];
            $sql1 = "SELECT * FROM color WHERE color_id =$color_id";
            $result1 = mysqli_query($conn, $sql1);
            $item1 = mysqli_fetch_assoc($result1);
            $array[] = ["color_id"=>$item1['color_id'], "color_name"=>$item1['color_name']];
        }
        

    }
    
    if(isset($_POST['sbm'])&&isset($_GET['id'])){
        $prd_id = $_GET['id'];
        $color_id = $_POST['color'];
        $image_front = $_FILES['image_front']['name'];
        $path_front = '../view/img/'.$image_front; 
        $tmp_image_front = $_FILES['image_front']['tmp_name'];
        $image_back = $_FILES['image_back']['name'];
        $path_back = '../view/img/'.$image_back; 
        $tmp_image_back = $_FILES['image_back']['tmp_name'];
        move_uploaded_file($tmp_image_front, $path_front);
        move_uploaded_file($tmp_image_back,  $path_back); 

        $sql = "SELECT * FROM detail_product order by detail_prd_id desc limit 1";
        $result = mysqli_query($conn, $sql);
        $item = mysqli_fetch_assoc($result);
        $detail_prd_id = $item['detail_prd_id'];
        $detail_prd_id++;


        $sql ="INSERT INTO detail_product(detail_prd_id,prd_id, color_id, image_front, image_back)
        VALUES($detail_prd_id,$prd_id, $color_id,'$image_front', '$image_back')";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM size";
        $result = mysqli_query($conn, $sql);
        while($item = mysqli_fetch_assoc($result)){
            $size_id = $item['size_id'];
            $sql = "INSERT INTO detail_product_size(detail_prd_id, size_id, quantity)
            VALUES($detail_prd_id, $size_id, 0)";
            mysqli_query($conn, $sql);
        }

       


        
        // addLog($conn, $staff_id, " đã tạo sản phẩm mới ".$prd_name);


        
        



      
        echo '<script> location.href = "index.php?menu=1"  </script>';
    }

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?layout=add-detail&menu=1&id=<?php echo $prd_id ?>" method="POST" enctype="multipart/form-data" id="form-add-product">
                                
                                <div class="form-group">
                                    <label for="">Màu</label>
                                    <select name="color" class="form-control" id="color">
                                    <option value="" selected="selected">Chọn màu</option>
                                    <?php 
                                        
                                        foreach($array as $i){
                                            ?>
                                                <option value="<?php echo $i['color_id'] ?>" ><?php echo $i['color_name'] ?></option>
                                            
                                            <?php
                                        }
                                    ?>
                                </select>
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh mặt trước</label><br>
                                    <input type="file" name="image_front" id="image_front" >
                                    <small>error</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh mặt sau</label><br>
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
    const color = document.querySelector('#color');
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

       

       

        if (color.value === '') {
            setErrorFor(color, 'Chưa có thông tin màu');
            isSend = false;
        } else {
            color.value = validateData(color.value);
            setSuccessFor(color);
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
