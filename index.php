<?php
#
#	Written by Oscar Kraemer 22.05.2014
#
function start(){
	if( isset( $_GET['machine'])){
		machineip($_GET['machine']);	
	}elseif( isset( $_GET['m'])){
        	machineip($_GET['m']);
	}elseif( empty( $_POST['machine']) ){
		echo $_SERVER['REMOTE_ADDR'];
	}elseif( isset( $_POST['update']) ){
		if ((file_exists( $_POST['machine'])) and ($_POST['update'] == 'true')){
			updateip($_POST['machine']);
		}else{
			echo "machine does not exist :5 \n";
		}
	}elseif($_POST['machine']){
		machineip($_POST['machine']);
	}else{
		echo "Congratulation you managed to make an request that I did not anticipate :1 \n";
	}
}


function machineip( $machine ){
	if (file_exists( $machine )){
		$mf = fopen($machine,'r');
        	echo fread($mf ,filesize($machine));
        	fclose($mf);
	}else{
		echo "Machine does not exist :2 \n";
	}	
}

	
function updateip ( $machine ){
	$mf = fopen($machine,'r');
	$oldip = fread($mf ,filesize($machine));
	fclose($mf);
       	$newip = $_SERVER['REMOTE_ADDR'];
       	if ( $newip != $oldip and $newip !="" ){
               	$mf = fopen($machine,'w');
               	fwrite($mf , $newip);
               	fclose($mf);
               	$mf = fopen("ipaddr.log", 'a');
               	fwrite($mf,$newip." ".$machine.PHP_EOL);
               	fclose($mf);
               	echo "new ip written \n";
               	$oldip = $newip;
        }
       	else {
               	echo "same ip \n";
        }
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


function getIP($username,$machine){
	$con = conect();
	if (checkUserMachine($username,$machine) == true){
    	$result = mysqli_query($con,"SELECT INET_NTOA(IP) FROM ipHost WHERE username='".$username."' AND hostname='".$hostname."' ORDER BY TimeStamp");        
	    while($row = mysqli_fetch_array($result)){
    	    	echo $row;
        }
	}else{
		echo "Machine and user does not existXX\n";
	}
	return "0";
}

function getLog($username,$machine){
	$con = conect();
	if (checkUserMachine($username,$machine) == true){
    	$result = mysqli_query($con,"SELECT * FROM ipHost ORDER BY TimeStamp");        
	    while($row = mysqli_fetch_array($result)){
    		if ( ($row['username'] == $username ) AND ($row['hostname'] == $machine) ){
    	    	$arr = array('user' => $row['user'], 'text' => $row['text'], 'date' => $row['date'], 'done' => $row['done'],'key' => $row['id']);
	        	array_push($stack, $arr);
        	}
        }
		return ip;
	}else{
		echo "Machine and user does not exist";
	}
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
$hick = getIP("oscar","test");
echo $hick;
start();
?>
