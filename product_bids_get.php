<?php
		// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "select * from product_bids";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	 $cust[] =array('pro_bid_id'=>$row[0],'cus_id'=>$row[1],'pro_cus_id'=>$row[2],'pro_user_id'=>$row[3],'cat_id'=>$row[4],'crtd_date'=>$row[5],'modi_date'=>$row[6],'status'=>$row[7],'flag'=>$row[8],'pro_id'=>$row[9],'pro_sold'=>$row[10],'pro_awarded'=>$row[11]);
}
 
echo json_encode($cust);
 
mysqli_close($con); 
 
?>