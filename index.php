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
//783145.t1
//FieryPerfmon_3
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
        <script type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.cursor.min.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.highlighter.min.js"></script>
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
			    <img class="prev_top" onclick="prev_page('top')" id="prev_next" src="/fierygraph/prev.png"/>
			    <img class="next_top" onclick="next_page('top')" id="prev_next" src="/fierygraph/next.png"/>
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
			    <img class="prev_bot" onclick="prev_page('bot')" id="prev_next" src="/fierygraph/prev.png"/>
			    <img class="next_bot" onclick="next_page('bot')" id="prev_next" src="/fierygraph/next.png"/>
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
    MAX_PAGE_TOP = 0;
    MAX_PAGE_BOT = 0;
    
    CUR_PAGE_TOP = 0;
    CUR_PAGE_BOT = 0;
    
    ROW_SIZE = 10;
    DATA_ARR_TOP = new Array();
    DATA_ARR_BOT = new Array();
    INDEX_TOP = 0;
    INDEX_BOT = 0;
    PLOT_NUM_TOP = new Array();
    PLOT_NUM_BOT = new Array();

    SERIES_DATA_TOP = new Array();
    SERIES_DATA_BOT = new Array();

    COLOR_0 = '#';
    COLOR_1 = '#';

    $(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var plot1 = $.jqplot ('chart1', [[3,7,9,1,5,3,8,2,5]]);
        var id = <?php echo $id; ?>;
        var oc = <?php echo $oc; ?>;
	var dr = <?php echo $dr; ?>;
        
	console.log("id: " + id );
	console.log("oc: " + oc );
	console.log("dr: " + dr );

        while (COLOR_0 == COLOR_1){
	    COLOR_0 = '#'+Math.floor(Math.random()*16777215).toString(16);
	    COLOR_1 = '#'+Math.floor(Math.random()*16777215).toString(16);
	}
      

        //init_page (id, oc, dr);		    
	update_page_display(id, oc, dr, "top");
    });

    function handle_row_display(page_num, box){
  
        //alert(page_num + box);

        var max_page = 0;
        if (box == "top") {
	    max_page = MAX_PAGE_TOP;
	} else {
	    max_page = MAX_PAGE_BOT;
	}

	var class_name = ".row_select_" + box;
        var prev_id = ".prev_" + box;
	var next_id = ".next_" + box;

        $(class_name).css({"display":"none"});
        
        $(prev_id).css({"visibility":"hidden"});
        $(next_id).css({"visibility":"hidden"});
        
        if (page_num == 0 && page_num < max_page && max_page > 1) {
	    $(next_id).css({"visibility":"visible"});
	} 
	if (page_num > 0 && page_num < max_page && max_page > 1) {
	    $(prev_id).css({"visibility":"visible"});
            $(next_id).css({"visibility":"visible"});
	} 
	if (page_num >= max_page && max_page > 1) {
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
        row_selected(index, box);
    }//end start_selected()

    function row_selected(index, box) {
        var id_tag = "#row"+index+box;
        var row_tag = ".row_select_"+box;
	//RESET the selected row colors and highlight the new one...
	$(row_tag).css({"background-color":"white", "color":"#3572b0"});	
        $(id_tag).css({"background-color":"#3572b0", "color":"white"});

    }

    function get_data_by_index(index, box){
        index = parseInt(index);

	if(box == "top"){
	    INDEX_TOP = index;
            update_chart( DATA_ARR_TOP[index][0], index, box );
	} else {
	    INDEX_BOT = index;
            update_chart( DATA_ARR_BOT[index][0], index, box );	    
	}	
    }

    function prev_page(box) {
        if(box == "top") {
            CUR_PAGE_TOP--;
	    handle_row_display(CUR_PAGE_TOP, box);
	} else {
	    CUR_PAGE_BOT--;
	    handle_row_display(CUR_PAGE_BOT, box);
	}
    }

    function next_page(box) {

        if(box == "top") {
            CUR_PAGE_TOP++;
	    handle_row_display(CUR_PAGE_TOP, box);
	} else {
	    CUR_PAGE_BOT++;
	    handle_row_display(CUR_PAGE_BOT, box);
	}
    }

    function update_chart(data, index, box){
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
	    seriesColors: [ COLOR_0, COLOR_1],
	    title: proc_name,
	    legend: {
                show: true,
                rendererOptions: {
                    // numberColumns: 2,
                    fontSize: '10pt'
                }
	    },
            seriesDefaults: {
                renderer: $.jqplot.FunnelRenderer
            },
	    cursor: {
                zoom:true, 
                looseZoom: true, 
                showTooltip:true, 
                followMouse: true, 
                showTooltipOutsideZoom: true, 
                constrainOutsideZoom: false
            },
            axes: {
                xaxis: {
		    label:'Time (minutes)',
		    tickInterval: 1,
                    renderer: $.jqplot.CategoryAxisRenderer,
                    pad: 0	    
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

        plot1 = $.jqplot('chart1', [plot_num_top, plot_num_bot], options);
        plot1.replot( { resetAxes: true } );
    }

    function import_top(){
        ID_button_click("top");
    }

    function import_bot() {
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
                        //alert(str);
		        
			var list_id = "#list_" + box;
	                $(list_id).append(str);               
                        
			var length = 0;
                        if(box == "top") {
                            length = DATA_ARR_TOP.length;
			    MAX_PAGE_TOP = Math.floor(length / ROW_SIZE);

		            if( MAX_PAGE_TOP <= 0) {
		                MAX_PAGE_TOP = 1;
		            }

			} else {
                            length = DATA_ARR_BOT.length;
			    MAX_PAGE_BOT = Math.floor(length / ROW_SIZE);

		            if( MAX_PAGE_BOT <= 0) {
		                MAX_PAGE_BOT = 1;
		            }
			    
			}
                       
		        $.ajax({
			    url: 'controller.php',
			    method: 'POST',
			    data: {'function': 'get_time_line', 'id': id, 'oc': oc, 'dr': dr, 'box': box},
			    success: function(str) {
				if(box == "top") {
				    SERIES_DATA_TOP = str;
				} else {
				    SERIES_DATA_BOT = str;
				}
				console.log(str);
			    }
			});

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

