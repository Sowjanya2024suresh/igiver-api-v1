<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "SELECT `servicetype_id`, `servicetype_name`,`image_url` FROM `servicetype` where flag=1 order by servicetype_name";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	$servicetype[] =array('servicetype_id'=>$row[0],'servicetype_name'=>$row[1],'image_url'=>$row[2]);
}
 
print json_encode($servicetype);
 
mysqli_close($con);
 
?>