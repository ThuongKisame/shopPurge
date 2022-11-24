<?php

require_once '../model/db.php';
session_start();



if(isset($_POST['login-btn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validation
        $sql = "SELECT * FROM staff WHERE  email=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $row = $result->num_rows;
        if(!empty($row)){
            if($password = $user['password']){
                //login success
                $user_id = $conn->insert_id;
                $_SESSION['id']= $user_id;
                $_SESSION['staff_id']= $user['staff_id'];
                echo $_SESSION['staff_name'];
                // header('location: ./index.php');
                exit();
            }
            else{
                $error="Email hoặc mật khẩu không đúng!";
            }
        }
        else{
            $error="Email hoặc mật khẩu không đúng!";
        }
        
        
    
}
?>