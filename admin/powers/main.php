
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'del':
                                require_once './powers/del.php';
                                break;

                            case 'edit':
                                require_once './powers/edit.php';
                                break;
                            case 'add':
                                require_once './powers/add.php';
                                break;
                            
                            
                            default: 
                                require_once './powers/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './powers/list.php';
                    }
                    
                ?>






