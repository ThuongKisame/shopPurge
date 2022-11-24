<?php
    if(isset($_SESSION['id'])){
        $staff_id =  $_SESSION['staff_id'];
    }
    // echo $staff_id;

    $sql_get_menu  = "SELECT * FROM power_detail, staff, title WHERE staff.staff_id = $staff_id AND staff.power_id = power_detail.power_id AND title.title_id = power_detail.title_id ";
    $result_get_menu = mysqli_query($conn, $sql_get_menu);
    
?>


    <div id="left-menu" class="col-2" >
        <div id="logo-left-menu" class=""><img src="./../view/img/logoPurge.png" alt=""></div>
        <ul class="list-group">
            <?php
                        while($item = mysqli_fetch_assoc($result_get_menu)){?>
                    <a href="index.php?menu=<?php echo $item['title_id'] ?>">
                <li class="list-group-item" id="<?php echo $item['title_id'] ?>">

                        <?php echo $item['title_name'] ?>
                </li>

                    </a>
                <?php
                        }               
                    ?>
        </ul>

    </div>
    <script>
        // let menu = document.querySelectorAll('.list-group-item');
        // for (let i = 0; i < menu.length; i++) {
        //     menu[i].addEventListener('click', function() {
        //         menu[i].classList.add('active');
        //     })
        // }
    </script>