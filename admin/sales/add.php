<?php
    require_once '../model/db.php';
    require_once './onload.php';
    $sql_sale = "SELECT * FROM sale order by date_start asc";
    $result_sale = mysqli_query($conn, $sql_sale);
    $arraySale = array();
    while($itemSale = mysqli_fetch_assoc($result_sale)){
        array_push($arraySale, ["time_start"=>$itemSale['date_start'], "time_end"=>$itemSale['date_end']]); 
    }


    // print_r(json_encode($arraySale));



    if(isset($_POST['sbm'])){
            $sale_name = $_POST['sale_name'];
            $percent = $_POST['percent']; 
            $start = $_POST['date-start'];       
            $end = $_POST['date-end'];       
            $category = $_POST['category'];
            $date_start = substr($start, 0,10). " " .substr($start, -5 ). ":00";
            $date_end = substr($end, 0,10). " " .substr($end, -5 ). ":00";    
            $text="";
            foreach($category as $i){
                if($i == 'all'){
                    $text = "all-";
                    break;
                }else{
                    $text.=$i."-";
                }

            } 
            $text = substr($text, 0, -1);

           

            $sql_insert_sale = "INSERT INTO sale( sale_name, percent, date_start, date_end, category) VALUES( '$sale_name', $percent, '$date_start', '$date_end', '$text')";
            $result_insert_sale = mysqli_query($conn, $sql_insert_sale);
            addLog($conn, $staff_id, " đã tạo chương trình giảm giá mới ".$sale_name." (".$date_start."   -   "."$date_end".")");
        
            
            echo '<script> location.href = "index.php?menu=4"  </script>';


        
        
    }


    

?>




<div class="card">
                    <div class="card-header">
                        <h2>Thêm chương trình giảm giá</h2>
                    </div>
                    <div class="card-body">
                        <form action="index.php?menu=4&layout=add" method="POST" enctype="multipart/form-data" id="form-add-sale">
                            <div class="form-group">
                                <label for="">Tên chương trình</label>
                                <input type="text" name="sale_name" id="sale_name" class="form-control">
                                <small></small>
                            </div>
                            <div class="form-group">
                                <label for="">Giảm giá(%)</label>
                                <input type="text" name="percent" id="percent" class="form-control">
                                <small></small>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày bắt đầu giảm giá</label>
                                <input type="datetime-local" id="time_start" name="date-start" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">

                                <small></small>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày kết thúc giảm giá</label>
                                <input type="datetime-local" id="time_end" name="date-end" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">
                                <small></small>
                            
                            </div>
                            <label for="">Áp dụng cho danh mục</label>
                            <ul class="list-group list-group-flush form-group" id="prd" >
                              <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkAll" name='category[]' value="all">
                                    <label class="custom-control-label" for="checkAll">Tất cả sản phẩm</label>
                                </div>
                            </li>
                            <?php
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn, $sql);
                                while($item = mysqli_fetch_assoc($result)){
                                    ?>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="check<?php echo $item['category_name'] ?>" name='category[]' value="<?php echo $item['category_name'] ?>">
                                    <label class="custom-control-label" for="check<?php echo $item['category_name'] ?>"><?php echo $item['category_name'] ?></label>
                                </div>
                            </li>

                                    <?php
                                }
                            
                            ?>                       
<!--                             
                           
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkTee" name='category[]' value="tee">
                                    <label class="custom-control-label" for="checkTee">Tee</label>
                                </div>
                            </li>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkHoodie" name='category[]' value="hoodie">
                                    <label class="custom-control-label" for="checkHoodie">Hoodie</label>
                                </div>
                            </li>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkJacket" name='category[]' value="jacket">
                                    <label class="custom-control-label" for="checkJacket">Jacket</label>
                                </div>
                            </li>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkSweater" name='category[]' value="sweater">
                                    <label class="custom-control-label" for="checkSweater">Sweater</label>
                                </div>
                            </li>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkPants" name='category[]' value="pants">
                                    <label class="custom-control-label" for="checkPants">Pants</label>
                                </div>
                            </li>
                            <li class="list-group-item validate-li">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input title"  id="checkAccessories" name='category[]' value="accessories">
                                    <label class="custom-control-label" for="checkAccessories">Accessories</label>
                                </div>
                            </li>  -->
                            

                        <small>error</small>

                    </ul>
                            <button type="submit" name="sbm" class="btn btn-success">Thêm</button>
                        </form>
                    </div>

                </div>

                    <script>
    //validation sign up
    const formAddSale = document.querySelector('#form-add-sale');
    const sale_name = document.querySelector('#sale_name');
    const percent = document.querySelector('#percent');
    const time_start = document.querySelector('#time_start');
    const time_end = document.querySelector('#time_end');

    const title = document.querySelectorAll('.title');
    const li = document.querySelector('.validate-li');
    




    formAddSale.addEventListener('submit', e => {
        let isSend = true;

        if (sale_name.value === '') {
            setErrorFor(sale_name, 'Chưa có thông tin tên chương trình');
            isSend = false;
        } else {
            setSuccessFor(sale_name);
            sale_name.value = validateData(sale_name.value);
        }

        if (percent.value === '') {
            setErrorFor(percent, 'Chưa có thông tin giảm giá');
            isSend = false;
        } else {
            if(isNaN(percent.value) || percent.value <= 0 || percent.value>=100){
                setErrorFor(percent, 'Không hợp lệ');
                isSend = false;
            }
            else
                setSuccessFor(percent);
        }

        if (time_start.value === '') {
            setErrorFor(time_start, 'Chưa có thông tin ngày bắt đầu');
            isSend = false;
        } else {
            setSuccessFor(time_start);            
        }

        
        

    


        if (time_end.value === '') {
            setErrorFor(time_end, 'Chưa có thông tin ngày kết thúc');
            isSend = false;
        } else {
            if(time_end.value <= time_start.value){
                setErrorFor(time_end, 'Ngày kết thúc phải lớn hơn ngày bắt đầu');
            isSend = false;
            }
            else{
                let isSale= false;
                let dataSale = <?php echo json_encode($arraySale); ?>;
                for(let i=0; i<dataSale.length-1;i++){
                    if(time_start.value > dataSale[i]['time_end'] && time_end.value< dataSale[i+1]['time_start']){
                        isSale= true;
                    }
                }
                if(time_start.value > dataSale[dataSale.length-1]['time_end']){
                    isSale= true;
                }
                if(isSale==false){
                    setErrorFor(time_end, 'Đã có chương trình khác vào thời gian này');
                    isSend = false;
                }else{
                    setSuccessFor(time_end);

                }
            }
        }
                
                
                
            
        




        let isCheck = false;
        for(let i=0; i<title.length;i++){
            if(title[i].checked){
                isCheck=true;
            }
        }
        if(!isCheck){
            setErrorFor(li, 'Chưa có thông tin danh mục');
            isSend = false;
        }else {
            setSuccessFor(li);
        }

        if (!isSend) {
            e.preventDefault();
        }

    })

    let setErrorFor = (input, message) => {
        const formControl = input.parentElement;
        const small = formControl.querySelector('small');
        formControl.classList = 'form-group error';
        small.innerText = message;
    }

    let setSuccessFor = (input) => {
        const formControl = input.parentElement;
        formControl.classList = 'form-group';
    }

    function validateData(input) {
        return input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

    }

    
</script>
