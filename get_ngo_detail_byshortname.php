<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';
$short_name =$_GET['ngo_short_name'];

//echo $ids."ok";


   $sql = "SELECT a.`cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, a.`status`, a.`flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count`,d.latitude,d.longitude,d.since,d.about,d.vision_mission,d.image_url,d.video_url,d.banner_url,(SELECT id FROM `focus_campaigns` where active='1' and beneficiary_id=a.`cus_userId`) as camp_id,(SELECT campaign_name FROM `focus_campaigns` where active='1' and beneficiary_id=a.`cus_userId`)as camp_name,(SELECT campaign_desc FROM `focus_campaigns` where active='1' and beneficiary_id=a.`cus_userId`) as camp_desc, (SELECT camp_tagline FROM `focus_campaigns` where active='1' and beneficiary_id=a.`cus_userId`) as camp_tagline FROM customer a LEFT JOIN customer_location b on a.cus_id=b.cus_id LEFT JOIN ngo_detail d on a.cus_userId=d.cus_userid WHERE cus_role=1 AND a.flag = 1 AND d.short_name='$short_name'";
 $res = mysqli_query($con,$sql);
 
  $result = array();
 
  while($row = mysqli_fetch_array($res)){
        $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ', ') as servicetypes from servicetype where servicetype_id IN (".$row[17].")"));
	 $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'servicetypes'=>$filedfor,'lat'=>$row[20],'long'=>$row[21],'since'=>$row[22],'about'=>$row[23],'vision_mission'=>$row[24],'image_url'=>$row[25],'video_url'=>$row[26],'banner_url'=>$row[27],'camp_id'=>$row[28],'camp_name'=>$row[29],'camp_desc'=>$row[30], 'camp_tagline'=>$row[31]);
}


 
echo json_encode($cust);
 
mysqli_close($con);
 
?>