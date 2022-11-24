<?php
    require_once '../model/db.php';
    require_once './onload.php';


    
    if(isset($_POST['sbm'])){
            $power_name = $_POST['power_name'];       
            $title_id = $_POST['title'];

            $sql_get_last_id = "SELECT * FROM power ORDER BY power_id DESC LIMIT 1";
            $result_get_last_id = mysqli_query($conn,$sql_get_last_id );
            $item = mysqli_fetch_assoc($result_get_last_id);
            $power_id = $item['power_id'];
            $power_id++;
            $sql_insert_power = "INSERT INTO power(power_name, power_id) VALUES('$power_name', $power_id)";
            $result_insert_power = mysqli_query($conn, $sql_insert_power);

            foreach($title_id as $i){
                $sql_insert = "INSERT INTO power_detail(power_id, title_id) VALUES($power_id, $i)";
                $result_insert = mysqli_query($conn, $sql_insert);
            }
            addLog($conn, $staff_id, " đã tạo một quyền mới ".$power_name);


            // $sql_update = "UPDATE store SET quantity = $quantity WHERE prd_id = $prd_id AND size ='$size'";
            // $result_update = mysqli_query($conn,$sql_update);
            echo '<script> location.href = "index.php?menu=8"  </script>';


        
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Thêm sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=8&layout=add" method="POST" enctype="multipart/form-data" id="form-add-power">
                                <div class="form-group">
                                    <label for="">Tên nhóm quyền</label>
                                    <input type="text" name="power_name" id="power_name" class="form-control" value="" >
                                    <small>error</small>
                                
                                </div>
                                <label for="">Danh mục</label>

                                <ul class="list-group list-group-flush form-group" id="prd" >

                        <?php
                                             $sql_title = "SELECT * FROM  title"; 
                                            $result_title = mysqli_query($conn, $sql_title);
                                       
                                            while($item = mysqli_fetch_assoc($result_title)){
                                            ?>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="check<?php echo $item['title_id'];?>" name='title[]' value="<?php echo $item['title_id'];?>">
                                    <label class="custom-control-label" for="check<?php echo $item['title_id'];?>"><?php echo $item['title_name'];?></label>
                                </div>
                            </li>
                            <?php
                                        }
                                    ?>

                    <small>error</small>

                    </ul>
                                
                                
                                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                            </form>
                        </div>

                    </div>

                    <script>
    //validation sign up
    const formAddPower = document.querySelector('#form-add-power');
    const power_name = document.querySelector('#power_name');
    const title = document.querySelectorAll('.title');
    const li = document.querySelector('.validate-li');
    





    formAddPower.addEventListener('submit', e => {
        let isSend = true;

        if (power_name.value === '') {
            setErrorFor(power_name, 'Chưa có thông tin tên sản phẩm');
            isSend = false;
        } else {
            setSuccessFor(power_name);
            power_name.value = validateData(power_name.value);
        }
        let isCheck = false;
        for(let i=0; i<title.length;i++){
            if(title[i].checked){
                isCheck=true;
            }
        }
        if(!isCheck){
            setErrorFor(li, 'Chưa có thông tin danh mục');
            isSend = false;
        }else {
            setSuccessFor(li);
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
