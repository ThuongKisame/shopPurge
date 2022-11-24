<?php
    require_once '../model/db.php';
    require_once './onload.php';
    $sql ="SELECT * FROM category";
    $result  = mysqli_query($conn, $sql);
    $array = array();
    while($item = mysqli_fetch_assoc($result)){
        array_push($array, $item['category_name']);
    }

    
    if(isset($_POST['sbm'])){
            
            $category_name = $_POST['category_name'];       
            $sql = "INSERT INTO category(category_name) VALUES('$category_name')";
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
                            <form action="index.php?menu=12&layout=add" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên thể loại</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control" value="" >
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
