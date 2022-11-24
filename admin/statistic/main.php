<style>
        html {
            padding: 0;
            margin: 0;
        }
        
        .button-blue {
            display: block;
            background: white;
            padding: 20px;
            position: relative;
            color: #000;
            box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2);
            box-shadow: 0 -2px 1px -1px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin: 0 0 0.75rem 0;
            text-align: center;
        }
        .button-blue .listItem{
            display: none;
        }
        
        .button-blue .digit {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .button-blue h6 {
            text-transform: uppercase;
        }
        
        .button-blue h6 span {
            margin-right: 10px;
        }
        
        .button-blue ul {
            margin: 0 4rem;
            text-align: left;
            padding: 0;
            list-style-type: none;
            border-radius: 10px;
            background-color: rgb(223, 223, 223);
        }
        
        .button-blue ul li {
            padding: .5rem 2rem;
            width: 100%;
        }
        
        .button-blue ul li:not(:last-child) {
            border-bottom: 1px solid #fff;
        }
        
        .button-blue .style {
            width: 10px;
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            background: #7daee9;
        }
        
        .button-blue .style:after {
            content: "";
            position: absolute;
            z-index: 1;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: -5px;
            height: 5px;
            background: #4e8ad1;
        }
        
        .button-blue .style-right {
            width: 10px;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: #7daee9;
        }
        
        .button-blue .style-right:after {
            content: "";
            position: absolute;
            z-index: 1;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: -5px;
            height: 5px;
            background: #4e8ad1;
        }
        
        .button-blue:after {
            content: "";
            position: absolute;
            background: #e6e6e6;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: -5px;
            height: 5px;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
   
    
<div class="card">
                    <div class="card-header">
                        <h3>Thống kê</h3>

                    </div>
                    <div class="card-body">
                        <div id="title-list-products">
                            
                            <h4>Tìm kiếm theo danh mục</h4>
                            
                            </div>
                            <div class="form-group">
                                <label for="">Từ</label>
                                <input type="datetime-local" id="time_start" name="date-start" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">
                                <label for="">Đến</label>
                                <input type="datetime-local" id="time_end" name="date-start" value="" min="2018-06-07T00:00" max="2100-06-14T00:00">
                            </div>
                        </div>

                        <table class="table" id="renderRank">
                            

                        </table>
                    </div>
                </div>
<script>
    $(function(){
        $table = $('#renderRank');
        $time_start = $('#time_start');
        $time_end = $('#time_end');

        function input(){
            $time_startValue = $time_start.val();
            $time_endValue = $time_end.val();
            if($time_startValue!='' && $time_endValue!=''){
                getData( $time_startValue, $time_endValue);
            }
        }

        
        if($time_start.on('change', function(){
            input();
        }))
        if($time_end.on('change', function(){
            input();
        }))


        function getData($from, $to){
            $.ajax({
                type: 'GET',
                url: './statistic/layout.php',
                data: {
                    from: $from,
                    to: $to
                },
                success: function(data){
                    $table.html(data);
                },
                error: function(){

                }
            })
        }
    })

</script>

