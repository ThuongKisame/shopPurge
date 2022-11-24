<?php
    require_once '../model/db.php';
    require_once './onload.php';


    if(isset($_GET['id'])){
        $power_id = $_GET['id'];
        $sql_get = "SELECT * FROM power WHERE power_id = $power_id ";
        $result_get = mysqli_query($conn, $sql_get);

        $sql_power = "SELECT * FROM power_detail, title WHERE power_id = $power_id AND power_detail.title_id = title.title_id";
        $result_power = mysqli_query($conn, $sql_power);
        $array_title = array();
        while($a = mysqli_fetch_assoc($result_power)){
            array_push($array_title, $a['title_id']);
        }
        if(empty(mysqli_num_rows($result_get))){
            header ('location : ./index.php?menu=8');
        }
        $product = mysqli_fetch_assoc($result_get);
    }
    else{
        header ('location : ./index.php?menu=8');
    }
    if(isset($_POST['sbm'])){
        if(isset($_GET['id'])){
            $power_id = $_GET['id'];
            $title_id = $_POST['title'];
            $sql_del = "DELETE FROM power_detail WHERE power_id = $power_id";
            $result_del = mysqli_query($conn, $sql_del);

            foreach($title_id as $i){
                $sql_insert = "INSERT INTO power_detail(power_id, title_id) VALUES($power_id, $i)";
                $result_insert = mysqli_query($conn, $sql_insert);
            }

            // $sql_update = "UPDATE store SET quantity = $quantity WHERE prd_id = $prd_id AND size ='$size'";
            // $result_update = mysqli_query($conn,$sql_update);
            addLog($conn, $staff_id, " đã chỉnh sửa quyền ID:".$power_id);

            echo '<script> location.href = "index.php?menu=8"  </script>';


        }
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Sửa sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=8&layout=edit&id=<?php echo $product['power_id']; ?>" method="POST" enctype="multipart/form-data" id="form-edit-store">
                                <div class="form-group">
                                    <label for="">Tên nhóm quyền</label>
                                    <input type="text" name="power_name" id="power_name" class="form-control" value="<?php echo $product['power_name'] ?>">
                                </div>
                                <ul class="list-group list-group-flush" id="prd">
                                <label for="">Danh mục</label>

                        <?php
                                             $sql_title = "SELECT * FROM  title"; 
                                            $result_title = mysqli_query($conn, $sql_title);
                                       
                                            while($item = mysqli_fetch_assoc($result_title)){
                                            ?>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php if(in_array($item['title_id'], $array_title)){echo 'checked';} ?> id="check<?php echo $item['title_id'];?>" name='title[]' value="<?php echo $item['title_id'];?>">
                                    <label class="custom-control-label" for="check<?php echo $item['title_id'];?>"><?php echo $item['title_name'];?></label>
                                </div>
                            </li>
                            <?php
                                        }
                                    ?>


                    </ul>
                                        <!-- <input type="hidden" name="test" value=<?php $array_title ?>> -->
                                
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thay đổi</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formEditStore = document.querySelector('#form-edit-store');
    const quantity = document.querySelector('#quantity');
    





    formEditStore.addEventListener('submit', e => {
        let isSend = true;

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
