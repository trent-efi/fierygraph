<?php
$action = $_POST['function'];

switch($action) {
    case 'init_page': $id = $_POST['id']; $oc = $_POST['oc']; $dr = $_POST['dr']; $size = $_POST['size']; $box = $_POST['box']; echo init_page($id, $oc, $dr, $size, $box);  break;
    //case 'get_data_by_index': $index = $_POST['index']; echo get_data_by_index($index); break;
    case 'check_url': $url = $_POST['url']; echo check_url($url); break;
    case 'get_data_arr' : $id = $_POST['id']; $oc = $_POST['oc']; $dr = $_POST['dr']; echo get_data_arr($id, $oc, $dr); break;
    case 'get_time_line':  $id = $_POST['id']; $oc = $_POST['oc']; $dr = $_POST['dr']; $box = $_POST['box']; echo get_time_line($id, $oc, $dr, $box); break;
    default: break;
}

///////////////////////////////////////////////////////////////////////////////
// Initial function called during the start of the page:
///////////////////////////////////////////////////////////////////////////////

/**************************************
 * Initialize the page. Sets list of
 * proceses and adds them to a 
 * container to referance later.
 *************************************/
function init_page($id, $oc, $dr, $size, $box){

    //Example:
    //\\C3-763642I1-GAL\Process(Fiery)\Thread Count
    
    $index = 0;

    $list_all = get_all_procs($id, $oc, $dr);

    $list = "<table>";
    ///////////////////////////////////////////////////////////////////////////
    // Lists all the processes from the tolerance file...
    ///////////////////////////////////////////////////////////////////////////
    //Generate list of process in tolerance file...
    //Find the data for each tolreance and store in a global array...
    /*foreach($list_tol as $tol) {
        //echo var_dump($tol);
        if ( !empty($tol) ) {
            foreach($list_all as $all[0]) {
	        //echo "all[0]: ".$all[0][0]."<br>";
	        if ( !empty($all[0]) ) {
		    $proc = substr($all[0][0], 2);//gets rid of first two '\' chars
                    $pos = strpos($proc, '\\');
		    $proc = substr($proc, $pos);

                    $tol = preg_replace( '/[^[:print:]]/', '',$tol);
                    $proc = preg_replace( '/[^[:print:]]/', '',$proc);		    
		    if($tol == $proc) {
			$line = "<tr class='row_select' id='row".$index."' onclick='start_selected(".$index.")'><td id='name".$index."'>".$proc."</td></tr>";

			$list = $list.$line;
		        $data_arr[] = $all;
			$index++;			
			break;
		    }
	        }
	    }
	}
    }*/
    ///////////////////////////////////////////////////////////////////////////
    // Lists all of the processes reguardless of tolerance file...
    ///////////////////////////////////////////////////////////////////////////
    $first = 0;
    $page = 0;
    foreach($list_all as $all[0]){
        if($first != 0){
	    if($all[0][1] != " ") {
	        $proc = substr($all[0][0], 2);//gets rid of first two '\' chars
                $pos = strpos($proc, '\\');
	        $proc = substr($proc, $pos);
                $proc = preg_replace( '/[^[:print:]]/', '',$proc);
                $line = "<tr class='row_select_".$box."' id='row".$index.$box."' onclick='start_selected(".$index.", \"".$box."\")'><td id='name".$index.$box."'>".$proc."</td></tr>";
	        $list = $list.$line;
                $data_arr[] = $all;
	        $proc_arr[] = $proc;
	        $index++;	
	    }
	} else {
	    $first = 1;
	}
    }

    $extra_rows = $index % $size;
    $extra_rows = $size - $extra_rows;
    $i = 0;

    while($i < $extra_rows){
	$list = $list."<tr class='row_select' id='row".$index."'><td></td></tr>";
	$index++;
        $i++;	
    }

    ///////////////////////////////////////////////////////////////////////////
    $list = $list."</table>";

    return $list;
}//end init_page()

/**************************************
 * Parse FieryPerfmon_1.csv into 
 * an array
 *************************************/
function get_all_procs($id, $oc, $dr) {

    //Data files:
    //http://calculus-logs.efi.internal/logs/763642.t1/FieryPerfmon_1/FieryPerfmon_1.csv //rows
    //http://calculus-logs.efi.internal/logs/763642.t1/FieryPerfmon_1/FieryPerfmon.csv  //columns

    $url = "http://calculus-logs.efi.internal/logs/".$id.".".$oc."/".$dr."/FieryPerfmon_1.csv";
    $data = file_get_contents($url);

    if (empty($data)) {
        return "BAD INPUT: ".$id."<br>";
    }

    $rows = explode("\n",$data);
    $s = array();
   
    foreach($rows as $row) {
        $s[] = str_getcsv($row);
    }
    //echo var_dump($s);

    return $s;
}//end get_all_procs()



