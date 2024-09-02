<?php
		// Importing DBConfig.php file.
include 'dbconnect.php';
	 
	//print_r($_POST);
	$pro_user_id =  $_POST["pro_user_id"];
	$thanks_video_status = $_POST['thanks_video_status'];
	$thanks_video_link = $_POST['thanks_video_link'];
	
	 if($_SERVER['REQUEST_METHOD']=='POST'){

        $sql = "UPDATE product_ngo SET thanks_video_status=".$thanks_video_status.",thanks_video_link='".$thanks_video_link."' WHERE `pro_user_id` =".$pro_user_id;
		//echo $sql;
		$res = mysqli_query($con,$sql);
        
		if($res){
		$json['success'] = 1;
        }else {
            $json['success'] = 0;
        }   

    	//echo json_encode($json);
    	echo json_encode($json);
	mysqli_close($con);
    	
	 }
   

?>