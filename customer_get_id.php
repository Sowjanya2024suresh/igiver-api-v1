<?php
// Importing DBConfig.php file.
    include 'dbconnect.php';

$ids =$_GET['id'];
$sql = "Select `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`,`cus_image`,`resident_count` From customer where cus_userId='".$ids."'";
 
$res = mysqli_query($con,$sql);
$result = array();

if($res){
	while($row = mysqli_fetch_array($res)){
		
                  $cus_edit[] =array('cus_id'=>$row[0],'cus_userId'=>$row[1],'cus_name'=>$row[2],'cus_email'=>$row[3],'cus_phone'=>$row[4],'cus_pwd'=>$row[5],'cus_cpwd'=>$row[6],'cus_role'=>$row[7],'crtd_date'=>$row[8],'modi_date'=>$row[9],'status'=>$row[10],'flag'=>$row[11],'ngo_link'=>$row[12],'otp'=>$row[13],'verification_status'=>$row[14],'cus_contact_name'=>$row[15],'cus_address'=>$row[16],'cus_field_of_service'=>$row[17],'cus_image'=>$row[18],'resident_count'=>$row[19]);
}
	
	print_r(json_encode($cus_edit));	
	
}

mysqli_close($con);
 
?>