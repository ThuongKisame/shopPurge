<?php 
require_once 'controller/authController.php';
require_once 'controller/onload.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purge</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne+Mono&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="view/css/style.css">
    <link rel="stylesheet" href="view/css/login.css">
</head>

<body>
<?php require_once 'view/header.php' ?>

    <!-- SECTION MAIN -->
    <section id="main" class="container">
        <form action="login.php" id="form-log-in" class="col-6 col-tb-8 col-xs-12" method="POST">
            <h1>Đăng nhập</h1>
            <div class="form-control <?php if(!empty($error)):?> error<?php endif ?>">
                <input type="text" placeholder="Email" id="email" name="email" value="<?php echo $email;?>">
                <i id="icon-error" class="bx bxs-error-circle"></i>
                <i id="icon-success" class="bx bxs-check-circle"></i>
                <br>
                <small><?php echo $error;?></small>
            </div>
            <div class="form-control <?php if(!empty($error)):?> error<?php endif ?>">
                <input type="password" placeholder="Password" id="password" name="password">
                <i id="icon-error" class="bx bxs-error-circle"></i>
                <i id="icon-success" class="bx bxs-check-circle"></i>
                <br>
                <small></small>
            </div>
            <button type="submit" name="login-btn">Đăng nhập</button>
            <a href="restorePassword.php">Quên mật khẩu</a>
            <span>Nếu bạn chưa có tài khoản thì đăng ký tại đây <a href="signUp.php">Đăng ký</a></span>
        </form>
    </section>
    <!-- END SECTION MAIN -->
  
    <?php require_once 'view/footer.php'; ?>
    <script src="view/js/index.js"></script>
    <script src="view/js/login.js"></script>
</body>

</html>