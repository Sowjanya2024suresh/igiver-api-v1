<?php
		// Importing DBConfig.php file.
include 'dbconnect.php';
	 
	 
	$cusuid = $_POST['cuid'];
	
	$cusName=$_POST['ename'];
	$cusEmail=$_POST['eemail'];
	$cusPhone=$_POST['epone'];
	//$cusCPwd=$_POST['rpwd'];
	$crtdate=date('y-m-d');
	$moddate=date('y-m-d');
	$status='1';
	$flag='1';
       
	   //echo $cusName."dsda";
	   $sql = "UPDATE customer SET cus_name='$cusName',cus_email='$cusEmail',cus_phone='$cusPhone' WHERE cus_userId='$cusuid'";
		//echo $sql;
		$res = mysqli_query($con,$sql);
           //$r=mysqli_query($con,"UPDATE customer
        //SET cus_name=$cusName,cus_email=$cusEmail,cus_phone=$cusPhone WHERE cus_userId=$cusuid");
		if($res){
			$json= 1;
		}else {
			$json= 0;
		}

//echo $r;
	echo json_encode($json);
	mysqli_close($con);
?>