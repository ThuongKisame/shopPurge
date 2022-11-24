<?php
    session_start();
    require 'model/db.php';
    require_once 'emailController.php';

    $error = "";
    $email = "";
    $phoneNumber = "";
    $nameUser ="";


    //if user clicks on the sign up button
    if(isset($_POST['signup-btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nameUser = $_POST['nameUser'];
        $phoneNumber = $_POST['phoneNumber'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");

        //validation
        // if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //     $error="Email address is invalid";
        // }
       


        $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userCount = $result->num_rows;
        $stmt->close();


        if($userCount>0){
            $error = "Email already exists";
        }



        if(empty($error)){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(50));
            // $verified = false;

            $sql = "INSERT INTO users(nameUser, email, phoneNumber, token, password, date_create) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssss',$nameUser, $email, $phoneNumber, $token, $password, $getDay);
            if($stmt->execute()){
                //log in user

                $user_id = $conn->insert_id;
                $_SESSION['id']= $user_id;
                $_SESSION['email']= $email;
                // $_SESSION['verified']= $verified;
                $_SESSION['nameUser']= $nameUser;
                $_SESSION['phoneNumber']= $phoneNumber;
                $_SESSION['token'] = $token;
                // $_SESSION['nameUser']= $nameUser;
                // $_SESSION['user_id'] = 22;
                $sql = "SELECT * FROM users where email = '$email'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['user_id']= $row['user_id'];




                sendVerificationEmail($email, $token, "account.php");
                //set flash message
                // $_SESSION['message']="You are now log in";
                // $_SESSION['alert-class']="alert-success";
                header('location: account.php');
                exit();
            }
            else{
                $errors['db_error']="Database error: failed to register";

            }

        }
    }

    //if user clicks on the login button
    if(isset($_POST['login-btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        //validation
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
                    $user_id = $conn->insert_id;
                    $_SESSION['id']= $user_id;
                    $_SESSION['user_id']= $user['user_id'];
                    $_SESSION['email']= $user['email'];
                    // $_SESSION['verified']= $user['verified'];
                    $_SESSION['nameUser']= $user['nameUser'];
                    $_SESSION['phoneNumber']= $user['phoneNumber'];

                    header('location: account.php');
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


        
        
        
    //log out user
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        // unset($_SESSION['verified']);
        unset($_SESSION['phoneNumber']);
        unset($_SESSION['nameUser']);
        header('location: login.php');
        exit();
    }


    // verify the user by token
    function verifyUser($token){
        global $conn;
        $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
            $user =mysqli_fetch_assoc($result);
            $update_query = "UPDATE users SET verified=1 WHERE token='$token'";

            if(mysqli_query($conn, $update_query)){
                //log in user
                  //login success
                  $_SESSION['id']= $user['id'];
                  $_SESSION['username']= $user['username'];
                  $_SESSION['email']= $user['email'];
                  $_SESSION['verified']= 1;
                  $_SESSION['nameUser']= $user['nameUser'];
                $_SESSION['phoneNumber']= $user['phoneNumber'];
                  //set flash message
                //   $_SESSION['message']="You email address was successfully verified!";
                //   $_SESSION['alert-class']="alert-success";
                  header('location: account.php');
                  exit();
            }
            else{
                echo 'User not found';
            }
        }
    }


    //if restore password button click
    if(isset($_POST['restorePassword-btn'])){   
        $email = $_POST['email'];

        $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $userCount = $result->num_rows;
        $stmt->close();

        if($userCount==0){
            $error = "Email not exists";
        }
        else{
            sendVerificationEmail($email, $user['token'], "resetPassword.php");
        }

    }

    function resetPassword($token){
        global $conn;
        $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
            $user =mysqli_fetch_assoc($result);
            $_SESSION['id']= $user['id'];
                  $_SESSION['username']= $user['username'];
                  $_SESSION['email']= $user['email'];
                  $_SESSION['verified']= 1;
                  $_SESSION['nameUser']= $user['nameUser'];
                $_SESSION['phoneNumber']= $user['phoneNumber'];
                $_SESSION['token'] = $user['token'];
            // $update_query = "UPDATE users SET verified=1 WHERE token='$token'";

        }
    }



    //when click button buy product
    if(isset($_POST['btn-check-out'])){
        echo "<script>alert('Cám ơn quý khách đã mua hàng!!')</script>";

        $name = $_POST['name'];
        $phoneNum = $_POST['phoneNum'];
        $addressDetail = $_POST['addressDetail'];
        $province = $_POST['province-hidden'];
        $district = $_POST['district-hidden'];
        $village = $_POST['village-hidden'];
        $user_id = $_SESSION['user_id'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay= date("Y-m-d H:i:s");
        $state = 1;
        $sqlInsertIntoOrder = "INSERT INTO orders(user_id, date,name_customer,phoneNumber,address_detail,province,district,village, state, staff_id) VALUES($user_id, '$getDay', '$name', '$phoneNum', '$addressDetail', '$province', '$district', '$village',$state, 4)";
        echo $sqlInsertIntoOrder;
        $resultInsertIntoOrder = mysqli_query($conn, $sqlInsertIntoOrder);
        
        $getOrderID = "SELECT * FROM orders WHERE user_id = $user_id and date = '$getDay'";
        $resultOrderID = mysqli_query($conn, $getOrderID);
        $row = mysqli_fetch_assoc($resultOrderID);
        $order_id = $row['order_id'];
        





        $sqlGetCart = "SELECT * FROM cart, products, detail_product, detail_product_size, color, size, sale, category
         where cart.user_id = $user_id 
         AND products.category_id = category.category_id
         AND cart.detail_prd_size_id = detail_product_size.detail_prd_size_id
         AND detail_product_size.detail_prd_id = detail_product.detail_prd_id
         AND products.prd_id = detail_product.prd_id
         AND products.sale_id = sale.sale_id
        AND detail_product.color_id= color.color_id
        AND detail_product_size.size_id = size.size_id
         ";
        $resultGetCart = mysqli_query($conn, $sqlGetCart);
        

        while($cart = mysqli_fetch_assoc($resultGetCart)){
            $detail_prd_size_id = $cart['detail_prd_size_id'];
            $prd_name = $cart['prd_name'];
            $price = $cart['price'];
            $quantity = $cart['quantity_cart'];
            $percent = $cart['percent'];
            $color = $cart['color_name'];
            $size = $cart['size_name'];
            $image_front = $cart['image_front'];
            $category = $cart['category_name'];


            $sql = "INSERT INTO detail_order(detail_prd_size_id, category, order_id, prd_name,  price, quantity, percent, color, size, image_front) 
            VALUES( $detail_prd_size_id, '$category',$order_id, '$prd_name', $price, $quantity, $percent, '$color', '$size', '$image_front')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $sqlDel = "DELETE FROM cart WHERE user_id = $user_id";
                $resultDel = mysqli_query($conn, $sqlDel);  
                
                             
            }
        }

        header ('location:index.php');
    }

    

    
?>