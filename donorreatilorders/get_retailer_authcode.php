<?php
// Importing DBConfig.php file.
    include '../dbconnect.php';

$ids =$_GET['id'];
$sql = "SELECT  `authcode`, `retail_code` FROM `retail_vendor` WHERE `id`='".$ids."'";
 
$res = mysqli_query($con,$sql);
$result = array();

if($res){
	while($row = mysqli_fetch_array($res)){
		
                  $retail_data[] =array('authcode'=>$row[0],'retail_code'=>$row[1]);
}
	
	print_r(json_encode($retail_data));	
	
}

mysqli_close($con);
 
?>