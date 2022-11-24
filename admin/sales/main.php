


                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'del':
                                require_once './sales/del.php';
                                break;

                            case 'edit':
                                require_once './sales/edit.php';
                                break;
                            case 'add':
                                require_once './sales/add.php';
                                break;
                            
                            
                            default: 
                                require_once './sales/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './sales/list.php';
                    }
                    
                ?>







