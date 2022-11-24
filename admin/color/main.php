
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'del':
                                require_once './color/del.php';
                                break;

                            case 'edit':
                                require_once './color/edit.php';
                                break;
                            case 'add':
                                require_once './color/add.php';
                                break;
                            
                            
                            default: 
                                require_once './color/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './color/list.php';
                    }
                    
                ?>






