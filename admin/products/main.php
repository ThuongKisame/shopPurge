
                <?php

                    

                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            case 'add': 
                                require_once 'add.php';
                                break;
                            case 'add-detail': 
                                require_once 'add-detail.php';
                                break;
                            case 'del':
                                require_once 'del.php';
                                break;
                            case 'del-detail':
                                require_once 'del-detail.php';
                                break;
                            case 'edit':
                                require_once 'edit.php';
                                break;
                            case 'edit-detail':
                                require_once 'edit-detail.php';
                                break;
                            
                            default: 
                                require_once 'list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once 'list.php';
                    }
                    
                ?>








