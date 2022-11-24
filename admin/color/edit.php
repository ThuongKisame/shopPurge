<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id'])){
        $color_id = $_GET['id'];
        $sql_get = "SELECT * FROM color WHERE color_id = $color_id";
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=11"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
        $sql ="SELECT * FROM color";
        $result  = mysqli_query($conn, $sql);
        $array = array();
        while($item = mysqli_fetch_assoc($result)){
            if($product['color_name']!=$item['color_name']){
                array_push($array, $item['color_name']);
            }
        }
    
    }
    else{
        echo '<script> location.href = "index.php?menu=11"  </script>';
    }

    
    
    if(isset($_POST['sbm'])){
            $color_id = $_GET['id'];
            $color_name = $_POST['color_name'];       
            $sql = "UPDATE color SET color_name = '$color_name' WHERE color_id = $color_id";
            $result = mysqli_query($conn, $sql);

                  
            // addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            echo '<script> location.href = "index.php?menu=11"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=11&layout=edit&id=<?php echo $product['color_id'] ?>" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên thể loại</label>
                                    <input type="text" name="color_name" id="color_name" class="form-control" value="<?php echo $product['color_name'] ?>" >
                                    <small>error</small>
                                
                                </div>
                                
                                
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddPower = document.querySelector('#form-add-power');
    const color_name = document.querySelector('#color_name');
    let array = <?php print_r(json_encode($array)) ?>;





    formAddPower.addEventListener('submit', e => {
        let isSend = true;

        if (color_name.value === '') {
            setErrorFor(color_name, 'Chưa có thông tin tên thể loại');
            isSend = false;
        } else {
            setSuccessFor(color_name);
            color_name.value = validateData(color_name.value);
        }


        let error=true;
        array.forEach(function(item, index){
            if(item.toUpperCase()==color_name.value.toUpperCase()){
                error = false;
            }
        })
        if(!error){
            setErrorFor(color_name, 'Đã có thể loại này trong danh sách');
            isSend = false;
        }else {
            setSuccessFor(color_name);
            color_name.value = validateData(color_name.value);
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
