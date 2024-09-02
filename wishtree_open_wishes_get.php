<?php
// Importing DBConfig.php file.
include 'dbconnect.php';


//SELECT `pro_user_id`, `cus_id`, `pro_id`, `cat_id`, `pro_user_title`, `pro_user_desc`, `pro_user_img`, `crdt`, `dndt`, `status`, `flag`, `bids_opt`, `ngo_range`, `noti_status`, `sponsor` FROM `product_ngo` WHERE 1

$sql = "select pro_user_id,cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,
flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link from product_ngo 
WHERE cus_id IN (SELECT cus_userId from customer WHERE flag = 1) AND sponsor=''"; 
$res = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($res)){
   
     $cust[] =array('pro_user_id'=>$row[0],'cus_id'=>$row[1],'pro_id'=>$row[2],'cat_id'=>$row[3],'pro_user_title'=>$row[4],'pro_user_desc'=>$row[5],
    'pro_user_img'=>$row[6],'crtd_date'=>$row[7],'modi_date'=>$row[8],'status'=>$row[9],'flag'=>$row[10],'bids_opt'=>$row[11],'ngo_range'=>$row[12],
    'sponsor'=>$row[14],'thanks_video_status'=>$row[15],'thanks_video_link'=>$row[16]);
    
   
   
    
}




echo json_encode($cust);
mysqli_close($con);
?>