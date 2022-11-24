<?php
    require_once 'authController.php';
    require_once 'onload.php';



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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

        <link rel="stylesheet" href="./style.css">
    </head>

    <body>
        <div>
            <div id="main-container" class="">
                <?php 
                require_once './view/left-menu.php';
            ?>
                <div id="main-content" class="col-10 bg-light">
                    <div id="header" class="">
                        
                        <div id="box-admin">
                            <div id="user-name"><?php echo $staff_name; ?></div>
                            <a href="index.php?logout=1" id="btn-logout"><i class="bx bx-log-out-circle"></i></a>
                        </div>

                    </div>
                    <?php
                   
                   if(isset($_GET['menu'])){

                       $menu = $_GET['menu'];

                       ?>
                                <script>
                                
                                    let menu = document.querySelectorAll('.list-group-item');
                                    for (let i = 0; i < menu.length; i++) {
                                    if(menu[i].getAttribute('id')=='<?php echo $menu ?>') {
                                        menu[i].classList.add('active');
                                    }
                                    }
                                

                                </script>
                       <?php
                       $sql_get_power = "SELECT * FROM power_detail, staff, title WHERE staff_id = $staff_id AND power_detail.power_id = staff.power_id AND power_detail.title_id = title.title_id";
                       $result_get_power = mysqli_query($conn, $sql_get_power);
                     
                       while($item = mysqli_fetch_assoc($result_get_power)){
                            if($menu==$item['title_id']){
                                require_once $item['link'];
                                break;
                            }
                        }


                    }
                    else{
                        ?>
                                <img style="width: 50%; margin: 0 auto;" src="../view/img/cute.jpg" alt="">

                        <?php
                    }

                   

               
               
                    
                ?>









                </div>
            </div>
        </div>
    </body>

    </html>