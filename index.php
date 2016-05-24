<?php
include 'controller.php';

$id = "null";
$oc = "null";
$dr = "null";

$action_id = "EMPTY";

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
        <script src="http://evanplaice.github.io/jquery-csv/src/jquery.csv.js"></script>	
        <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.cursor.min.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.highlighter.min.js"></script>
        <script type="text/javascript" src="dist/jquery.jqplot.js"></script>
        <script type="text/javascript" src="dist/plugins/jqplot.json2.js"></script>
        <script type="text/javascript" src="dist/w2ui-1.4.3.js"></script>
        <link rel="stylesheet" type="text/css" href="dist/w2ui-1.4.3.css" />
        <meta name="viewport" content="width=device-width" />	
        <!--<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.3.min.js"></script>-->
        <link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />	
    <head>
<!-- 
<div style="padding-top:20px">
    <button value="reset" type="button" onclick="plot1.resetZoom();">Reset Zoom</button>
</div>
-->

    <body><div class="shrinker">
        <div id="cover"></div>
        <div id="top">
	    <div id="efi_logo"><img src="efi.logo"/></div>
	    <div id="help_logo" onclick="show_help();">Help<img id="help_icon" src="help.png"></div>
	</div>
	<div id="content_wrapper">
	    <div id="left">
                <!--//////////TOP////////////-->
                <div class="data_box top_box">
		    <div id="tol_head_top"><h2>Tolerance List:</h2><hr></div>
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
                            <div id="box-wrap-right" >
                                <div class="box-inner">
                                    <b>Choose a CSV to upload:</b>
				</div>
				<div class="box-inner" >
				    <input type="file" id="files_top" name="files[]"  style="border: none; color: white;">
				</div>
                            </div>
			</div><!-- end foot_box -->
                    </div><!-- end footer_base -->
		</div><!-- TO HERRE -->



                <!--////////////BOT//////////-->
                <div class="data_box bot_box">
		    <div id="tol_head_bot"><h2>Tolerance List:</h2><hr></div>
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
				    <input type="file" id="files_bot" name="files[]" style="border: none; color: white;">
				</div>
                            </div>
			</div><!-- end foot_box -->
                    </div><!-- end footer_base -->
		</div><!-- TO HERRE -->




                <!--/////////////////////////-->    
	    </div><!-- end left -->
	    <div id="right">
	        <div id="zoom_reset"><button id="reset_btn" value="reset" type="button" onclick="plot1.resetZoom();">Reset Zoom</button></div>
	        <div id="chart1"></div>
		<div id="time_info">
		    <div id="time_start_top">Start Time: 00:00:00</div>
		    <div id="time_stop_top">End Time: 00:00:00</div>
		</div>
		<div id="time_info">
		    <div id="time_start_bot">Start Time: 00:00:00</div>
		    <div id="time_stop_bot">End Time: 00:00:00</div>
		</div>		
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

    INFO_TOP = "";
    INFO_BOT = "";

    SERIES_DATA_TOP = new Array();
    SERIES_DATA_BOT = new Array();

    COLOR_0 = '#';
    COLOR_1 = '#';

    /******************************************************************
     * 2 Cent solution for page loading. Problem: Page would jump when
     * all elements finished loading. Solution: show a mask while page 
     * is loading and hide it after.  
     *****************************************************************/
    $(window).on('load', function() {
	setTimeout( function() { $("#cover").hide(); }, 150);	
    });



    $(document).ready(function(){
        $.jqplot.config.enablePlugins = true;

        var plot1 = $.jqplot ('chart1', [[0]]);
        var id = <?php echo $id; ?>;
        var oc = <?php echo $oc; ?>;
	var dr = <?php echo $dr; ?>;


        /*while (COLOR_0 == COLOR_1){
	    COLOR_0 = '#'+Math.floor(Math.random()*16777215).toString(16);
	    COLOR_1 = '#'+Math.floor(Math.random()*16777215).toString(16);
	}*/
	var colors = ["#0000FF", 
		      "#00BFFF", 
		      "#006400", 
		      "#8B008B", 
		      "#8B0000", 
		      "#DAA520", 
		      "#008000", 
		      "#00FF00", 
		      "#FF4500", 
		      "#800080"];

	var size = colors.length;

	while (COLOR_0 == COLOR_1) {
	    COLOR_0 = colors[Math.floor(Math.random()*16777215) % size];
	    COLOR_1 = colors[Math.floor(Math.random()*16777215) % size];
	}
      
        $('.prev_top').css({"visibility":"hidden"});
        $('.next_top').css({"visibility":"hidden"});
      
        $('.prev_bot').css({"visibility":"hidden"});
        $('.next_bot').css({"visibility":"hidden"});

        $('#time_start_top').css({"visibility":"hidden"});
        $('#time_stop_top').css({"visibility":"hidden"});	   

        $('#time_start_bot').css({"visibility":"hidden"});
        $('#time_stop_bot').css({"visibility":"hidden"});	   

        //import csv from files logic
	if(isAPIAvailable()) {
            $('#files_top').bind('change', handleFileSelect_Top);
            $('#files_bot').bind('change', handleFileSelect_Bot);
        } else {
            $('#files_top').bind('change', unsupported_function);
            $('#files_bot').bind('change', unsupported_function);	
	}

        //init_page (id, oc, dr);		    
	if(id !== null && oc !== null && dr !== null ) {
	    update_page_display(id, oc, dr, "top");
	}
    });

    function show_help(){
	w2popup.open({
            title   : "<b>Help</b><img src='help_dark.png' height='20' width='20'>",
	    buttons : "<button onclick='w2popup.close()'>Close</button>",
            body    : "<div><b>About:</b></div>"+
	              "<div>FieryGraph is an interactive tool to visualize performance on the Fiery. When</div>"+
                      "<div>FieryPerfmon --stop is successfully called from a Calculus test, you can graph</div>"+
                      "<div>the data collected in the FieryPerfmon_1.csv file. To create a clickable link</div>"+
                      "<div>from your Calculus log files, make sure that a '-g' or '--graph' flag is</div>"+
                      "<div>included on the args when calling '--stop' or '-X' in FieryPerfmon.</div><br>"+

		      "<div><b>Example in Calculus to create link to FieryGraph: </b><div>"+
                      "<div>FieryPerfmon -g --stop</div><br>"+
    
                      "<div><b>Using FieryGraph:</b></div><br>"+

                      "<div><b>--Nodes on the graph:</b></div>"+
                      "<div>Click a node on the graph and a pop-up will show some details about this data</div>"+
                      "<div>point. </div><br>"+

                      "<div><b>--Zooming in on the graph:</b></div>"+
                      "<div>Click and drag the mouse on the chart to zoom in to get a closer view of </div>"+
                      "<div>tightly clustered nodes.</div><br>"+

                      "<div><b>--Resetting zoom:</b></div>"+
                      "<div>Click on the reset button on the top of the page to get back to your original</div>"+
                      "<div>view of the graph.</div><br>"+

                      "<div><b>--Comparing data:</b></div>"+
                      "<div>You have two different ways of importing data into FieryGraph...</div><br>"+
	              "<div><img src='graph.png' height='150' width='200'></div><br>"+

                      "<div><b>a)</b></div>"+
                      "<div>FieryGraph can now graph two different sets of FieryPermon_1.csv data on the </div>"+
                      "<div>same page. In the empty web form on the left column at the bottom of the page,</div>"+
                      "<div>enter in the Calculus ID and Occurrence ID into the 'Calculus ID' text box, </div>"+
		      "<div><img src='cal_id.png'></div>"+
                      "<div>the log directory name into the 'Directory Name' text box and click the 'Graph It!'</div>"+
                      "<div>button.</div>"+
		      "<div><img src='dir_name.png'></div><br>"+		      

                      "<div><b>b)</b></div>"+
                      "<div>Click on the 'Choose File' button on next to 'Choose a CSV to upload' and find </div>"+
                      "<div>the CSV file you have previously downloaded from a FieryPerfmon Calculus log </div>"+
                      "<div>directory. Using this option to load the data won't import all of the time-line</div>"+
                      "<div>data you get from using the method above.</div>"+
		      "<div><img src='csv_upload.png'></div>",	    
            height: 1200 
        });
    }

    function set_colors(){
    
    }

    function update_page_display(id, oc, dr, box) {
        if (box == 'top') {
	    INFO_TOP = id+"."+oc+" "+dr;
	    $('#tol_head_top').html('<h2>Tolerance List: '+INFO_TOP+'</h2><hr>');
	} else {
	    INFO_BOT = id+"."+oc+" "+dr;	
	    $('#tol_head_bot').html('<h2>Tolerance List: '+INFO_BOT+'</h2><hr>');	    
	}
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
				    //SERIES_DATA_TOP = JSON.parse("["+str+"]");
				    SERIES_DATA_TOP = JSON.parse(str);
				    len = SERIES_DATA_TOP.length;

				    var start_time = SERIES_DATA_TOP[0];
				    var end_time = SERIES_DATA_TOP[len-1];
	                            $('#time_start_top').html("<div id='top_color' style='background: "+COLOR_0+"'></div>Start Time: " + start_time.substring(9, 28));
			            $('#time_stop_top').html( "<div id='top_color' style='background: "+COLOR_0+"'></div>End Time: " + end_time.substring(9, 28));
                                    $('#time_start_top').css({"visibility":"visible"});
                                    $('#time_stop_top').css({"visibility":"visible"}); 				    
				} else {
				    SERIES_DATA_BOT = JSON.parse(str);
				    len = SERIES_DATA_BOT.length;

				    var start_time = SERIES_DATA_BOT[0];
				    var end_time = SERIES_DATA_BOT[len-1];
	                            $('#time_start_bot').html("<div id='bot_color' style='background: "+COLOR_1+"'></div>Start Time: " + start_time.substring(9, 28));
			            $('#time_stop_bot').html( "<div id='bot_color' style='background: "+COLOR_1+"'></div>End Time: " + end_time.substring(9, 28));	  
                                    $('#time_start_bot').css({"visibility":"visible"});
                                    $('#time_stop_bot').css({"visibility":"visible"}); 
				}
				//console.log(str);
				handle_row_display(0, box);

                                //click the first row...
			        var row_id = "#row0" + box;
		                $(row_id).click(); 

			    }
			});

	            }   
                });
	    }
        });
    
    }

    function isAPIAvailable() {
        // Check for the various File API support.
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            // Great success! All the File APIs are supported.
            return true;
        } else {
            // source: File API availability - http://caniuse.com/#feat=fileapi
            // source: <output> availability - http://html5doctor.com/the-output-element/
            document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
            // 6.0 File API & 13.0 <output>
            document.writeln(' - Google Chrome: 13.0 or later<br />');
            // 3.6 File API & 6.0 <output>
            document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
            // 10.0 File API & 10.0 <output>
            document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
            // ? File API & 5.1 <output>
            document.writeln(' - Safari: Not supported<br />');
            // ? File API & 9.2 <output>
            document.writeln(' - Opera: Not supported');
            return false;
        }
    }

    function handleFileSelect_Bot(evt) {
 
        var files = evt.target.files; // FileList object
        var file = files[0];
        $('#time_start_bot').css({"visibility":"hidden"});
        $('#time_stop_bot').css({"visibility":"hidden"});		
        printTable(file, 'bot');

    }

    function handleFileSelect_Top(evt) {

        var files = evt.target.files; // FileList object
        var file = files[0];
        $('#time_start_top').css({"visibility":"hidden"});
        $('#time_stop_top').css({"visibility":"hidden"});		
        printTable(file, 'top');

    }

    function unsupported_function(evt){
        alert("CSV import is unavailable on this browser.");
    }


    function printTable(file, box) {

        var reader = new FileReader();
        reader.readAsText(file);
        reader.onload = function(event) {
            reader.fileName = file.name;
	    //alert(reader.fileName);
            var csv = event.target.result;
            //alert(csv);
	    
            var data = $.csv.toArrays(csv);
	    //alert(data);
            var arr = series = []; 
	    var html = '';
	    html += '<table>\r\n';
	    var index = 0;
	    var str = "";
	    var start_time = "";
	    var stop_time = "";
	    var first = 0;
            for(var row in data) {
	        if(first == 1) {

		    if(data[row][1] != " ") {
                        str = data[row][0].substring(2);
		        var n = str.indexOf("\\");
		        str = str.substring(n);
			//$line = "<tr class='row_select_".$box."' id='row".$index.$box."'   onclick='start_selected(".$index.", \"".$box."\")'><td id='name".$index.$box."'>".$proc."</td></tr>";
                        html +=   "<tr class='row_select_"+box+"' id='row" + index + box +"' onclick='start_selected("+index+", \""+box+"\");'><td id='name"+ index + box +"'>"+str+"</td></tr>\r\n";
			arr[index] = [data[row]];

		        index++;
		    }
		} else {
		    series = data[row];
		    series.shift();
		    var length = series.length;
		    start_time = series[0].substring(0,19);
		    stop_time = series[length - 1].substring(0,19);
		    //start_time = "00:00:00";
                    //stop_time = "00:00:00";
 
                    for(var i in series){
		        series[i] = "TIME: <b>"+series[i].substring(0,19)+"</b><br>STAT: <b>No Data Available</b>";
		    }

		    first = 1;
		}
            }
	    html += '</table>';

            var length = 0;

	    if( box == 'top' ) {
	       
	        DATA_ARR_TOP = arr;
	        length = DATA_ARR_TOP.length;
	        MAX_PAGE_TOP = Math.floor(length / ROW_SIZE);

		if( MAX_PAGE_TOP <= 0) {
		    MAX_PAGE_TOP = 1;
		}
                INFO_TOP = reader.fileName;
	        $('#time_start_top').html("<div id='top_color' style='background: "+COLOR_0+"'></div>Start Time: "+start_time );
	        $('#time_stop_top').html( "<div id='top_color' style='background: "+COLOR_0+"'></div>End Time: "+stop_time );	  
                $('#time_start_top').css({"visibility":"visible"});
                $('#time_stop_top').css({"visibility":"visible"}); 
                SERIES_DATA_TOP = series;
	    } else {
                DATA_ARR_BOT = arr;
	        length = DATA_ARR_BOT.length;
	        MAX_PAGE_BOT = Math.floor(length / ROW_SIZE);

	        if( MAX_PAGE_BOT <= 0) {
	            MAX_PAGE_BOT = 1;
		}
                INFO_BOT = reader.fileName; 
	        $('#time_start_bot').html("<div id='bot_color' style='background: "+COLOR_1+"'></div>Start Time: " + start_time );
	        $('#time_stop_bot').html( "<div id='bot_color' style='background: "+COLOR_1+"'></div>End Time: " + stop_time );	 
                $('#time_start_bot').css({"visibility":"visible"});
                $('#time_stop_bot').css({"visibility":"visible"});
		SERIES_DATA_BOT = series;
	    }

	    //$('#chart1').html('');
	    var head_id = "#tol_head_"+box;
	    $(head_id).html('<h2>Tolerance List: '+reader.fileName+'</h2><hr>');
	    var list_id = "#list_"+box;
            $(list_id).html(html);
            console.log(html);				
            handle_row_display(0, box);

            //click the first row...
            var row_id = "#row0" + box;
	    $(row_id).click(); 
        };
        reader.onerror = function(){ alert('Unable to read ' + file.fileName); };
    }


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
        //var proc_name = "<h2>Name Coming Soon</h2>";
	var proc_name = "";
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
	    seriesColors: [ COLOR_0 ],
	    title: proc_name, 
            highlighter: {
                show: false,
                sizeAdjust: 14,
                tooltipLocation: 'n',
                tooltipAxes: 'n',
                formatString:'#TRENTLabel# - %s',
                useAxesFormatters: false
            },
	    legend: {
	        labels: [INFO_TOP],
                show: true,
                rendererOptions: {
                    fontSize: '10pt'
                }
	    },
            seriesDefaults: {
                renderer: $.jqplot.FunnelRenderer
            },
	    cursor: {
                zoom:true, 
                looseZoom: true, 
                showTooltip:false, 
                followMouse: true, 
                showTooltipOutsideZoom: false, 
                constrainOutsideZoom: true 
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
            },
	    series: [  ]
	};
        //console.log( SERIES_DATA_TOP[0][157] );
        //console.log( typeof(JSON.stringify(SERIES_DATA_TOP)) );
	//console.log(JSON.stringify(SERIES_DATA_TOP));
	//options.series = [SERIES_DATA_TOP];
        var data_plot = [plot_num_top];
        console.log(plot_num_bot );
        if(plot_num_top.length > 0 && plot_num_bot.length > 0){
	    data_plot = [plot_num_top, plot_num_bot];
	    options.seriesColors = [COLOR_0, COLOR_1];
	    options.legend.labels = [INFO_TOP, INFO_BOT];
	} 

        plot1 = $.jqplot('chart1', data_plot, options);
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
	    update_page_display(id, oc, dir_name, box);
	} else {
	    w2popup.open({
                title   : '<b>No Data Found</b>',
		buttons : '<button onclick="w2popup.close()">Close</button>',		
                body    : "<br><b>ERROR:</b> No FieryPerfmon graphing data was found<br><b>URL: </b>" + url,
		width   : 600 
            });
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


    /******************************************************************
    * Calls a w2popup when a node on the graph is clicked. 
    *****************************************************************/
    $('#chart1').bind('jqplotDataClick', function (ev, seriesIndex, pointIndex, data) {
        var series = "";
        //var arr = data.split(',');

	if (seriesIndex == 0){

	    if(SERIES_DATA_TOP[pointIndex] !== undefined ){
	        series = SERIES_DATA_TOP[pointIndex];
	    } else {
	        series = "No Data Available";
	    }

            w2popup.open({
                title   : '<b>Node Details: '+ INFO_TOP+"</b>",
		buttons : '<button onclick="w2popup.close()">Close</button>',
                body    : "<br><b style='font-size: 14px'>"+INFO_TOP+"</b><br><br>"+series+"<br><div id='top_color' style='background: "+COLOR_0+"'></div>"
            });
	} else {

	    if(SERIES_DATA_BOT[pointIndex] !== undefined ){
	        series = SERIES_DATA_BOT[pointIndex];
	    } else {
	        series = "No Data Available";
	    }
	
            w2popup.open({
                title   : '<b>Node Details: '+INFO_BOT+"</b>",
		buttons : '<button onclick="w2popup.close()">Close</button>',		
                body    : "<br><b style='font-size: 14px'>"+INFO_BOT+"</b><br><br>"+series+"<br><div id='bot_color' style='background: "+COLOR_1+"'></div>"
  
            });
	    
	}

    });

    </script>
	<script class="include" type="text/javascript" src="/dist/jquery.jqplot.js"></script>


        <script class="include" type="text/javascript" src="/dist/plugins/jqplot.cursor.min.js"></script>
        <script class="include" type="text/javascript" src="/dist/plugins/jqplot.highlighter.min.js"></script>
    </div></body><!-- end body -->

</html>

