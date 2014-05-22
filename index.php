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
start();
?>
