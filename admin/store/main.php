
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            case 'edit':
                                require_once './store/edit.php';
                                break;
                            
                            default: 
                                require_once './store/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './store/list.php';
                    }
                    
                ?>







