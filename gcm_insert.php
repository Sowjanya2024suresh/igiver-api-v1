<?php
	// Importing DBConfig.php file.
include 'dbconnect.php';
	 
	$id=$_POST['tokenid'];
	//$name=$_REQUEST['name'];

	$flag1['code']=0;

        $res = mysqli_query($con,"Select * from gcm_token where gcm_tokenid ='".$id."'");
$resss = mysqli_fetch_row($res);

        //$query = "Select * persons where tokenid ='".$id."'";
        //$result = mysqli_query($con, $query);
//print_r($result);exit;

        if($resss==""){
           $r=mysqli_query($con,"insert into gcm_token (cus_uid,cus_role,gcm_tokenid) values ('','0','$id') ");
$flag1['code']=$id;
        }else
		{
			$flag1['code']=$id;
		}
	/**if($r=mysqli_query($con,"insert into persons (tokenid) values ('$id') "))
	{
		$flag1['code']=1;
		echo"hi";
	}***/
	//echo"hi";
	//echo json_encode($flag1);
	//(json_encode($flag1));
	mysqli_close($con);
?>