<?php
	// Importing DBConfig.php file.
include 'dbconnect.php';
	 

$cusuid = $_GET['id'];

//echo $cusuid."dsd"; 

$sql = "select * from customer where cus_userId='".$cusuid."'";
//print_r($sql);
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('cus_id'=>$row[0],
'cus_userId'=>$row[1],
'cus_name'=>$row[2],
'cus_email'=>$row[3],
'cus_phone'=>$row[4]
));
}
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>