
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            case 'add': 
                                require_once './staff/add.php';
                                break;
                            case 'del':
                                require_once './staff/del.php';
                                break;
                            case 'edit':
                                require_once './staff/edit.php';
                                break;
                            
                            default: 
                                require_once './staff/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './staff/list.php';
                    }
                    
                ?>


