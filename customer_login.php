<?php
	// Importing DBConfig.php file.
include 'dbconnect.php';
 
 function generateRandomString($length = 2) {
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$username = $_POST['username'];
$password = $_POST['password'];
//$username = "sharecare@gmail.com";
//$password = "welcome123";
$ctks = $_POST['custknid'];
$randa = generateRandomString();
$sql = "select * from customer where cus_email='$username' and cus_cpwd='$password'";
//$sql = "select * from customer where cus_email='arun@lokas.info' and cus_cpwd='arun1234'"; 
$res = mysqli_query($con,$sql);
 
while($check = mysqli_fetch_array($res)){
	$data['unid'] = $check['cus_userId'];
	$data['unrole'] = $check['cus_role'];
	$data['usrname'] = $check['cus_name'];
//	print_r($unid);
}
 //print_r($unid);
if(isset($data['unid'])){
//echo 'success';
//$json['success'] = 1;
//echo json_encode($unid);
//echo json_encode($ctks);
$checktkn = mysqli_query($con,"Select * from gcm_token where gcm_tokenid ='".$ctks."'");
$check_restkc = mysqli_fetch_array($checktkn);
//print_r($check_restkc);
//if($check_restkc['cus_uid'] ==""){
	$sql3 = "UPDATE gcm_token SET cus_uid='".$data['unid']."',cus_role='".$data['unrole']."' WHERE gcm_tokenid ='".$ctks."'";
	$res3 = mysqli_query($con,$sql3);
	//echo 'success';
//}
$echecktkn = mysqli_query($con,"Select cus_uid from gcm_token where cus_uid ='".$data['unid']."'");
$echeck_restkc = mysqli_fetch_array($echecktkn);
$useidD = $unid.''.$randa;
if($echeck_restkc !=""){
	$sql4 = "UPDATE gcm_token SET cus_uid='".$useidD."' WHERE cus_uid='".$data['unid']."' and gcm_tokenid !='".$ctks."'";
	$res4 = mysqli_query($con,$sql4);
}
echo json_encode($data);
}else{
//echo 'failure';
//$json['success'] = 0;
//echo json_encode($data);
}
 //echo json_encode($json);
mysqli_close($con);
?>