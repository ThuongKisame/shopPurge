<?php
    require_once '../model/db.php';
    require_once './onload.php';

    if(isset($_POST['sbm'])){


        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $phoneNumber = $_POST['phoneNumber'];
        $date_create = $getDay;
        $power_id = $_POST['power'];


        $emailQuery = "SELECT * FROM staff WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;
        $stmt->close();
        $error="";
        if(!empty($count)){
            $error = "Email đã tồn tại";
        }
        else{
            $sql = "INSERT INTO staff(email, password, staff_name, phoneNumber, date_create, power_id)
            VALUES('$email', '$password', '$name', '$phoneNumber', '$date_create', $power_id)";
            $result = mysqli_query($conn, $sql);
            addLog($conn, $staff_id, " đã tạo một tài khoản mới ".$email);

            echo '<script> location.href = "index.php?menu=6"  </script>';
        }




        
    
        




       

    }

?>




    <div class="card">
        <div class="card-header">
            <h2>Thêm tài  khoản nhân viên</h2>
        </div>
        <div class="card-body">
            <form action="./index.php?menu=6&layout=add" method="POST" enctype="multipart/form-data" id="form-add-staff">

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?php if(!empty($email)){echo $email;} ?>">
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php if(!empty($name)){echo $name;} ?>">
                    <small></small>
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="<?php if(!empty($phoneNumber)){echo $phoneNumber;} ?>">
                    <small></small>
                </div>

                <div class="form-group">
                                    <label for="">Nhóm quyền</label>
                                    <select name="power" class="form-control" id="power">
                                    <option value="" selected="selected">Quyền</option>
                                    
                                    <?php
                                             $sql_title = "SELECT * FROM power"; 
                                            $result_title = mysqli_query($conn, $sql_title);
                                       
                                            while($item = mysqli_fetch_assoc($result_title)){
                                            ?>
                                                                <option value="<?php echo $item['power_id'] ?>"><?php echo $item['power_name'] ?></option>

                            <?php
                                        }
                                    ?>
                                </select>
                                    <small>error</small>
                                </div>
                

                
                <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
            </form>
        </div>

    </div>

    <script>
        //validation sign up
        const formAddStaff = document.querySelector('#form-add-staff');
        const email = document.querySelector('#email');
        const name = document.querySelector('#name');
        const password = document.querySelector('#password');
        const phoneNumber = document.querySelector('#phoneNumber');
        const power = document.querySelector('#power');

        



                
        

       



        formAddStaff.addEventListener('submit', e => {

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

            if (email.value === '') {
                setErrorFor(email, 'Chưa có thông tin email!!!');
                isSend = false;
            } else {
                if (!validateEmail(email.value)) {
                setErrorFor(email, 'Email không phù hợp!!!');
                isSend = false;

                } else {
                    setSuccessFor(email);
                }
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

        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        <?php
            if(!empty($error)){
                ?>
                    setErrorFor(email, 'Email đã tồn tại!!!');
                <?php
            }
        ?>
    </script>