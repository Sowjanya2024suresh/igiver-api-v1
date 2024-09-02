<?php

// Importing DBConfig.php file.
include 'dbconnect.php';
 
$tableName = $_POST['tableName']; //table name
$uniqueFields = $_POST['uniqueField']; //Primarykey field  
$uniqueValues =  $_POST['uniqueValue']; //Primarykey value
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$query = "DELETE FROM $tableName WHERE $uniqueFields = $uniqueValues";
		$result = mysqli_query($con,$query);
			if($result){

				echo 1;
			} else {

				echo 0;
			} 
	}else{
		
		echo 0;
	}
 
mysqli_close($con);
 
?>