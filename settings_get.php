<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "select * from settings WHERE status = 1";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	 $cust[] =array('id'=>$row[0],'name'=>$row[1],'value'=>$row[2]);
}
 
echo json_encode($cust);
 
mysqli_close($con);
 
?>