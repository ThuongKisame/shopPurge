
                <?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                           
                            case 'add':
                                require_once './import/add.php';
                                break;
                            
                            
                            default: 
                                require_once './import/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './import/list.php';
                    }
                    
                ?>






