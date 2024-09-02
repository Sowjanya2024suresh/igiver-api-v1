<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
	
    $name = $_POST['name']; //image name
    $image = $_POST['image']; //image in string format
	
	$ptitle =  $_POST['prodTitle'];
	$pdesc =  $_POST['prodDesc'];
	$pcateg =  $_POST['category'];
	$prod =  $_POST['product'];
	$cusUID = $_POST['cusunid'];
	
	//Raghav For Campaign
	if($_POST['campaignID']!=null)
	{
	    	$campaignID =  $_POST['campaignID'];
	    
	}
	else
	{
	    $campaignID=0;
	}
	if($_POST['SocBuildingID']!=null)
	{
	    	$SocBuildingID =  $_POST['SocBuildingID'];
	    
	}
	else
	{
	    $SocBuildingID=0;
	}

	
	$crtdDate = date('Y-m-d');
	$modDate = date('Y-m-d');
	$status = '1';
	$flage = '1';
	$bidsopt = 'nobids.png';
	$img_name = $name.".jpg";
    //decode the image
    $decodedImage = base64_decode($image);
	//echo $pcateg."caeg"; 
 
    //upload the image
    //file_put_contents("uploads/".$name.".jpg", $decodedImage);  
	file_put_contents("productImage/".$name.".jpg", $decodedImage);
	
	
	/*if($pcateg =='Electronics'){ $pcateg = '1';}elseif($pcateg =='Furniture'){ $pcateg = '2'; }elseif($pcateg =='Sports'){ $pcateg = '3';}
	if($prod =='Mobile'){ $prod = '1';}elseif($prod =='Table'){ $prod = '2'; }elseif($prod =='Bat'){ $prod = '3';}*/
	
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 //$image = $_POST['image'];
	 
	 //require_once('dbConnect.php'); 
	 
	 //$sql = "INSERT INTO images (image) VALUES ('$name')";
	 $sql = "INSERT INTO product_user (cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,flag,bids_opt,c_id,sb_id) VALUES ('$cusUID','$prod','$pcateg','$ptitle','$pdesc','$img_name','$crtdDate','$modDate','$status','$flage','$bidsopt',$campaignID,$SocBuildingID)";
	 
	 
	 $stmt = mysqli_prepare($con,$sql);
	 
	 //mysqli_stmt_bind_param($stmt,"s",$image);
	 mysqli_stmt_execute($stmt);
	 
	 $check = mysqli_stmt_affected_rows($stmt);
	 
	 $last_id = mysqli_insert_id($con);
	 //echo $last_id ;
	 if($check == 1){
	 //echo "Image Uploaded Successfully";
	 echo json_encode(1);
	  
	 
        $setimg = "Select * From product_user where pro_user_id='".$last_id."'"; 
         //print_r($setimg);
         $setres = mysqli_query($con,$setimg);
         while($resImg = mysqli_fetch_assoc($setres)){
             $notImage = $resImg['pro_user_title'];
        	 //echo $notTitle = $resImg['pro_user_img'];
        }
         
        $query = "SELECT * FROM gcm_token where cus_role='1' AND cus_uid != 'NULL' AND cus_uid != ''";
        $result1 = mysqli_query($con,$query) ;
        $res1 = mysqli_num_rows($result1);
        //echo "THTHTH".($res1)."<br />";
        while($res = mysqli_fetch_array($result1)){
        	//echo $res['gcm_tokenid']."<br/>";
        	 $reg_token =$res['gcm_tokenid'];
        	 //send_gcm_notify($reg_token, $notImage, $notTitle);
        	 //Raghav
        }
        
	 }else{
	 //echo "Error Uploading Image";
	 echo "0";
	 }
	 //mysqli_close($con);
	 }else{
	 echo "Error";	 
 }
 //echo json_encode($json);
 
 	//$todate = date('Y-m-d');
 	//echo "123";
 
 //send_gcm_notify("fA09nAMTzD8:APA91bEybC9PVlzCLN8av8KqAWWIYjoyirQKXv00p5hT7NH9A4JqBB_UzlmhWtC8S1PaaASyz9n-nSQ4wCdstjireiSDdaAoiPk-bw2VdVqfK0VZe3eg2oG-4uWzhoAlZXVYEVoOR5mD", "test", "IMG_1569917118.jpg");
 
 function send_gcm_notify($reg_id, $message, $img_url) {
	
		//define("GOOGLE_API_KEY", "AIzaSyDn5cmOSNRLrvkQkfM5faJGZpOUpSOTnDg");
		//define("GOOGLE_API_KEY", "AIzaSyAByC3TKtLp7Xkcw9SCYyuwcO5R5ec_XwU");
		//define("GOOGLE_API_KEY", "AAAAlR-kamU:APA91bGiLPeWqW4kWCCHxinwYjDUqkdpYSclNDJjYGlwtK7C2Q1KLr6E6oBGMUU6mT4SZS7w1Eb_ZpJvAcdvsJYepOEp3bDaGrjO6aaoqXEwwZhKLrm4VHcMHwfpm8iz94aDKHfseyPSnmXOADWjFl-bJLhgm3Brew");
		define("GOOGLE_API_KEY", "AIzaSyA6GfHjmq6v_3s-wikqMs1gf075eYMeUw8");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "NGO New Product Available", "body" => "Product Name: ".$message , "tag" => $tag ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "noti1" ),
			'data'						=> array("message" =>$message, "image"=> $img_url),
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
 
 
	


	/*define("GOOGLE_API_KEY", "AIzaSyDn5cmOSNRLrvkQkfM5faJGZpOUpSOTnDg");
    define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
 //Getting api key 
 $api_key = "AIzaSyDn5cmOSNRLrvkQkfM5faJGZpOUpSOTnDg"; 
 
 //Getting registration token we have to make it as array 
 //$reg_token = array($_POST['regtoken']);
 
 //Getting the message 
 $message =  $notTitle;
 //echo $message;

 //Creating a message array 
 $msg = array
 (
 'message' => $message,
 'imageLink' => $notImage,
 'title' => 'Message from Simplified Coding',
 'subtitle' => 'Android Push Notification using GCM Demo',
 'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
 'vibrate' => 1,
 'sound' => 1,
 'largeIcon' => 'large_icon',
 'smallIcon' => 'small_icon'
 );
 //echo(count($res));
 //Creating a new array fileds and adding the msg array and registration token array here 

 $fields = array
 (
 'registration_ids' =>  array($reg_token),
 'data' => $msg
 );

 //Adding the api key in one more array header 
 /*$headers = array
 (
 'Authorization: key='.$api_key,
 'Content-Type: application/json'
 ); */
 /*$headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
 
 //Using curl to perform http request 
 $ch = curl_init();
 curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
 curl_setopt( $ch,CURLOPT_POST, true );
 curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
 curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
 curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
 curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
 
 //Getting the result 
 $result = curl_exec($ch);
 curl_close($ch);
 
 echo $result;
 
 //Decoding json from result 
 $ress = json_decode($result);
 

 
 //Getting value from success 
 $flag = $ress->success;
 //echo $flag; exit;
 //if success is 1 means message is sent 
 if($flag == 1){
 //Redirecting back to our form with a request success 
 echo "success";
 //header('Location: index.php?success');
 }else{
 //Redirecting back to our form with a request failure 
 echo "failure";
 //header('Location: index.php?failure');
 }
}*/


?>