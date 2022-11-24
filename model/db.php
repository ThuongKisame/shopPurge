<?php 
    require 'constants.php';
    header("Content-type: text/html; charset=utf-8");
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn, 'UTF8');
    if($conn->connect_error){
        die('Database error: ' .$conn->connect_error);
    }

?>