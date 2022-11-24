<?php
    require_once '../model/db.php';
    if(isset($_POST['sbm'])){
        $prd_id = $_POST['product'];
        $size = $_POST['size'];
        $quantity = $_POST['quantity'];
        
        $sql_get = "SELECT * FROM store WHERE prd_id = $prd_id and size = '$size'";
        $result_get = mysqli_query($conn, $sql_get);
        $row = mysqli_num_rows($result_get);
        if(empty($row)){
            $sql_insert = "INSERT INTO store(prd_id, size, quantity) 
            VALUES($prd_id, '$size', $quantity)" ;
            $result_insert = mysqli_query($conn, $sql_insert);
        }
        else{
            $sql_update = "UPDATE store set quantity = $quantity WHERE prd_id = $prd_id and size = '$size'";
            $result_update = mysqli_query($conn, $sql_update);
        }

        echo '<script> location.href = "index.php?menu=3"  </script>';
    }

?>




    <div class="card">
        <div class="card-header">
            <h2>Thêm sản phẩm</h2>
        </div>
        <div class="card-body">
            <form action="./index.php?menu=3&layout=add" method="POST" enctype="multipart/form-data" id="form-add-store">



                <div class="form-group">
                    <label for="">Chọn sản phẩm</label>
                    <ul class="list-group list-group-flush" id="prd">
                        <?php
                                             $sql_products = "SELECT * FROM products";
                                            $result_products = mysqli_query($conn, $sql_products);
                                       
                                            while($item = mysqli_fetch_assoc($result_products)){
                                            ?>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="radio" class="custom-control-input" id="check<?php echo $item['prd_id'];?>" name="product" value="<?php echo $item['prd_id'];?>">
                                    <label class="custom-control-label" for="check<?php echo $item['prd_id'];?>"><?php echo $item['prd_name'];?><br><img style="width: 30%" src="../../view/img/<?php echo $item['image_front'] ?>" alt=""></label>
                                </div>
                            </li>
                            <?php
                                        }
                                    ?>


                    </ul>
                    <small>error</small>

                </div>

                <div class="form-group">
                    <label for="">Size</label>
                    <select name="size" class="form-control" id="size">
                                    <option value="s" selected="selected">s</option>
                                    <option value="m">m</option>
                                    <option value="l">l</option>
                                    <option value="xl">xl</option>
                                    <option value="xxl">xxl</option>
                                    <option value="xxxl">xxxl</option>
                                </select>
                    <small>error</small>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="quantity" id="quantity" class="form-control">
                    <small>error</small>
                </div>
                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
            </form>
        </div>

    </div>

    <script>
        //validation sign up
        const formAddStore = document.querySelector('#form-add-store');
        const product = document.getElementsByName('product');
        const prd = document.querySelector('#prd');
        const size = document.querySelector('#size');
        const quantity = document.querySelector('#quantity');





        formAddStore.addEventListener('submit', e => {
            let isSend = true;

            let hasPrd = false;
            for(let i=0; i<product.length;i++){
                    if(product[i].checked){
                        console.log(product[i].value);
                        hasPrd = true;
                    }
            }
            if(!hasPrd){
                setErrorFor(prd, 'Chưa có thông tin sản phẩm');
                isSend = false;
            }else {
                setSuccessFor(prd);
            }





            if (size.value === '') {
                setErrorFor(size, 'Chưa có thông tin size');
                isSend = false;
            } else {
                setSuccessFor(size);
            }



            if (quantity.value === '') {
                setErrorFor(quantity, 'Chưa có thông tin số lượng');
                isSend = false;
            } else {
                if (isNaN(quantity.value) || quantity.value < 0) {
                    setErrorFor(quantity, 'Số lượng không hợp lệ');
                    isSend = false;
                } else
                    setSuccessFor(quantity);
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