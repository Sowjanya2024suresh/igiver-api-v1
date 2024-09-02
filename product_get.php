<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "select * from product";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	$prod[] =array('pro_id'=>$row[0],'pro_name'=>$row[1],'cat_id'=>$row[2],'crdt'=>$row[3],'dndt'=>$row[4],'status'=>$row[5],'flag'=>$row[6]);
}
 
print json_encode($prod);
 
mysqli_close($con);
 
?>