function get_data_arr($id, $oc, $dr){
    $data_arr = array();

    $list_all = get_all_procs($id, $oc, $dr);

    ///////////////////////////////////////////////////////////////////////////
    // Lists all of the processes reguardless of tolerance file...
    ///////////////////////////////////////////////////////////////////////////
    $first = 0;
    foreach($list_all as $all[0]){
        
        if($first != 0){
	    if($all[0][1] != " ") {
                $data_arr[] = $all;
	    }
	} else {
	    $first = 1;
	}
    }
    //echo "<script>console.log('in PHPH');<script>";
    return json_encode($data_arr);
}//end get_data_arr()

/**************************************
 * Checks if a valid FieryPerfmon url
 * is passed in as the argument.
 *************************************/
function check_url($url){

    $data = file_get_contents($url);

    if (empty($data)) {
        return "false";
    } else {
        return "true";
    }    
}

function get_time_line($id, $oc, $dr, $box) {
    //http://calculus-logs.efi.internal/logs/783145.t0/FieryPerfmon_1/FieryPerfmon_Report.csv

    //GET the start and end times from FieryPerfmon_1.csv
    $url = "http://calculus-logs.efi.internal/logs/".$id.".".$oc."/".$dr."/FieryPerfmon_1.csv";
    $data = file_get_contents($url);

    if (empty($data)) {
        return "BAD INPUT: ".$id."<br>";
    }

    $rows = explode("\n",$data);

    //Fill an array of date times from FieryPerfmon_1.csv 
    $foo = array();
    $foo = str_getcsv($rows[0]);
    array_shift($foo); //shift array to the left; gets rid of column name: "(PDH-CSV 4.0) (Pacific Daylight Time)(420)"

    //echo var_dump($foo);
    
    //GET all of the testlog.txt time line from Calculus
    $url = "http://calculus-logs.efi.internal/logs/".$id.".".$oc."/testlog.txt";
    $data = file_get_contents($url);

    if (empty($data)) {
        return "BAD INPUT: ".$id."<br>";
    }

    $rows = explode("\n",$data);
    $log  = array();
    $temp = array();

    $i = 0;
    $index = 0;
    $str = "";
    $test_name = "Initialization";
    //Trim and load data from testlog.txt
    foreach($rows as $row) {

        if($i > 1){
	    $temp = explode(" : ", $row);
	    $str = $temp[3];

            if(strpos($str, 'finished running test' ) !== false){
	        $log[] = $temp[0]." : ".$temp[3];
	        $test_name = $temp[3];
	    } elseif(strpos($str, 'running test' ) !== false){
	        $log[] = $temp[0]." : ".$temp[3];
	        $test_name = $temp[3];	        
	    } elseif($temp[0] != ""){
	        $log[] = $temp[0]." : ".$test_name;
	    }
	} else {
	    $i = $i + 1;
	}
    }

    $log_set = array();
    $i = 0;
    $date_prev = "";
    $date_curr = "";


    //Clean up the repeated date times...
    foreach($log as $log_row){
        $log_temp = explode(" : ", $log_row);
        if($i > 0){
            	
            $date_curr = $log_temp[0];

	    if(strcmp(  $date_prev, $date_curr ) != 0){
	        $i = $i + 1;
	        $log_set[] = $log_row;
	    }
 
            $date_prev = $date_curr;

	} else {
	    $date_prev = $log_temp[0];
	    $log_set[] = $log_row;
	    $i = $i + 1;
	}
    }

    //START filling the time array with the data from foo and log...
    $time_line = array();
    
    $i = 0;
    $date_prev = "";
    $date_curr = "";


    foreach($log_set as $date_str) {
        echo $date_str."\n";
        //get the next date from the log set...        
	//$date_log = explode(" : ", $date_str);
	//$date_curr = new DateTime($date_log);

	//get the next date in foo..
	//$date_ticks = substr( $foo[i], 0, 19 );
	//$date_cmp = new DateTime($date_tickmark);

        //$i = $i + 1;

        //echo "\nTICK".$date_tickmark."\n";
        //echo "LOGG".$date_logfile[0]."\n";
	
       
        //echo $date_curr->format('Y-m-d H:i:s')."\n";     
	//if($date_curr < $date_cmp){
	//    echo "curr: ".$date_curr->format('Y-m-d H:i:s')." < cmp: ".$date_cmp->format('Y-m-d H:i:s')."\n";
	//} else {
	//    echo "curr: ".$date_curr->format('Y-m-d H:i:s')." >= cmp: ".$date_cmp->format('Y-m-d H:i:s')."\n";

	//}
	/*while($date_curr->format('Y-m-d H:i:s') < $date_cmp->format('Y-m-d H:i:s') ) {
            $i = $i + 1;
	    $date_logfile = explode(" : ", $log_set[$i]); 
	    $date_cmp = new DateTime($date_logfile[0]);
	}*/
        
	//$time_line[] = substr( $date_str, 0, 19 );
	//$time_line[] = $date_tickmark." : ".$date_logfile[1];
	//$i = $i + 1;
    }
    //"Y-m-d H:i:s"
    //$date = new DateTime('2000-01-01');


    //echo var_dump($log_set);
    //echo var_dump($time_line);

    return $time_line;
}

?>
