<?php

    // Importing DBConfig.php file.
    include 'dbconnect.php';
    function jsonToTable ($data)
    {
        $table = '
        <table  cellpadding="0" cellspacing="0" border="1" width="100%" >
        ';
        foreach ($data as $key => $value) {
            $table .= '
            <tr valign="top">
            ';
            if ( ! is_numeric($key)) {
                $table .= '
                <td>
                    <strong>'. $key .':</strong>
                </td>
                <td>
                ';
            } else {
                $table .= '
                <td colspan="2">
                ';
            }
            if (is_object($value) || is_array($value)) {
                $table .= jsonToTable($value);
            } else {
                $table .= $value;
            }
            $table .= '
                </td>
            </tr>
            ';
        }
        $table .= '
        </table>
        ';
        return $table;
    }

    function send_email_support($orderid,$detailarray,$Subject,$Message)
    {
        //Mail function
       $tabledetail= jsonToTable(json_decode($detailarray));
     
		require("PHPMailer/class.phpmailer.php");
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



    $name       = $_POST['name']; //image name
    $image      = $_POST['image']; //image in string format  
	$ptitle     = $_POST['prodTitle']; 
        $ptitle     =str_replace("'", "''", $ptitle);
	$pdesc      = $_POST['prodDesc'];
        $pdesc      =str_replace("'", "''", $pdesc);
	$pcateg     = $_POST['category'];
	$prod       = $_POST['product']; 
	$cusUID     = $_POST['ngoid'];
	$range      = $_POST['ngo_range'];
	$crtdDate   = date('Y-m-d H:i:s');
	$modDate    = date('Y-m-d H:i:s');
	$status     = '1';
	$flage      = '1';
	$bidsopt    = 'nobids.png';
	$img_name   = $name.".jpg";
	$notiStatus = 0;
	$sponsor    = $_POST['sponsor'];
		$sku    = $_POST['sku'];
$orderdate    = $_POST['orderdate'];
$retail_code    = $_POST['retail_code'];

$qty    = $_POST['qty'];
	//Decode the image
    $decodedImage = base64_decode($image); 
	file_put_contents("productImage/".$name.".jpg", $decodedImage);
	if($_SERVER['REQUEST_METHOD']=='POST'){ 
	    
	    
	    //Default category image Raghav
                if( $img_name == 'IMG_null.jpg')
                {
                    switch ($pcateg) {
                                  case "1":
                                    $img_name = "clothing.jpg";
                                    break;
                                  case "2":
                                     $img_name = "grocery.jpg";
                                    break;
                                  case "3":
                                     $img_name = "stationeries.jpg";
                                    break;
                                  case "4":
                                     $img_name = "electronics.jpg";
                                    break;
                                  case "5":
                                     $img_name = "furniture.jpg";
                                    break;
                                  case "6":
                                     $img_name = "medical.jpg";
                                    break;
                                  case "7":
                                     $img_name = "other.jpg";
                                    break;
                                  default:
                                    $img_name = "other.jpg";
                                }
                   }

	     else
                   {
                        $img_name = $image;
                   }
	    
	    
	    
	    
	    
	    
    	 //Insert the record in product ngo tables   
    	 $sql = "INSERT INTO product_ngo (cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,flag,bids_opt,ngo_range,noti_status,sponsor,sku,orderdate,qty,retail_code) 
    	 VALUES ('$cusUID','$prod','$pcateg','$ptitle','$pdesc','$img_name','$crtdDate','$modDate','$status','$flage','$bidsopt','$range','$notiStatus','$sponsor','$sku','$orderdate','$qty','$retail_code')";
    	 //echo  $sql; 

    	 $stmt = mysqli_prepare($con,$sql);
    	 mysqli_stmt_execute($stmt);
    	 $check = mysqli_stmt_affected_rows($stmt);
    	 $last_id = mysqli_insert_id($con);
    	
    	// echo  "lastid=".$check ;
    	  echo json_encode(1);
        //	 if($check == 1)
        //	 {
        		//Get the last inserted values 
                $setimg = "Select * From product_ngo where pro_user_id='".$last_id."'";
                $setres = mysqli_query($con,$setimg); 
                $resImg = mysqli_fetch_assoc($setres);
                $pro_userId = $resImg['pro_user_id'];
                $notImage = $resImg['pro_user_title'];
                $notTitle = $resImg['pro_user_img']; 
                
                //Send email to support
            
            
            
                $NGOProdDetailArray[] =array('pro_user_id'=>$resImg['pro_user_id'],'pro_user_title'=>$resImg['pro_user_title']);
                //PHPSupportMailer 
                $Message='Wishtree - NGO has requested a Product';
                $Subject='Wishtree - NGO has requested a Product';
                send_email_support($pro_userId,$NGOProdDetailArray,$Subject,$Message);
                
                
                    //Get all the NGO tokens
                    $query = "SELECT * FROM gcm_token where cus_role='0' AND cus_uid != 'NULL' AND cus_uid != ''";
                    $result1 = mysqli_query($con,$query) ;
                    $res1 = mysqli_num_rows($result1); 
                        if($res1 > 0)
                        { 
                            $ngoImage = 'UPDATE product_ngo SET noti_status = 1 WHERE pro_user_id = '.$pro_userId;
                            $ngoNotify = mysqli_query($con, $ngoImage); 
                            while($res = mysqli_fetch_array($result1))
                            {
                            	 $reg_token =$res['gcm_tokenid'];
                                 //Notification send function
                                 //@send_gcm_notify($reg_token, $notImage, $notTitle);
                            }
                    } 
                
                
                //Return response
                
                 
                
        	// }else{
        	     
        	   // echo "1";
        	// }
    	 }else{
    	     
    	 echo "Error";	 
     }
 
 //Function for notification send to NGO
 function send_gcm_notify($reg_id, $message='', $img_url='', $ngoCus='') {
			define("GOOGLE_API_KEY", "AIzaSyCUHIRYYF6RoxTx0qZ9KkQCb0L6k7Fsa-w");
		    define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send"); 
		    
		$newbud = "A new bud  from the  wish tree: NGO ".$ngoCus." requires this ".$message; 
		
        $fields = array( 
			'to'  						=> $reg_id , 
			'priority'					=> "high", 
            'notification'              => array( "title" => "NGO near you needs help!  ", "body" => "NGO ".$ngoCus." requires this ".$message, "icon" => "pushicon","color" => "#ff8f20","click_action" => "notid"),
			'data'                      => array("newbud" =>$newbud),
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
?>