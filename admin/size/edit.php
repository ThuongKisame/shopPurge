<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id'])){
        $size_id = $_GET['id'];
        $sql_get = "SELECT * FROM size WHERE size_id = $size_id";
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=10"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
        $sql ="SELECT * FROM size";
        $result  = mysqli_query($conn, $sql);
        $array = array();
        while($item = mysqli_fetch_assoc($result)){
            if($product['size_name']!=$item['size_name']){
                array_push($array, $item['size_name']);
            }
        }
    
    }
    else{
        echo '<script> location.href = "index.php?menu=10"  </script>';
    }

    
    
    if(isset($_POST['sbm'])){
            $size_id = $_GET['id'];
            $size_name = $_POST['size_name'];       
            $sql = "UPDATE size SET size_name = '$size_name' WHERE size_id = $size_id";
            $result = mysqli_query($conn, $sql);

                  
            // addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            echo '<script> location.href = "index.php?menu=10"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm size</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=10&layout=edit&id=<?php echo $product['size_id'] ?>" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên size</label>
                                    <input type="text" name="size_name" id="size_name" class="form-control" value="<?php echo $product['size_name'] ?>" >
                                    <small>error</small>
                                
                                </div>
                                
                                
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddPower = document.querySelector('#form-add-power');
    const size_name = document.querySelector('#size_name');
    let array = <?php print_r(json_encode($array)) ?>;





    formAddPower.addEventListener('submit', e => {
        let isSend = true;

        if (size_name.value === '') {
            setErrorFor(size_name, 'Chưa có thông tin tên thể loại');
            isSend = false;
        } else {
            setSuccessFor(size_name);
            size_name.value = validateData(size_name.value);
        }


        let error=true;
        array.forEach(function(item, index){
            if(item.toUpperCase()==size_name.value.toUpperCase()){
                error = false;
            }
        })
        if(!error){
            setErrorFor(size_name, 'Đã có thể loại này trong danh sách');
            isSend = false;
        }else {
            setSuccessFor(size_name);
            size_name.value = validateData(size_name.value);
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
