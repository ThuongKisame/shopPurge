
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'del':
                                require_once './category/del.php';
                                break;

                            case 'edit':
                                require_once './category/edit.php';
                                break;
                            case 'add':
                                require_once './category/add.php';
                                break;
                            
                            
                            default: 
                                require_once './category/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './category/list.php';
                    }
                    
                ?>






