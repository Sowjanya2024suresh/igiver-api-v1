<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';
$short_name =$_GET['short_name'];

//echo $ids."ok";


   $sql = "SELECT id,campaign_name,camp_tagline,campaign_desc,retail_vendor,start_date,end_date,sku,target_units,unit_price,beneficiary_id,you_video,banner_image,side_image,pay_link FROM `focus_campaigns` where active='1'and campaign_name='$short_name'";

//echo $sql;
 $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
        
	 $cust[] =array('id'=>$row[0],'campaign_name'=>$row[1],'camp_tagline'=>$row[2],'campaign_desc'=>$row[3],'retail_vendor'=>$row[4],'start_date'=>$row[5],'end_date'=>$row[6],'sku'=>$row[7],'target_units'=>$row[8],'unit_price'=>$row[9],'beneficiary_id'=>$row[10],'you_video'=>$row[11],'banner_image'=>$row[12],'side_image'=>$row[13],'pay_link'=>$row[14]);
}


 
echo json_encode($cust);
 
mysqli_close($con);
 
?>