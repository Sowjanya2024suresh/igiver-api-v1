<?php
// Importing DBConfig.php file.
    include 'dbconnect.php';

$ids =$_GET['id'];
$sql = "Select  `cus_userId`,`reminderid` From customer where cus_userId='".$ids."'";
 
$res = mysqli_query($con,$sql);
$result = array();

if($res){
	while($row = mysqli_fetch_array($res)){
		
                  $cus_edit[] =array('cus_userId'=>$row[0],'reminderid'=>$row[1]);
}
	
	print_r(json_encode($cus_edit));	
	
}

mysqli_close($con);
 
?>