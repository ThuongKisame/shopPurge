<?php
require_once 'dbExtra.php';
    if(isset($_GET['email'])&&isset($_GET['password'])){
        $email = $_GET['email'];
        $password = $_GET['password'];

        $sql = "SELECT * FROM users WHERE  email=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $row = $result->num_rows;
            if(!empty($row)){
                if(password_verify($password, $user['password'])){
                    //login success
                    session_start();
                    $user_id = $conn->insert_id;
                    $_SESSION['id']= $user_id;
                    $_SESSION['user_id']= $user['user_id'];
                    $_SESSION['email']= $user['email'];
                    $_SESSION['nameUser']= $user['nameUser'];
                    $_SESSION['phoneNumber']= $user['phoneNumber'];
                    
                    // $user_id = $_SESSION['user_id'];
                    // $nameUser = $_SESSION['nameUser'];
                    echo $user['user_id'];
                    
                }
                
            }
            

            // require_once 'controller/onload.php';

            


    }

?>