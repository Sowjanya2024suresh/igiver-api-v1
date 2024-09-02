<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");

	// Importing DBConfig.php file.
include '../dbconnect.php';
 
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
if($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
   $_POST = json_decode(file_get_contents('php://input'),true); 
}
// print_r($_POST);
$number = $_POST['number'];
//$username = "sharecare@gmail.com";
//$password = "welcome123";
$ctks = $_POST['custknid'];
$randa = generateRandomString();
$sql = "select * from customer where cus_phone='$number' and cus_role=0";
//$sql = "select * from customer where cus_email='arun@lokas.info' and cus_cpwd='arun1234'"; 
$res = mysqli_query($con,$sql);

 if(mysqli_num_rows($res)>0){
while($check = mysqli_fetch_array($res)){
    	$data['id'] = $check['cus_id'];
	$data['unid'] = $check['cus_userId'];
	$data['unrole'] = $check['cus_role'];
	$data['usrname'] = $check['cus_name'];
	$data['usremail'] = $check['cus_email'];
	$data['usrmobile'] = $check['cus_phone'];
	$data['verification_status'] = $check['verification_status'];
	$data['success'] = 1;
//	print_r($unid);
}
 // print_r($data);
if(isset($data['unid'])){

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
 $data['success'] = 0;
 $data['msg'] ="User Not Found";
 echo json_encode($data);   
}
}else{
//echo 'failure';
 $json['success'] = 0;
 echo json_encode($json);
}
 //echo json_encode($json);
mysqli_close($con);
?>