
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            // case 'del':
                            //     require_once './orders/del.php';
                            //     break;

                            // case 'detail':
                            //     require_once './orders/detail.php';
                            //     break;
                            case 'handle':
                                    require_once './orders/handle.php';
                                    break;                                                       
                            default: 
                                require_once './orders/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './orders/list.php';
                    }
                    
                ?>


