<?php
    require_once '../model/db.php';
    require_once './onload.php';
    $sql ="SELECT * FROM color";
    $result  = mysqli_query($conn, $sql);
    $array = array();
    while($item = mysqli_fetch_assoc($result)){
        array_push($array, $item['color_name']);
    }

    
    if(isset($_POST['sbm'])){
            
            $color_name = $_POST['color_name'];       
            $sql = "INSERT INTO color(color_name) VALUES('$color_name')";
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
                            <form action="index.php?menu=11&layout=add" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên thể loại</label>
                                    <input type="text" name="color_name" id="color_name" class="form-control" value="" >
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
