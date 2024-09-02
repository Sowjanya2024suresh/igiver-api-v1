<?php
    // Importing DBConfig.php file.
    include 'dbconnect.php';
    
    
    
    $proUserId =  $_POST['proUserId'];
    $sponsor = $_POST['sponsor'];
    if($_SERVER['REQUEST_METHOD']=='POST'){

            //Get the last inserted values 
            $sql = "UPDATE product_ngo SET sponsor = '$sponsor' WHERE pro_user_id = $proUserId";
            $sponSql = mysqli_query($con,$sql); 
            
            $ngoName = "Select cus_name From customer where cus_userId =(select cus_id from product_ngo where pro_user_id=".$proUserId." )";
            $ngoNames = mysqli_query($con,$ngoName); 
            $nameNGO = mysqli_fetch_assoc($ngoNames);
            $ngoCus = $nameNGO['cus_name'];
            
            $donNameSQL = "Select cus_name From customer where cus_userId ='$sponsor'";
            $donNames = mysqli_query($con,$donNameSQL); 
            $donNamelist = mysqli_fetch_assoc($donNames);
            $OnedonName = $donNamelist['cus_name'];
            
            $setimg = "Select * From product_ngo where pro_user_id='".$proUserId."'";
            $setres = mysqli_query($con,$setimg); 
            $resImg = mysqli_fetch_assoc($setres);
            if($resImg){
                $notTitle = $resImg['pro_user_title'];
                $notImage = $resImg['pro_user_img'];
                $ngoId    = $resImg['cus_id'];            

                    //Get all the NGO tokens
                    $query = "SELECT * FROM gcm_token where cus_uid='$ngoId'";
                    $result1 = mysqli_query($con,$query) ;
                    $res1 = mysqli_num_rows($result1); 
                        if($res1 > 0){ 
                            while($res = mysqli_fetch_array($result1)){
                                $reg_token =$res['gcm_tokenid'];
                                //Notification send function
                                @send_gcm_notify($reg_token, $notTitle, $notImage, $ngoCus);  
                                @send_sms_admin($sponsor,$ngoId,$ngoCus,$OnedonName);
                                send_email_support($proUserId,$donorid, $ngoid,$ngoCus,$OnedonName);
                        }             
 
                }
                echo json_encode(1);
            } 
        }else{
             echo "Error";	 
        }          
    	
    	
function send_sms_admin($donorid, $ngoid,$ngoCus,$OnedonName)
{
    
    $mob = "7200011175";
    $user_id = 'nmch-igiver';
    $password = 'igiver12';
    $sendid = 'iGIVER';
    $msg=$OnedonName."-".$donorid." has Sponsored a Product for ".$ngoCus."-".$ngoid;		  
    $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mob."&source=iGIVER&message=".urlencode($msg).""; 
	//echo $url;
	//exit;  
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$response = curl_exec($ch); 
	    //print_r($response);		
		// exit; 
		
	$mob2="9168475596";
	 $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mob2."&source=iGIVER&message=".urlencode($msg).""; 
	//echo $url;
	//exit;  
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$response = curl_exec($ch);
	curl_close($ch);

}
 //Function for notification send to NGO 
 function send_gcm_notify($reg_id, $message='', $img_url='', $ngoCus='') { 
 		define("GOOGLE_API_KEY", "AIzaSyA6GfHjmq6v_3s-wikqMs1gf075eYMeUw8"); 
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
		
	    $wishbud = "A bud from the wish tree blossoms into a flower: ".$ngoCus." is fulfilling your wish for " .$message;
        $fields = array( 
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "A bud from the wish tree blossoms into a flower: ".$ngoCus." is fulfilling your wish for " .$message,"icon" => "pushicon","color" => "#ff8f20","click_action" => "notid"),
			'data'                      => array("wishbud" =>$wishbud),
        );
		 
        $headers = array(
			GOOGLE_GCM_URL, 
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );

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
    }
    
     function send_email_support($orderid,$donorid, $ngoid,$ngoCus,$OnedonName)
    {
        //Mail function
        $Subject='Donor has sponsored a wishtree request! ';
        $Message=$OnedonName."-".$donorid." has Sponsored a Product for ".$ngoCus."-".$ngoid;
     
		require("PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587;
		//$mail->SMTPDebug = 2; 
	    // used only when SMTP requires authentication   
		$mail->SMTPAuth = true;		
		$mail->Username = "info@igiver.org";
		$mail->Password = "LokasG@2020"; 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress('info@igiver.org'); // recipients email
	    $mail->AddCC('info@igiver.org'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject =$Subject.'-'.$orderid;  
		$message=$Message.'-'.$orderid;
		$headContent=$Message; //header
		$mail->Body .='    
		   
			<table cellpadding="0" cellspacing="0" border="0">            
				<tbody>
				<tr><td align="left" valign="top">            
        				<table cellpadding="0" cellspacing="0" border="1">
        				<tbody>            
                				<tr><td align="left" valign="top"></td></tr>
                				<tr>
                				<td style="font:bold;">Dear Support Partner, Initiated from iGiver.Org  </td></tr>
                				<tr><td align="left" valign="top">'.$message.'</td>
                				</tr>
                				<tr><td align="left" valign="top">&nbsp;</td>
                				</tr>
                				<tr><td align="left" valign="top">Order Detail</td>
                				</tr>
                				<tr><td align="left" valign="top">'.$tableorder.'</td>
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
          return 1;
        } 
        else
        {
            return 0;
        }
        
    }
    
?>