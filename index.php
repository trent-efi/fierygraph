<?php
include 'controller.php';

$id = "NULL";
$oc = "NULL";
$dr = "NULL";

$action_id = "NULL";

if($_GET['id'] && $_GET['oc'] && $_GET['dir'] ){

    $id = $_GET["id"];
    $oc = $_GET["oc"];
    $dr = $_GET["dir"];

    $action_id = $id.".".$oc;
} 

?>
<!DOCTYPE html5>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<title>FieryPerfmon Graph Portal:</title>  
        <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 	
        <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">

        <script type="text/javascript" src="dist/jquery.jqplot.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.json2.js"></script>
        <link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />	
    <head>
    <body>
        <div id="top"><div onclick="goto_calculus()"><img src="/fieryperfmon/efi.logo"/></div></div>
	<div id="content_wrapper">
	    <div id="left">
                <!--//////////TOP////////////-->
                <div class="data_box top_box">
		    <div id="tol_head"><h2>Tolerance List:</h2><hr></div>
	            <div id="list_top"></div>
		    <div id="footer_base">
                        <div>
			    <img class="prev_top" id="prev_next" src="/fierygraph/prev.png"/>
			    <img class="next_top" id="prev_next" src="/fierygraph/next.png"/>
			</div>
			<hr>
			<div id="foot_box">
                            <div>Calculus ID:
                                <input id="id_box_top" type="text" name="cal_id_top" placeholder="Ex: 999999.t0">
				Directory Name:
				<input id="dir_box_top" type="text" name="dir_name_top" placeholder="Ex: FieryPerfmon_1">
				<button id="calc_btn_top" onclick="import_top()">Graph It!</button>
                            </div>
                            <div id="box-wrap-right">
                                <div class="box-inner">
                                    <b>Choose a CSV to upload:</b>
				</div>
				<div class="box-inner">
				    <input type="file" id="files" name="files[]" >
				</div>
                            </div>
			</div><!-- end foot_box -->
                    </div><!-- end footer_base -->
		</div><!-- TO HERRE -->



                <!--////////////BOT//////////-->
                <div class="data_box bot_box">
		    <div id="tol_head"><h2>Tolerance List:</h2><hr></div>
	            <div id="list_bot"></div>
		    <div id="footer_base">
                        <div>
			    <img class="prev_bottom" id="prev_next" src="/fierygraph/prev.png"/>
			    <img class="next_bottom" id="prev_next" src="/fierygraph/next.png"/>
			</div>
			<hr>
			<div id="foot_box">
                            <div>Calculus ID:
                                <input id="id_box_bot" type="text" name="cal_id_bot" placeholder="Ex: 999999.t0">
				Directory Name:
				<input id="dir_box_bot" type="text" name="dir_name_bot" placeholder="Ex: FieryPerfmon_1">
				<button id="calc_btn" onclick="import_bot()">Graph It!</button>
                            </div>
                            <div id="box-wrap-right">
                                <div class="box-inner">
                                    <b>Choose a CSV to upload:</b>
				</div>
				<div class="box-inner">
				    <input type="file" id="files" name="files[]" >
				</div>
                            </div>
			</div><!-- end foot_box -->
                    </div><!-- end footer_base -->
		</div><!-- TO HERRE -->




                <!--/////////////////////////-->    
	    </div><!-- end left -->
	    <div id="right">
	        <div id="chart1"></div>
		<div>Start Time:</div>
		<div>End Time:</div>
	    </div>
	</div>	

    <script class="code" type="text/javascript">
    MAX_PAGE = 0;
    CUR_PAGE = 0;
    ROW_SIZE = 10;
    DATA_ARR_TOP = new Array();
    DATA_ARR_BOT = new Array();
    INDEX_TOP = 0;
    INDEX_BOT = 0;
    PLOT_NUM_TOP = new Array();
    PLOT_NUM_BOT = new Array();
    

    $(document).ready(function(){
        var plot1 = $.jqplot ('chart1', [[3,7,9,1,5,3,8,2,5]]);
        var id = <?php echo $id; ?>;
        var oc = <?php echo $oc; ?>;
	var dr = <?php echo $dr; ?>;
        
        //PLOT_NUM_BOT = [99.3076154971, 99.3076154971, 99.3076154971, 99.3076154971, 99.3076154971, 99.3076154971, 99.181638627, 99.181638627, 99.181638627, 99.181638627, 99.181638627, 99.181638627, 99.1743143904, 99.1743143904, 99.1743143904, 99.1743143904, 99.1743143904, 99.1743143904, 99.1630838942, 99.1630838942, 99.1630838942, 99.1630838942, 99.1630838942, 99.1630838942, 99.162839753, 99.162839753, 99.162839753, 99.162839753, 99.162839753, 99.162839753, 99.1674784362, 99.1674784362, 99.1674784362, 99.1674784362, 99.1674784362, 99.1674784362, 99.1601541996, 99.1601541996, 99.1601541996, 99.1601541996, 99.1601541996, 99.1601541996, 99.1618631881, 99.1618631881, 99.1618631881, 99.1618631881, 99.1618631881, 99.1618631881, 99.1547830927, 99.1547830927, 99.1547830927, 99.1547830927, 99.1547830927, 99.1547830927, 99.1513651156, 99.1513651156, 99.1513651156, 99.1513651156, 99.1513651156, 99.1513651156, 99.1542948103, 99.1542948103, 99.1542948103, 99.1542948103, 99.1542948103, 99.1542948103, 99.1574686462, 99.1574686462, 99.1574686462, 99.1574686462, 99.1574686462, 99.1574686462, 99.1538065278, 99.1538065278, 99.1538065278, 99.1538065278, 99.1538065278, 99.1538065278, 99.1530741042, 99.1530741042, 99.1530741042, 99.1530741042, 99.1530741042, 99.1530741042, 99.1616190469, 99.1616190469, 99.1616190469, 99.1616190469, 99.1616190469, 99.1616190469, 99.1777323675, 99.1777323675, 99.1777323675, 99.1777323675, 99.1777323675, 99.1777323675, 99.1833476156, 99.1833476156, 99.1833476156, 99.1833476156, 99.1833476156, 99.1833476156, 99.2082500201, 99.2082500201, 99.2082500201, 99.2082500201, 99.2082500201, 99.2082500201, 99.2265606117, 99.2265606117, 99.2265606117, 99.2265606117, 99.2265606117, 99.2265606117, 99.241209085, 99.241209085, 99.241209085, 99.241209085, 99.241209085, 99.241209085, 99.2604962414, 99.2604962414, 99.2604962414];

        //PLOT_NUM_BOT = [2765185024, 2542374912, 2448568320, 2515464192, 2493407232, 2495176704, 2487017472, 2511806464, 2482704384, 2587635712, 2612002816, 2536095744, 2567692288, 2398334976, 2313175040, 2414546944, 2412097536, 2300383232, 2392719360, 2424385536, 2411180032, 2375929856, 2391162880, 2399596544, 2371047424, 2413117440, 2463649792, 2466881536, 2471239680, 2386477056, 2451836928, 2431492096, 2449879040, 2450186240, 2460512256, 2431422464, 2420854784, 2390740992, 2404573184, 2426974208, 2422706176, 2442170368, 2446098432, 2381852672, 2403975168, 2394247168, 2381094912, 2395422720, 2384859136, 2381574144, 2384916480, 2387492864, 2387808256, 2348118016, 2395664384, 2395443200, 2418167808, 2405285888, 2413617152, 2390466560, 2386214912, 2388709376, 2349289472, 2386124800, 2397970432, 2376110080, 2325655552, 2377539584, 2395283456, 2381643776, 2364157952, 2355347456, 2411524096, 2381840384, 2418581504, 2408980480, 2399059968, 2393108480, 2372587520, 2369392640, 2373099520, 2367053824, 2395693056, 2384334848, 2387767296, 2352533504, 2374025216, 2416775168, 2337595392, 2402975744, 2393804800, 2374524928, 2352771072, 2397286400, 2385813504, 2402787328, 2361147392, 2385371136, 2373566464, 2178961408, 2253561856, 2231951360, 2362880000, 2338504704, 2350448640, 2344439808, 2294591488, 2247438336, 2243252224, 2242244608, 2240811008, 2271870976, 2232979456, 2275282944, 2271596544, 2267734016, 2260865024, 2302398464, 2286170112, 2279383040, 2280751104, 2281922560, 2279948288];
        //alert();
	console.log("id: " + id );
	console.log("oc: " + oc );
	console.log("dr: " + dr );

        //init_page (id, oc, dr);		    
	update_page_display(id, oc, dr, "bot");
    });

    function init_page (id, oc, dr) {
        $.ajax({
            url: 'controller.php',
            method: 'POST',
	    data:  {'function': 'get_data_arr', 'id': id, 'oc': oc, 'dr': dr},
	    success: function(str){
	        //alert(str);

                var arr = JSON.parse(str);
	        DATA_ARR_TOP = arr;

		$.ajax({
                    url: 'controller.php',
                    method: 'POST',
	            data:  {'function': 'init_page', 'id': id, 'oc': oc, 'dr': dr, 'size' : ROW_SIZE, 'box' : 'top'},
	            success: function(str){
		        //alert(str);
	                $("#list_top").append(str);               

                        var length = DATA_ARR_TOP.length;
			MAX_PAGE = Math.floor(length / ROW_SIZE);

		        if(MAX_PAGE <= 0) {
		            MAX_PAGE = 1;
		        }
                        handle_row_display(0, 'top');
                        //click the first row...
		        $("#row0top").click(); 
	            }   
                });
	    }
        });
    }//end init_page()

    function handle_row_display(page_num, box){
  
        //alert(page_num + box);


	var class_name = ".row_select_" + box;
        var prev_id = ".prev_" + box;
	var next_id = ".next_" + box;

        $(class_name).css({"display":"none"});
        
        $(prev_id).css({"visibility":"hidden"});
        $(next_id).css({"visibility":"hidden"});
        
        if (page_num == 0 && page_num < MAX_PAGE && MAX_PAGE > 1) {
	    $(next_id).css({"visibility":"visible"});
	} 
	if (page_num > 0 && page_num < MAX_PAGE && MAX_PAGE > 1) {
	    $(prev_id).css({"visibility":"visible"});
            $(next_id).css({"visibility":"visible"});
	} 
	if (page_num >= MAX_PAGE && MAX_PAGE > 1) {
	    $(prev_id).css({"visibility":"visible"});
	}
	
	var row_id = "";
	var start = page_num * ROW_SIZE;
	var end = start + ROW_SIZE;
	for(var i = start; i < end; i++){
            row_id = "#row"+i+box;
	    $(row_id).css({"display":"inherit"});    
        }

    }//end handle_row_display()

    function start_selected(index, box) {
        //alert("SS: "+index + " " + box);

        get_data_by_index(index, box);	
        //row_selected(index, box);
    }//end start_selected()


    function get_data_by_index(index, box){
        index = parseInt(index);

	if(box == "top"){
	    INDEX_TOP = index;
            update_chart( DATA_ARR_TOP[index][0], index, box );
	    
	} else {
	    INDEX_BOT = index;
            update_chart( DATA_ARR_BOT[index][0], index, box );
	    
	}

        //update_chart( DATA_ARR_TOP[INDEX_TOP][0], DATA_ARR_BOT[INDEX_BOT][0], index, box );
	
    }

    function update_chart(data, index, box){
        alert(data);
        var name = "#name"+index+box;
	//var proc_name = "<h2>"+$(name).html()+"</h2>"; 
        var proc_name = "<h2>Name Comming Soon</h2>";
        var plot_num_top = [];
        var plot_num_bot = [];

        if (box == "top") {
	    for(i = 1; i < data.length; i++) {
	        plot_num_top[i] = parseInt(data[i]);
	    }
            PLOT_NUM_TOP = plot_num_top;
	    plot_num_bot = PLOT_NUM_BOT;
	} else {
	    for(i = 1; i < data.length; i++) {
	        plot_num_bot[i] = parseInt(data[i]);
	    }
            PLOT_NUM_BOT = plot_num_bot;
	    plot_num_top = PLOT_NUM_TOP;
	}

        //alert(plot_num);

	var options = {};        

	options = {
	    title: proc_name,
	    cursor: {
                show: true,
                zoom: true
            },
            axes: {
                xaxis: {
		    label:'Time (minutes)',
		    tickInterval: 1,
                    renderer: $.jqplot.CategoryAxisRenderer
                },
                yaxis: {
		    renderer: $.jqplot.CategoryAxisRenderer
		}
            },
	    grid: {
                backgroundColor: '#EBEBEB',
                borderWidth: 0,
                gridLineColor: 'grey',
                gridLineWidth: 1,
                borderColor: 'black'
            }
	};

        plot1 = $.jqplot('chart1', [plot_num_bot, plot_num_top], options);
        plot1.replot( { resetAxes: true } );
    }

    function import_top(){
        alert("TOP");
        ID_button_click("top");
    }

    function import_bot() {
        alert("BOT");
	ID_button_click("bot");
    }

    function ID_button_click(box){
        var input_id = "cal_id_" + box;
	var input_dr = "dir_name_" + box;

	var cal_id = document.getElementsByName(input_id)[0].value;
	var dir_name =  document.getElementsByName(input_dr)[0].value;
        var arr = [];
        arr = cal_id.split(".");
	var id = arr[0];
	var oc = arr[1];

        //alert("id: " + id + " oc: " + oc + " dir_name: " + dir_name);
        var url = build_url(cal_id, dir_name);

	if( check_url(url) == 'true' ) {

	    console.log("RETURNED TRUE");

	    update_page_display(id, oc, dir_name, box);
	} else {

	    console.log("RETURNED FALSE");
            //$("#error_msg").css("visibility","visible");
	}
    }

    function build_url(id, dir){
        return "http://calculus-logs.efi.internal/logs/"+id+"/"+dir+"/FieryPerfmon_1.csv";
    }
    
    function check_url(url){
        return $.ajax({
            url: 'controller.php',	
            method: "POST",
	    data: {'function': 'check_url', 'url': url},
            cache: false,
            async: false
        }).responseText;
    }

    function update_page_display(id, oc, dr, box) {
        $.ajax({
            url: 'controller.php',
            method: 'POST',
	    data:  {'function': 'get_data_arr', 'id': id, 'oc': oc, 'dr': dr},
	    success: function(str){
	        //alert(str);

                var arr = JSON.parse(str);

		if(box == "top") {

	            DATA_ARR_TOP = arr;
		} else {

	            DATA_ARR_BOT = arr;		
		}

		$.ajax({
                    url: 'controller.php',
                    method: 'POST',
	            data:  {'function': 'init_page', 'id': id, 'oc': oc, 'dr': dr, 'size' : ROW_SIZE, 'box' : box},
	            success: function(str){
		        alert(str);
			var list_id = "#list_" + box;
	                $(list_id).append(str);               
                        
			var length = 0;
                        if(box == "top") {
                            length = DATA_ARR_TOP.length;
			} else {
                            length = DATA_ARR_BOT.length;			
			}

			MAX_PAGE = Math.floor(length / ROW_SIZE);

		        if(MAX_PAGE <= 0) {
		            MAX_PAGE = 1;
		        }
                        handle_row_display(0, box);
                        //click the first row...
			var row_id = "#row0" + box;
		        $(row_id).click(); 
	            }   
                });
	    }
        });
    
    }

    </script>

    </body><!-- end body -->

</html>

