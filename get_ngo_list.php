<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';
$ids =$_GET['retail_code'];

//echo $ids."ok";

if($ids=='BB'){
  $sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count`,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,d.short_name FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId=d.cus_userid WHERE cus_role=1 AND a.flag = 1 AND wallet_retailer_id !=0 order by RAND()";
  $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
       $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ', ') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
	 $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'servicetypes'=>$filedfor,'lat'=>$row[20],'long'=>$row[21],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'short_name'=>$row[28]);
}
    
}elseif($ids=='ALL')
{
  $sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count`,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,d.short_name FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId= d.cus_userid WHERE cus_role=1 AND a.flag = 1 order by RAND()";
  $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
       $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ', ') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
	 $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'servicetypes'=>$filedfor,'lat'=>$row[20],'long'=>$row[21],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'short_name'=>$row[28]);
}
    
}
else
{
    
    // $sql = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` FROM `customer` WHERE `flag`=1 AND cus_role=1 AND cus_userId IN (SELECT cus_userId FROM `delivery_dist_matrix` WHERE delivery_y_n=1 AND retail_code='$ids')";
  

if (isset($_GET['sku'])) 
{
$sku=$_GET['sku'];
   $sql = "SELECT delivery_place FROM retail_vendor_products where retail_code='$ids' and sku='$sku'";
//echo $sql;
$result = mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
$value = $row[0];
//echo "value".$value;
if($value=="CH" && $ids=="A2B")
{
$sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` ,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,d.short_name FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId=d.cus_userid WHERE a.`flag`=1 AND cus_role=1 AND a.cus_userId IN  (SELECT cus_userId FROM `delivery_dist_matrix_a2b` WHERE delivery_y_n=1 AND retail_code='$ids') order by RAND()";
  //echo $sql;
  $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
      $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ',') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
     
	  $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'lat'=>$row[20],'long'=>$row[21],'servicetypes'=>$filedfor[0],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'short_name'=>$row[28]);
    }
}


else
{


$sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` ,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,d.short_name FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId=d.cus_userid WHERE a.`flag`=1 AND cus_role=1 AND a.cus_userId IN  (SELECT cus_userId FROM `delivery_dist_matrix` WHERE delivery_y_n=1 AND retail_code='$ids') and a.cus_userId in (SELECT cus_userId FROM ngo_detail m where NOT FIND_IN_SET((select category from retail_vendor where retail_code=(SELECT retail_code FROM `retail_vendor_products` where sku='$sku')), cat_not_need)) order by RAND()";
  //echo $sql;
  $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
      $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ',') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
     
	  $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'lat'=>$row[20],'long'=>$row[21],'servicetypes'=>$filedfor[0],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'short_name'=>$row[28]);
    }
}

}


else
{

  $sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` ,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,d.short_name FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId=d.cus_userid WHERE a.`flag`=1 AND cus_role=1 AND a.cus_userId IN  (SELECT cus_userId FROM `delivery_dist_matrix` WHERE delivery_y_n=1 AND retail_code='$ids') order by RAND()";
  //echo $sql;
  $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
      $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ',') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
     
	  $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'lat'=>$row[20],'long'=>$row[21],'servicetypes'=>$filedfor[0],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'short_name'=>$row[28]);
    }
}
    
}


 
echo json_encode($cust);
 
mysqli_close($con);
 
?>