<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<title>FieryPerfmon Graph Portal:</title>  
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
                <!--/////////////////////////-->
                <div class="data_box">
		    <div id="tol_head"><h2>Tolerance List:</h2><hr></div>
	            <div id="list1">LIST1</div>
		    <div id="footer_base">
                        <div>
			    <img id="prev_next" src="/fierygraph/prev.png"/>
			    <img id="prev_next" src="/fierygraph/next.png"/>
			</div>
			<hr>
			<div id="foot_box">
                            <div>Calculus ID:
                                <input id="id_box" type="text" name="cal_id" placeholder="Ex: 999999.t0">
				Directory Name:
				<input id="dir_box" type="text" name="dir_name" placeholder="Ex: FieryPerfmon_1">
				<button id="calc_btn" onclick="alert('HELLO')">Graph It!</button>
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
                <div class="data_box">
		    <div id="tol_head"><h2>Tolerance List:</h2><hr></div>
	            <div id="list1">LIST1</div>
		    <div id="footer_base">
                        <div>
			    <img id="prev_next" src="/fierygraph/prev.png"/>
			    <img id="prev_next" src="/fierygraph/next.png"/>
			</div>
			<hr>
			<div id="foot_box">
                            <div>Calculus ID:
                                <input id="id_box" type="text" name="cal_id" placeholder="Ex: 999999.t0">
				Directory Name:
				<input id="dir_box" type="text" name="dir_name" placeholder="Ex: FieryPerfmon_1">
				<button id="calc_btn" onclick="alert('HELLO')">Graph It!</button>
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
    </body>
<script class="code" type="text/javascript">
$(document).ready(function(){
  var plot1 = $.jqplot ('chart1', [[3,7,9,1,5,3,8,2,5]]);
});
</script>

</html>

