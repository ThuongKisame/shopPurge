<?php
    require_once '../model/db.php';
    $sql = "SELECT * FROM log ORDER BY time DESC";
    $result = mysqli_query($conn, $sql);
    while($item = mysqli_fetch_assoc($result)){
        $json[]=["time"=>$item['time'], "activity"=>$item['activity']];
    }
    $index= 0;


?>

<div class="card">
                    <div class="card-header">
                        <h3>Nhật ký hoạt động</h3>
                        <h6 class="total-quantity">Có tất cả <span><?php echo count($json) ?></span> hoạt động</h6>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search-box">
                            <h4>Tìm kiếm theo danh mục</h4>
                            <div id="filter-box" style="display:flex;">
                                <div class="form-group">
                                    <select name="newArrival" class="form-control" id="time">
                                    <option value="" selected="selected">Sắp xếp theo thời gian</option>
                                    <option value="increase" >Mới nhất</option>
                                    <option value="decrease" >Cũ nhất</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>STT</th>
            <th>Thời gian</th>
            <th>Hoạt động</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($json as $i){
                $index++;
                ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        
                        <td><?php echo $i['time'] ?></td>
                        <td><?php echo $i['activity'] ?></td>

                    </tr>
                <?php 
            }
        
        ?>
    </tbody>
</table>
</div>
                    </div>
                </div>


<script>
    $(function(){
        
        $search = $('#search-box');
        $time = $('#time');
        $timeValue = "";
        $json = <?php print_r(json_encode($json)) ?>;
       
        $search.on('keyup', function(e){
            $searchValue = validateData($search.val());
            $data = $.grep($json, function(v) {
                return ((v['time'].search($searchValue) > -1)||(v['activity'].search($searchValue) > -1));
            });
            renderData($data)
        })


        $time.on('change', function(){
            $timeValue = $time.val();
            renderFilter($timeValue,  $json);
        })



        function renderFilter($time, $json){
            $data =$json;
            if($time == 'decrease'){
                $data.sort(function (a, b) {
                    // console.log(a.time < b.time);
                    if (a.time < b.time) {
                        return -1;
                    }
                    if (a.time > b.time) {
                        return 1;
                    }
                    return 0;
                });
            }

            if($time == 'increase'){
                $data.sort(function (a, b) {
                    if (b.time < a.time) {
                        return -1;
                    }
                    if (b.time > a.time) {
                        return 1;
                    }
                    return 0;

                });

            }

            renderData($data)

            

        }

        renderData($json)
        function renderData($json){
            $tbody = $('tbody');
            $tbody.html('');
            $index = 0;
            $.each($json, function(index, value){
                $index++;
                $tbody.append(` <tr>
                        <td>${$index}</td>
                        
                        <td>${value['time']}</td>
                        <td>${value['activity']}</td>

                    </tr>
                                `)
            })


            
        }


        function validateData($input) {
            return $input.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, "");

        
        }
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    })

</script>