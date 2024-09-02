<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
//$sql = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` FROM customer WHERE flag = 1 order by `cus_name` ";
$sql = "SELECT `cus_id`, a.`cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, a.`modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count`,b.short_name FROM customer a left join ngo_detail b on a.cus_userId=b.cus_userid WHERE flag = 1 ORDER BY `a`.`cus_id` DESC";


$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	 $cust[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19],'short_name'=>$row[20]);
}
 
echo json_encode($cust);
 
mysqli_close($con);
 
?>