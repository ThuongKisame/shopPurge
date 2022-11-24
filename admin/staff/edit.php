<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_GET['id'])){
        $staff_id = $_GET['id'];
        $sql_get = "SELECT * FROM staff, power WHERE staff_id = $staff_id AND staff.power_id = power.power_id";
        $result_get = mysqli_query($conn, $sql_get);
        if(empty(mysqli_num_rows($result_get))){
            echo '<script> location.href = "index.php?menu=6"  </script>';
        }
        $product = mysqli_fetch_assoc($result_get);
    }
    else{
        echo '<script> location.href = "index.php?menu=6"  </script>';
    }
    if(isset($_POST['sbm'])){
        if(isset($_GET['id'])){
            $staff_id = $_GET['id'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $phoneNumber = $_POST['phoneNumber'];
        $power_id = $_POST['power'];
            $sql_update = "UPDATE staff SET password = '$password', staff_name = '$name', phoneNumber = '$phoneNumber', power_id = $power_id WHERE staff_id = $staff_id";
            $result_update = mysqli_query($conn,$sql_update);
            addLog($conn, $staff_id, " đã chỉnh sửa tài khoản ID:".$staff_id);

            echo '<script> location.href = "index.php?menu=6"  </script>';
        }
        
    }


    

?>




<div class="card">
                        <div class="card-header">
                            <h2>Sửa sản phẩm</h2>
                        </div>
                        <div class="card-body">
                            <form action="index.php?menu=6&layout=edit&id=<?php echo $product['staff_id']; ?>" method="POST" enctype="multipart/form-data" id="form-edit-staff">
                            <div class="form-group">
                    <label for="">Email</label>
                    <div class="form-control" ><?php echo $product['email']; ?></div>
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="<?php echo $product['password']; ?>">
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $product['staff_name']; ?>">
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="<?php echo $product['phoneNumber']; ?>">
                    <small></small>
                </div>
                <div class="form-group">
                                    <label for="">Nhóm quyền</label>
                                    <select name="power" class="form-control" id="power">
                                    
                                    <?php
                                             $sql_title = "SELECT * FROM power"; 
                                            $result_title = mysqli_query($conn, $sql_title);
                                       
                                            while($item = mysqli_fetch_assoc($result_title)){
                                            ?>
                                                                <option value="<?php echo $item['power_id'] ?>" <?php if($item['power_id']==$product['power_id']){echo 'selected = selected';} ?>><?php echo $item['power_name'] ?></option>

                            <?php
                                        }
                                    ?>
                                </select>
                                    <small>error</small>
                                </div>

                                
                                <button type="submit" name="sbm" class="btn btn-success">Thay đổi</button>
                            </form>
                        </div>

                    </div>

                    <script>
        //validation sign up
        const formEditStaff = document.querySelector('#form-edit-staff');
        // const email = document.querySelector('#email');
        const name = document.querySelector('#name');
        const password = document.querySelector('#password');
        const phoneNumber = document.querySelector('#phoneNumber');
        const power = document.querySelector('#power');

        







        formEditStaff.addEventListener('submit', e => {

            let isSend = true;

            
            if (power.value === '') {
            setErrorFor(power, 'Chưa có thông tin tên chương trình');
            isSend = false;
        } else {
            setSuccessFor(power);
        }

            if (name.value === '') {
            setErrorFor(name, 'Chưa có thông tin tên chương trình');
            isSend = false;
        } else {
            setSuccessFor(name);
            name.value = validateData(name.value);
        }
        if (password.value === '') {
            setErrorFor(password, 'Chưa có thông tin tên chương trình');
            isSend = false;
        } else {
            setSuccessFor(password);
            password.value = validateData(password.value);
        }

            if (phoneNumber.value === '') {
        setErrorFor(phoneNumber, 'Chưa có thông tin số điện thoại!!!');
        isSend = false;
    } else {
        if (!phoneNumber.value.match(/^0(\d{9}|\d{10})$/)) {
            setErrorFor(phoneNumber, 'Số điện thoại không phù hợp!!!');
            isSend = false;
        } else {
            setSuccessFor(phoneNumber);
        }
    }

    // if (email.value === '') {
    //     setErrorFor(email, 'Chưa có thông tin email!!!');
    //     isSend = false;
    // } else {
    //     if (!validateEmail(email.value)) {
    //         setErrorFor(email, 'Email không phù hợp!!!');
    //         isSend = false;

    //     } else {
    //         setSuccessFor(email);
    //     }
    // }






            


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

        function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
        }
    </script>