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
	}elseif( $_POST['update'] == "true" ){
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
		$result = query("UPDATE ipHost SET IP=(INET_ATON('".$new."')) WHERE hostname='".$machine."';");
		$out = updateLog($machine, $new);
		return $out;
	}
}

function updateLog ( $machine, $new ){
	$mf = fopen("ipaddr.log", 'a');
	fwrite($mf,$new." ".$machine.PHP_EOL);
	fclose($mf);
	return "log Update";
}

function getIP($machine){
    $result = query("SELECT hostname, INET_NTOA(IP) FROM ipHost");        
	while($row = mysqli_fetch_array($result)){
	   	if ($row['hostname'] == $machine){
        	return $row["INET_NTOA(IP)"];
       	}
    }
	return false;
}

function query($query){
		require "db.php";
	//conection=mysqli_connect("127.0.0.1","account","passswd","db");
	$conection=mysqli_connect($db_ip,$db_user,$db_passwd,$db_db);
	if (mysqli_connect_errno($conection))
    {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
    $result = mysqli_query($conection, $query);        
	mysqli_close($conection);
	return $result;
}
start();
?>
