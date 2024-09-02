<?php
header('Access-Control-Allow-Origin: *');
		// Importing DBConfig.php file.
    include 'dbconnect.php';
    include 'whatsapp_api.php';

	 function send_sms($mobno,$msg)
   	{
         //For testing
        //echo $msg;
        //$mobno='7200011175';
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    //$msg="Thank you for initiating order with order: $orderid";		  
	    $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg).""; 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        return $response;
    }
    
     function send_gcm_notify($reg_id, $message, $img_url) {
	
		define("GOOGLE_API_KEY", "AIzaSyCUHIRYYF6RoxTx0qZ9KkQCb0L6k7Fsa-w");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "You have got a Thank You Video!", "body" => $message , "tag" => $tag ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "notid" ),
			'data'						=> array("thanksmessage" =>$message),
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
        return $result;
    }
    
	//mail 
	 function send_email($orderdetailarray,$purpose)
    {
        //Mail function
       //print_r(json_encode($orderdetailarray));
       //send_sms($mobno,$purpose.'ID');
       
       
		require("./PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587;
		//$mail->SMTPDebug = 2; 
	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
		$mail->Username = "info@igiver.org";
		$mail->Password = "LJR1DE7OBF3U%2@#"; 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('info@igiver.org'); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Order Details Status from iGiver.Org:Thank you video '.$purpose; 
		$message='Order Details Thank you video iGiver.Org  ';
		$headContent="'Order Initiated from iGiver.Org"; //header
		$mail->Body .='    
			<table cellpadding="0" cellspacing="0" border="0">            
				<tbody>
				<tr><td align="left" valign="top">            
				<table cellpadding="0" cellspacing="0" border="0">
				<tbody>            
				<tr><td align="left" valign="top"></td></tr>
				<tr>
				<td style="font:bold;">Dear Support Partner, Order Initiated from iGiver.Org  </td></tr>
				<tr><td align="left" valign="top">'.$message.'</td>
				</tr>
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">Order Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$orderdetailarray.'</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
			';  
       
        // Sending email
        if($mail->send())
        {
          //
        } 
        else
        {
           // echo 'Unable to send email. Please try again.';
        }
        
    }
	 
	//print_r($_POST);exit;
	$pro_user_id =  $_POST["pro_user_id"];
echo $pro_user_id ;
    $resultoapp =0;
    $cus_phone='';
    $resultoapp=0;
	 if($_SERVER['REQUEST_METHOD']=='POST'){
//echo $pro_user_id;
        //NGO Name
        $sql = "SELECT cus_name  FROM `customer` WHERE `cus_userId`=(SELECT cus_id FROM `product_ngo` WHERE pro_user_id=".$pro_user_id.")";
		//echo $sql;exit;
		$resNgoName = mysqli_query($con,$sql);
		while($resNgoNameArray = mysqli_fetch_array($resNgoName))
            {   $cus_name=$resNgoNameArray['cus_name'];  }
       
        //echo $cus_name."/////";exit;
        //Donor 
        $sql = "SELECT cus_userId,cus_phone,cus_name  FROM `customer` WHERE `cus_userId`=(SELECT sponsor FROM `product_ngo` WHERE pro_user_id=".$pro_user_id.")";
		//echo $sql;
		$res = mysqli_query($con,$sql);
         while($res = mysqli_fetch_array($res))
            {
            	 $cus_userId=$res['cus_userId'];
            	 $cus_phone=$res['cus_phone'];
                 $donor_name=$res['cus_name'];
            	 $messageTxt=$cus_name." thanks you for your kindness. See thanks Video in the app.";
            	 send_sms($cus_phone,$messageTxt);

 //send whatsapp sms to donor
//            	 $sql = "SELECT pay_ref_no,(select thanks_video_link from product_ngo where pro_user_id=wishtreeid) as video_link FROM `donor_retail_orders`  where wishtreeid=".$pro_user_id." and paystatus='1'";
$sql = "SELECT pay_ref_no ,b.thanks_video_link as video_link from donor_retail_orders a,product_ngo b where  paystatus='1' and pro_id=orderid and pro_user_id=".$pro_user_id;
		echo $sql;
		$res = mysqli_query($con,$sql);
         while($res = mysqli_fetch_array($res))
            {
            	 $pay_ref_no=$res['pay_ref_no'];
            	 $video_link=$res['video_link'];
            }           	


//$cus_phone='9841200531';
echo $cus_phone;
echo $donor_name;
echo $pay_ref_no;
echo $video_link;

            	 
            	 send_whatsapp_thankyouvideo($donor_name,$cus_phone,$pay_ref_no,$video_link);


            	 //echo $cus_userId;exit;
            	 $query = "SELECT gcm_tokenid FROM gcm_token where cus_role='0' AND cus_uid = '".$cus_userId."'";
            	 echo $query;
            	 $result1 = mysqli_query($con,$query) ;
            	  while($res1 = mysqli_fetch_array($result1))
                    {
                        $reg_token =$res1['gcm_tokenid'];
                        //echo "TKN::".$reg_token;
                        
            	        send_gcm_notify($reg_token, $messageTxt, $img_url);
                    }
            	 $resultoapp=1 ;    
            }
        
      
    
	


    
    	
    	//Send email to gen ticket
    	//1. Get video link
        $videoLink='';    
        $orderid='';
        $sql = "SELECT pro_id,thanks_video_link FROM `product_ngo` WHERE pro_user_id=".$pro_user_id;
		//echo $sql;exit;
		$resProNgoInfo = mysqli_query($con,$sql);
		while($resProNgoInfoArray = mysqli_fetch_array($resProNgoInfo))
		{   
		    $videoLink=$resProNgoInfoArray['thanks_video_link'];  
		    $orderid=$resProNgoInfoArray['pro_id'];  
		}
    	
    	 $ProNgoInfo[] =array('orderid'=>$orderid,'videoLink'=>$videoLink);
    	 
    	 	 //Send mail to igiver support
        send_email(json_encode($ProNgoInfo),$orderid);
        
     //updating thanks video status is 2 when it is shared by ngo
        $sqlupdate = "UPDATE product_ngo SET thanks_video_status='2' WHERE `pro_user_id` =".$pro_user_id;
		$res = mysqli_query($con,$sqlupdate);

        echo json_encode($resultoapp);
    	mysqli_close($con);
	 }
   
   

?>