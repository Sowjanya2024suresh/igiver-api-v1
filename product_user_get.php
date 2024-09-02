<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "select * from product_user";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	$proUser[] =array('pro_user_id'=>$row[0],'cus_id'=>$row[1],'pro_id'=>$row[2],'cat_id'=>$row[3],'pro_user_title'=>$row[4],'pro_user_desc'=>$row[5],'pro_user_img'=>$row[6],'crdt'=>$row[7],'dndt'=>$row[8],'status'=>$row[9],'flag'=>$row[10],'bids_opt'=>$row[11],'c_id'=>$row[12],'sb_id'=>$row[13]);
}
 
print json_encode($proUser);
 
mysqli_close($con);
 
?>