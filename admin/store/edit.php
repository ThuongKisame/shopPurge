<?php
    require_once '../model/db.php';
    require_once './onload.php';


    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql_get = "SELECT * FROM store, products WHERE store.prd_id = $id and products.prd_id = store.prd_id";
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=3"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
    }
    else{
        echo '<script> location.href = "index.php?menu=3"  </script>';
    }
    if(isset($_POST['sbm'])){
        if(isset($_GET['id']) ){
            $prd_id = $_GET['id'];           
            $quantity = $_POST['quantity'];
            foreach($quantity as $i=>$value){
                $sql_update = "UPDATE store SET quantity = $value WHERE prd_id = $prd_id AND size =$i";
                $result_update = mysqli_query($conn,$sql_update);
               
            }

            $sql_get_prd = "SELECT * FROM products WHERE prd_id = $prd_id";
            $result_get_prd = mysqli_query($conn, $sql_get_prd);
            $item = mysqli_fetch_assoc($result_get_prd);
            $prd_name = $item['prd_name'];
            addLog($conn, $staff_id, " đã thay đổi số lượng sản phẩm ".$prd_name);

           
            echo '<script> location.href = "index.php?menu=3"  </script>';

        }
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Sửa sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=3&layout=edit&id=<?php echo $product['prd_id']; ?>&size=<?php echo $product['size']; ?>" method="POST" enctype="multipart/form-data" id="form-edit-store">
                                <div class="form-group">
                                    <label for="">Tên sản phẩm</label>
                                    <div  class="form-control"><?php echo $product['prd_name']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Ảnh sản phẩm </label><br>
                                    <img style="width: 10%" src="../view/img/<?php echo $product['image_front'] ?>" alt="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Size <?php echo $product['size'] ?></label>
                                    <input type="text" name="quantity['<?php echo $product['size'] ?>']" id="quantity-<?php echo $product['size'] ?>" class="form-control quantity" value="<?php echo $product['quantity'] ?>">
                                    <small>error</small>
                                 </div>
                                 <?php
                                    while($product = mysqli_fetch_assoc($result_get)){
                                        ?>
                                        <div class="form-group">
                                            <label for="">Size <?php echo $product['size'] ?></label>
                                            <input type="text" name="quantity['<?php echo $product['size'] ?>']" id="quantity-<?php echo $product['size'] ?>" class="form-control quantity" value="<?php echo $product['quantity'] ?>">
                                            <small>error</small>
                                        </div>

                                        <?php
                                    }
                                 
                                 ?>
                                 
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thay đổi</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formEditStore = document.querySelector('#form-edit-store');
    const quantity = document.querySelectorAll('.quantity');
    





    formEditStore.addEventListener('submit', e => {
        let isSend = true;
        for(let i=0; i<quantity.length; i++){
            if (quantity[i].value === '') {
                setErrorFor(quantity[i], 'Chưa có thông tin số lượng');
                isSend = false;
            } else {
                if (isNaN(quantity[i].value) || quantity[i].value < 0) {
                    setErrorFor(quantity[i], 'Số lượng không hợp lệ');
                    isSend = false;
                } else
                    setSuccessFor(quantity[i]);
            }
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
