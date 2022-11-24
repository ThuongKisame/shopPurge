<?php
    require_once 'dbExtra.php';
    // function checkStore($quantity, $prd_id, $size, $conn){
    //     $sql_store = "SELECT * FROM store WHERE prd_id = $prd_id  AND size = '$size' and quantity >= $quantity";
    //     $result_store = mysqli_query($conn, $sql_store);
    //     $row_store = mysqli_num_rows($result_store);
        
    //     return $row_store;
    // }
    if(isset($_GET['user_id']) && isset($_GET['prd_id']) && isset($_GET['detail_prd_size_id']) && isset($_GET['quantity'])){
        $user_id = $_GET['user_id'];
       $prd_id = $_GET['prd_id'];
        $detail_prd_size_id = $_GET['detail_prd_size_id'];
        $quantity = $_GET['quantity'];
            $sql_cart = "SELECT * FROM cart Where  detail_prd_size_id=$detail_prd_size_id and user_id = $user_id";
            $result_cart = mysqli_query($conn, $sql_cart);
            $row_cart = mysqli_num_rows($result_cart);
            // $product_cart = mysqli_fetch_assoc($result_cart);
            if($row_cart){
                // echo $product_cart;
                
                    // echo checkStore($tmp, $prd_id, $size, $conn);
                    $sql = "UPDATE cart SET quantity_cart = quantity_cart+$quantity WHERE detail_prd_size_id = $detail_prd_size_id  and user_id = $user_id" ;
                    $result = mysqli_query($conn, $sql);
                
            }                
            else{
                
                    $sql = "INSERT INTO cart(user_id,detail_prd_size_id,quantity_cart) VALUES ($user_id,$detail_prd_size_id,$quantity)";
                    $result = mysqli_query($conn, $sql);
                
            }
            
            
                $sql = "SELECT * FROM cart where user_id = $user_id";
                $resultInCart= mysqli_query($conn, $sql);
                $quantityInCartAfter=0;
                 while($row = mysqli_fetch_assoc($resultInCart)){
                     
                    $quantityInCartAfter += $row['quantity_cart'];
                    // echo  $row['quantity']. "---";
                    // echo  $quantityInCart. "   ";
                    
                }
                echo  $quantityInCartAfter;

                
            
            
        
       
    }
    else{
        echo "failed";
    }

    

    
?>

<?php
                                
                                ?>

