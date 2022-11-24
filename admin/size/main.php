
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'del':
                                require_once './size/del.php';
                                break;

                            case 'edit':
                                require_once './size/edit.php';
                                break;
                            case 'add':
                                require_once './size/add.php';
                                break;
                            
                            
                            default: 
                                require_once './size/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './size/list.php';
                    }
                    
                ?>






