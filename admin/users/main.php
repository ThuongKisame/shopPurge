<?php
                    if(isset($_GET['layout'])){
                        switch($_GET['layout']){
                            
                            // case 'del':
                            //     require_once './users/del.php';
                            //     break;

                            case 'detail':
                                require_once './users/detail.php';
                                break;
                            
                            
                            default: 
                                require_once './users/list.php';
                                break;
                            
                        }
                    }
                    else{
                        require_once './users/list.php';
                    }
                    
                ?>