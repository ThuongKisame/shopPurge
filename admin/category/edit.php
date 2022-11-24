<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id'])){
        $category_id = $_GET['id'];
        $sql_get = "SELECT * FROM category WHERE category_id = $category_id";
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=12"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
        $sql ="SELECT * FROM category";
        $result  = mysqli_query($conn, $sql);
        $array = array();
        while($item = mysqli_fetch_assoc($result)){
            if($product['category_name']!=$item['category_name']){
                array_push($array, $item['category_name']);
            }
        }
    
    }
    else{
        echo '<script> location.href = "index.php?menu=12"  </script>';
    }

    
    
    if(isset($_POST['sbm'])){
            $category_id = $_GET['id'];
            $category_name = $_POST['category_name'];       
            $sql = "UPDATE category SET category_name = '$category_name' WHERE category_id = $category_id";
            $result = mysqli_query($conn, $sql);

                  
            // addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            echo '<script> location.href = "index.php?menu=12"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=12&layout=edit&id=<?php echo $product['category_id'] ?>" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên thể loại</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $product['category_name'] ?>" >
                                    <small>error</small>
                                
                                </div>
                                
                                
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddPower = document.querySelector('#form-add-power');
    const category_name = document.querySelector('#category_name');
    let array = <?php print_r(json_encode($array)) ?>;





    formAddPower.addEventListener('submit', e => {
        let isSend = true;

        if (category_name.value === '') {
            setErrorFor(category_name, 'Chưa có thông tin tên thể loại');
            isSend = false;
        } else {
            setSuccessFor(category_name);
            category_name.value = validateData(category_name.value);
        }


        let error=true;
        array.forEach(function(item, index){
            if(item.toUpperCase()==category_name.value.toUpperCase()){
                error = false;
            }
        })
        if(!error){
            setErrorFor(category_name, 'Đã có thể loại này trong danh sách');
            isSend = false;
        }else {
            setSuccessFor(category_name);
            category_name.value = validateData(category_name.value);
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
