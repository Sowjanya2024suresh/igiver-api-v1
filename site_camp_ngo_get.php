<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$short_name =$_GET['ngo_short_name'];

$sql = "SELECT camp_id,camp_name,camp_photo,camp_url,camp_desc,ngo_id FROM `camp_ngo` a,ngo_detail b where a.status='1' and b.short_name='$short_name' and ngo_id=cus_userid";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	 $cust[] =array('camp_id'=>$row[0],'camp_name'=>$row[1],'camp_photo'=>$row[2],'camp_url'=>$row[3],'camp_desc'=>$row[4],'ngo_id'=>$row[5]);
}
 
echo json_encode($cust);
 
mysqli_close($con);
 
?>