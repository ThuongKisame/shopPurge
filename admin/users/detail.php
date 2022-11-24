<?php
    require_once '../model/db.php';

    if(isset($_GET['id'])){
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM orders WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql); 
        $json = array(); 
        while($item = mysqli_fetch_assoc($result)){
            $order_id = $item['order_id'];
            $sql1 = "SELECT * FROM detail_order WHERE order_id = $order_id";
            $result1 = mysqli_query($conn, $sql1);
            $array = array();
            while($item1 = mysqli_fetch_assoc($result1)){
                array_push($array, $item1);
            }
            $json[] = ["order"=>$item, "detail"=>$array];
        } 
    }

    // print_r(json_encode($json));

?>

<div class="card">
                    <div class="card-header">
                        <h3>Danh sách đơn hàng khách hàng <?php echo $user_id ?>  </h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json); ?></span> đơn hàng</h6>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                           
                        </div>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên người nhận</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết đơn hàng</th>




                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index=0;
                                foreach($json as $item){
                                    $index++;
                                    ?>
                                <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo $item['order']['name_customer'] ?></td>
                                    <td><?php echo $item['order']['phoneNumber'] ?></td>
                                    <td><?php echo $item['order']['address_detail']." ".$item['order']['village']." ".$item['order']['district']." ".$item['order']['province']  ?></td>
                                    <td>
                                        <ul style="text-align: left">
                                            <li>Ngày đặt: <?php echo $item['order']['date'] ?> </li>
                                            <?php
                                            $state = "Chờ xác nhận";
                                            if($item['order']['date_confirm']!="0000-00-00 00:00:00"){
                                                $state = "Chờ xử lý";
                                                echo '<li>Ngày xác nhận: '.$item['order']['date_confirm'].' </li>';
                                            } ?>
                                            <?php if($item['order']['date_complete']!="0000-00-00 00:00:00"){
                                                $state = "Đang giao hàng";
                                                echo '<li>Ngày giao hàng: '.$item['order']['date_complete'].' </li>';
                                            } ?>
                                            <?php if($item['order']['date_receipt']!="0000-00-00 00:00:00"){
                                                $state = "Đơn hàng thành công";
                                                echo '<li>Ngày nhận hàng: '.$item['order']['date_receipt'].' </li>';
                                            } ?>
                                            <?php if($item['order']['date_cancel']!="0000-00-00 00:00:00"){
                                                $state = "Đơn hàng đã hủy";
                                                echo '<li>Ngày hủy: '.$item['order']['date_cancel'].' </li>';
                                            } ?>
                                            
                                            <!-- <li>Ngày xử lí xong, giao hàng: </li>
                                            <li>Ngày nhận hàng: </li> -->
                                        </ul>
                                        <button type="button" class="btn btn-info"><?php echo $state ?></button>
                                    </td>
                                    <td style="width: 40%">

                                    <div  style="display: flex; flex-wrap: wrap;">
                                    <?php 
                                        
                                        foreach($item['detail'] as $item_prd){
                                                $totalPrice = $item_prd['price']*$item_prd['quantity']-$item_prd['price']*$item_prd['quantity']*$item_prd['percent']/100;

                                            ?>
                                            <div class="product-item col-12">
                                            <img style=" float: left;width: 50%;" src="../view/img/<?php echo $item_prd['image_front']  ?>" alt=""  style=" ">

                                                <ul>
                                                <li><strong><?php echo $item_prd['prd_name']  ?></strong></li>
                                                    <li><strong>Size</strong> <?php echo $item_prd['size']  ?></li>
                                                    <li><strong>Số lượng :</strong> <?php echo $item_prd['quantity']  ?></li>
                                                    <li><strong>Giá gốc:</strong> <?php echo number_format($item_prd['price'])  ?>₫</li>
                                                    <li><strong>Sale: </strong> <?php echo $item_prd['percent']  ?>%</li>
                                                    <li><strong>Tổng: </strong> <?php echo number_format($totalPrice) ?>₫</li>
                                                </ul>
                                        </div>
                                            <?php
                                        }
                                    
                                    ?>
                                    </div>
                                    
                                            </td>
                                        
                                </tr>
                                
                                    
                                    <?php
                                } ?>
                                



                            </tbody>

                        </table>
                    </div>
                </div>