<?php
		// Importing DBConfig.php file.
include 'dbconnect.php';
	 
	 
	$id = $_POST['id'];
	
	$flag=$_POST['flag'];

       
	   //echo $cusName."dsda";
	   $sql = "UPDATE event SET flag='$flag' WHERE eid='$id'";
	
		$res = mysqli_query($con,$sql);
       
		if($res){
			$json= 1;
		}else {
			$json= 0;
		}

//echo $r;
	echo json_encode($json);
	mysqli_close($con);
?>