<?php
#
#	Written by Oscar Kraemer 22.05.2014
#
function start(){
	$out = "not set";
	if( isset( $_GET['machine'])){
		$out = getIP($_GET['machine']);	
	}elseif( isset( $_GET['m'])){
        $out = getIP($_GET['m']);
	}elseif( empty( $_POST['machine']) ){
		$out = $_SERVER['REMOTE_ADDR'];
	}elseif( isset( $_POST['update']) ){	#TODO update
		$out = updateip($_POST['machine']);
	}elseif($_POST['machine']){
		$out = getIP($_POST['machine']);
	}else{
		echo "Congratulation you managed to make an request that I did not anticipate :1 \n";
	}
	echo $out;
}

function updateip($machine){
	$old = getIP($machine);
	$new = $_SERVER['REMOTE_ADDR'];
	if ($old == false){
		return "Does not exist";
	}elseif($new == $old){
		return "Same ip";
	}else{
		$con = conect();
		$result = mysqli_query($con, "UPDATE ipHost SET IP=(INET_ATON('".$new."')) WHERE hostname='".$machine."';");
		$out = updateLog($machine, $new);
		return $out;
	}
	
}


	
function updateLog ( $machine, $new ){
	$mf = fopen("ipaddr.log", 'a');
	fwrite($mf,$newip." ".$machine.PHP_EOL);
	fclose($mf);
	return "log Update";
}


function CheckUserMachine($username,$machine){
	$con = conect();
	$result = mysqli_query($con,"SELECT * FROM ipUser");
	$stack = array();
	while($row = mysqli_fetch_array($result)){
    	if (($row['username'] == $username ) AND ( $row['hostname'] == $machine) ){
    		return true;
    	}
    }
    return false;
}


function getIP($machine){
	$con = conect();
    $result = mysqli_query($con,"SELECT hostname, INET_NTOA(IP) FROM ipHost");        
	while($row = mysqli_fetch_array($result)){
	   	if ($row['hostname'] == $machine){
        		return $row["INET_NTOA(IP)"];
       	}
    }
	return false;
}


function updateMysql($username,$machine,$ip){
	$con = conect();
	if (checkUserMachine($username,$machine) == true){
		$result = mysqli_query($con,"SELECT * FROM ipUser INTO ipHost values('".$username."','".$machine."',INET_ATON('".$ip."'),TIMESTAMP)");        
 	   echo $result;
	}
}

function conect(){
	//conection=mysqli_connect("127.0.0.1","account","passswd","db");
	$conection=mysqli_connect("127.0.0.1","***REMOVED***","***REMOVED***","***REMOVED***");

	if (mysqli_connect_errno($conection))
    {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	return $conection;
}
start();
?>
