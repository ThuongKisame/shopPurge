<?php
    require_once '../model/db.php';
    require_once './onload.php';
    $sql ="SELECT * FROM size";
    $result  = mysqli_query($conn, $sql);
    $array = array();
    while($item = mysqli_fetch_assoc($result)){
        array_push($array, $item['size_name']);
    }

    
    if(isset($_POST['sbm'])){
            
            $size_name = $_POST['size_name'];       
            $sql = "INSERT INTO size(size_name) VALUES('$size_name')";
            $result = mysqli_query($conn, $sql);
                  
            // addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            echo '<script> location.href = "index.php?menu=10"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=10&layout=add" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên size</label>
                                    <input type="text" name="size_name" id="size_name" class="form-control" value="" >
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
