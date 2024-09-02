<?php

header('Access-Control-Allow-Origin: *');
	// Importing DBConfig.php file.
include 'dbconnect.php';
	 
	$cusId=$_POST['SESSid'];
	$cusProID =$_POST['cuid'];
	$proUserId=$_POST['bprouserid'];
	$catId=$_POST['bcatid'];
	$crtdate=date('y-m-d');
	$moddate=date('y-m-d');
	$status='1';
	$flag='1';
	$proId=$_POST['bprodid'];
	$proSold = '1';
	


	$sql = "Select * from product_bids where cus_id ='.$cusId.' and pro_user_id ='.$proUserId.'";
	
	$check = mysqli_query($con,"Select * from product_bids where cus_id ='$cusId' and pro_user_id ='$proUserId'");

    $check_res = mysqli_fetch_array($check);

	
	if($check_res==""){


		if($cusId !=''){ 
$sqlinsert="insert into product_bids(cus_id,pro_cus_id,pro_user_id,cat_id,crtd_date,modi_date,status,flag,pro_id,pro_sold) values ('$cusId','$cusProID','$proUserId','$catId','$crtdate','$moddate','$status','$flag','$proId','$proSold') ";
		$resu=mysqli_query($con,"insert into product_bids(cus_id,pro_cus_id,pro_user_id,cat_id,crtd_date,modi_date,status,flag,pro_id,pro_sold) values ('$cusId','$cusProID','$proUserId','$catId','$crtdate','$moddate','$status','$flag','$proId','$proSold') ");
		$proUser_update=mysqli_query($con,"UPDATE product_user SET bids_opt='bidsopened.png' Where pro_user_id='$proUserId'");

		if($resu){
				//$todate = date('Y-m-d');
			$getcus = "Select * From customer where cus_userId='$cusId'";
			 //print_r($setimg);
			 $getres = mysqli_query($con,$getcus);
			 while($getfullc = mysqli_fetch_assoc($getres)){
				 $cusnames = $getfullc['cus_name'];
				 //echo $cusnames;
				 //echo $notTitle = $resImg['pro_user_img'];
			}
			//$cusnames = "Arun";
			$getProd = "Select * From product_user where pro_user_id='$proUserId'";
			 //print_r($setimg);
			 $getpres = mysqli_query($con,$getProd);
			 while($respp = mysqli_fetch_assoc($getpres)){
				 $prname = $respp['pro_user_title'];
				 //echo $notTitle = $resImg['pro_user_img'];
			}
			$query = "SELECT * FROM gcm_token where cus_role='0' and cus_uid='$cusProID'";
			$result1 = mysqli_query($con,$query) ;
			$res1 = mysqli_num_rows($result1);
			//echo "THTHTH".($res1)."<br />";
			while($res = mysqli_fetch_array($result1)){
			//echo $res['gcm_tokenid']."<br/>";
			$reg_token =$res['gcm_tokenid'];
			//send_gcm_notify($reg_token, $cusnames, $prname);
			//Raghav Temp stopped bidding Notification
			}
			$json= 1;
		}else {
			$json= 0;
		}
       
		echo json_encode($json);
	}
	}else{
		$json= 2;
		echo json_encode($json);
	}
	
	/*if($check_res==""){
	
    if($cusId !=''){ 
    $resu=mysqli_query($con,"insert into product_bids(cus_id,pro_user_id,cat_id,crtd_date,modi_date,status,flag,pro_id) values ('$cusId','$proUserId','$catId','$crtdate','$moddate','$status','$flag','$proId') ");
	if($resu){
			$json= 1;
		}else {
			$json= 0;
		}
       
	echo json_encode($json);
	}
	}else{
		$json= 2;
		echo json_encode($json);
	}*/
	//echo json_encode($json);
	function send_gcm_notify($reg_id, $cname, $pname) {
	
		//define("GOOGLE_API_KEY", "AIzaSyAUowWoUO2r0x55vbSB7bhJqeO0Y8qWwME");
		//define("GOOGLE_API_KEY", "AAAAuG5Mpls:APA91bFRupmTRiiZ5L_J1cUWmdbyD9bt2cl4i9YEs88mjiuaBbmEFenorrXtyxEMUO3ueDeAWibgDo6m_yii1nC2-WiklyKRIarwi3DgLedZPKl6mu2qfTCerlCvFcQVhjKcEDZGSwLGur-M1orB1--ZwOTDcpPgbA");
		define("GOOGLE_API_KEY", "AIzaSyCUHIRYYF6RoxTx0qZ9KkQCb0L6k7Fsa-w");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "An NGO Needs your Product", "body" => "NGO Name: ".$cname." Product Name:" .$pname ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "notid"),
			'data'						=> array("cuname" =>$cname, "prname"=> $pname),
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
		//echo "<br>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        //echo $result;
    }
 
 
	


 
 

	mysqli_close($con);
?>