<?php
	// Importing DBConfig.php file.
    include '../dbconnect.php';    
    include '../whatsapp_api.php';

    function send_sms($mobno,$msg)
   	{
         //For testing
        //echo $msg;
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
    
    function sendordertoall($orderid)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          //CURLOPT_URL => 'http://igiver.org/ngoapp/donorreatilorders/send_order_email_to_retailer.php?orderid='.$orderid,
          //CURLOPT_URL => 'https://api.igiver.org/v1/donorreatilorders/send_order_email_to_retailer.php?orderid='.$orderid,
CURLOPT_URL => 'https://api.igiver.org/v1/donorreatilorders/send_order_email_all.php?orderid='.$orderid,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        
    }
    
    function send_email($orderdetailarray,$purpose)
    {
        //Mail function
       
       
		require_once("../PHPMailer/class.phpmailer.php");
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
		$mail->AddAddress('support@lokas.in'); // recipients email
		$mail->AddCC('raghav@lokas.in'); // recipients email
		$mail->From = 'igiver@lokas.in';
		$mail->FromName = 'iGiver.Org'; // readable name
		$mail->Subject ='Order Details Payment Status from iGiver.Org:Instamojo Confirmation for '.$purpose; 
		$message='Order Details Payment Status from iGiver.Org  ';
		$headContent="'Order Initiated from iGiver.Org"; //header
		$mail->Body .='    
			<table cellpadding="0" cellspacing="0" border="0">            
				<tbody>
				<tr><td align="left" valign="top">            
				<table cellpadding="0" cellspacing="0" border="0">
				<tbody>            
				<tr><td align="left" valign="top"></td></tr>
				<tr>
				<td style="font:bold;">Dear Retail Partner, Order Initiated from iGiver.Org  </td></tr>
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
				<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">NGO Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$NgoDetailArray.'</td>
				</tr>
					<tr><td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr><td align="left" valign="top">Donor Detail</td>
				</tr>
				<tr><td align="left" valign="top">'.$DonorDetailArray.'</td>
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
            echo 'Unable to send email. Please try again.';
        }
        
    }
        $data = $_POST;
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
        
        
        $orderid=$data['purpose'];//amount
        //echo $orderid;
        
        
        $ver = explode('.', phpversion());
        $major = (int) $ver[0];
        $minor = (int) $ver[1];
        
        if($major >= 5 and $minor >= 4){
             ksort($data, SORT_STRING | SORT_FLAG_CASE);
        }
        else{
             uksort($data, 'strcasecmp');
        }
        
        // You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
        // Pass the 'salt' without the <>.
        $mac_calculated = hash_hmac("sha1", implode("|", $data), "57d1d59c72e9478fb06dff039dfac2ea");
        
        //For now testing
        $mac_provided=$mac_calculated;
        
        if($mac_provided == $mac_calculated){
            //echo "MAC is fine";
            // Do something here
            if($data['status'] == "Credit"){
               //Update donor_reatil_orders with pay status and pay ref id
               //UPDATE `donor_retail_orders` SET `overall_status`=[value-12],`paystatus`=[value-13],`pay_ref_no`=[value-14],`updatedate`=[value-20] WHERE `orderid`=''
               $overall_status='2';
               $paystatus='1';
               $pay_ref_no=$data['payment_id'];//From POST payment_id for pay_ref_no
               $updatedate=date('y-m-d');


//check pay_ref_no already exist or not
$query = "SELECT * FROM donor_retail_orders WHERE pay_ref_no='".$pay_ref_no."'";

                    $rres = mysqli_query($con,$query );
                    $rcount = mysqli_num_rows($rres);

                    if($rcount >0)
                    {
exit("record already exists");
}


               $updatesql="UPDATE `donor_retail_orders` SET `overall_status`='".$overall_status."',`paystatus`='".$paystatus."',`pay_ref_no`='".$pay_ref_no."',`updatedate`='".$updatedate."' WHERE `orderid`='".$orderid."'";
               //echo $updatesql;
               $result = mysqli_query($con,$updatesql);
               
               //Insert the record in product ngo tables  FOR INTIMATING NGO and upload thankyou video etc
                    
                    $ngoid='';//
                    $pro_id=$orderid;//From POST
                    $cat_id=7;
                    $ret_code='';
                    $sku='';
                    $order_amount=$data['amount'];
                   
                    
                    //Get retail_code,order_sku from table donor_retail_orders with Order_id as search key
                    //Then call retail_vendor_products
                    $ordersql = "SELECT `retail_code`,`order_sku`, `ngoid`, `donorid`,order_amount FROM `donor_retail_orders` WHERE `orderid`= '".$orderid."'";
                    echo $ordersql;
                    
                    $res = mysqli_query($con,$ordersql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $ret_code=$row['retail_code'];
                             $sku=$row[1];
                             $ngoid=$row[2];
                             $donorid=$row[3];
                             //$order_amount=$row[4];
                        }
                    }
                    echo $ret_code.'  '.$sku;
                    
                    $pro_user_title='';//retail_vendor_products.name
                    $pro_user_desc='';//retail_vendor_products.description
                    $pro_user_img='';//retail_vendor_products.description.image_url
                    
                    $ProdDetailsql = "SELECT  name,description,image_url FROM `retail_vendor_products` WHERE `retail_code`='".$ret_code."' and sku='".$sku."'";
                    echo $ProdDetailsql;
                    
                    $res = mysqli_query($con,$ProdDetailsql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $pro_user_title=$row[0];$pro_user_desc=$row[1];$pro_user_img=$row[2];;
                        }
                    }
                    echo $pro_user_title.'  '.$pro_user_desc.'  '.$pro_user_img;
                    
                    $status     = '1';
                	$flag      = '1';
                	$bidsopt    = 'nobids.png';
                	$ngo_range=$order_amount;//retail_vendor_products.unit_price
                	$noti_status='1';
                	$sponsor=$donorid;//DonorID
                	$createdate=date('y-m-d');
                    
                    

                   //Update Product ngo table if wishtreeid exist
                    $productngoquery = "SELECT * FROM donor_retail_orders A,product_ngo B where B.pro_user_id=A.wishtreeid and A.orderid='".$orderid."'";
                    $resproductngo = mysqli_query($con,$productngoquery);
                    $rows_count_value = mysqli_num_rows($resproductngo);
                    if($rows_count_value=='1')
                    {
                        $resultwishtree=mysqli_fetch_array($resproductngo);
                        $wishtreeid=$resultwishtree['wishtreeid'];
                        $sqlupdateProdNgo = "update  product_ngo set pro_id='$pro_id',sponsor='$sponsor',dndt='$updatedate' where pro_user_id='$wishtreeid'";
                    	$stmt = mysqli_prepare($con,$sqlupdateProdNgo);
                      	$val= mysqli_stmt_execute($stmt);
                        
                    }else
                    {
                    //Insert the record in product ngo tables   
                	$sqlInsertProdNgo = "INSERT INTO product_ngo 
                	(cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,flag,bids_opt,ngo_range,noti_status,sponsor) 
                	VALUES ('$ngoid','$pro_id','$cat_id','$pro_user_title','$pro_user_desc','$pro_user_img','$createdate','$updatedate','$status','$flag','$bidsopt','$ngo_range','$noti_status','$sponsor')";
                	echo $sqlInsertProdNgo;
                	$stmt = mysqli_prepare($con,$sqlInsertProdNgo);
                	mysqli_stmt_execute($stmt);
                	$check = mysqli_stmt_affected_rows($stmt);
                	$last_id = mysqli_insert_id($con);
                    }
                	 
                	
                	 
                    //Send a Push notification to NGO
                    $ngo_phone='';//
                    $ngo_name='';
                    $ngo_email='';
                    
                    //Send a SMS to NGO
                     $NGODetailsql = "SELECT  `cus_name`, `cus_email`, `cus_phone` FROM `customer` WHERE `cus_userId`='". $ngoid."' AND `cus_role`=1";
                    echo $NGODetailsql;
                    
                    $res = mysqli_query($con,$NGODetailsql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $ngo_name=$row[0];$ngo_email=$row[1];$ngo_phone=$row[2];;
                        }
                    }
                    echo $ngo_name.'  '.$ngo_phone.'  '.$ngo_email;
                    $ngo_msg="Dear ".$ngo_name." you have recived an in-kind donation through igiver!Please check your app. ";
                    send_sms($ngo_phone,$ngo_msg);
                    
                    //Send SMS to Donor
                    $donor_phone='';//
                    $donor_name='';
                    $donor_email='';
                    
                    
                    $DonorDetailsql = "SELECT  `cus_name`, `cus_email`, `cus_phone` FROM `customer` WHERE `cus_userId`='". $donorid."' AND `cus_role`=0";
                    echo $DonorDetailsql;
                    
                    $resDon = mysqli_query($con,$DonorDetailsql);
                    if($resDon)
                    {
                    	while($row = mysqli_fetch_array($resDon))
                    	{
                             $donor_name=$row[0];$donor_email=$row[1];$donor_phone=$row[2];;
                        }
                    }
                    echo $donor_name.'  '.$donor_email.'  '.$donor_phone;
                    $don_msg="Dear ".$donor_name.". Thank you for your kindness.Your order Id is".$orderid.". Kindly quote this for any support queries.Please call 7200011175 for any help. ";
                    send_sms($donor_phone,$don_msg);
               
               	 
        //send_email(json_encode($data),$orderid);
        
        //mail to retailer,ngo,donor//Send mail to igiver support
               sendordertoall($orderid);

        //whatsapp sms to donor/retailer/ngo 
                   $RetailDetailsql = "SELECT `retail_code`,(select retail_name from retail_vendor b where a.retail_code=b.retail_code) as retailname,(select mobile from retail_vendor b where a.retail_code=b.retail_code) as retailnumber,orderid from donor_retail_orders a where orderid='". $orderid."'";
                    // echo $DonorDetailsql;
                    
                    $resretail = mysqli_query($con,$RetailDetailsql);
                    if($resretail)
                    {
                    	while($row = mysqli_fetch_array($resretail))
                    	{
                             $retail_code=$row[0];$retail_name=$row[1];$retail_phone=$row[2];;
                        }
                    }
               send_whatsapp_orderconfirmtodonor($donor_name,$donor_phone,$pay_ref_no);
               send_whatsapp_orderplacedtongo($ngo_name,$ngo_phone,$pay_ref_no);
               send_whatsapp_orderplacedtoret($retail_name,$retail_phone,$pay_ref_no);        
               
            }
            else{
               $errormsg="Thank you for initiating order with order- Payment was unsuccessful, mark it as failed in your database  ";
            }
            
           
            
            
        }
        else{
            //echo "Invalid MAC passed";
            $errormsg="Invalid MAC passed";
        }
        //For testing
        $igiverAdminNo='7200011175';
        $msg="Webook:NGO SMS Notified, Ticker Gen Completed for ".$orderid;
        send_sms($igiverAdminNo,$msg);
        if(strlen($errormsg) >0)
        {
            send_sms($igiverAdminNo,$errormsg);
            
        }
        
        
        
		
	

?>