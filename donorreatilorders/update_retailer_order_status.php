<?php
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    
   	function send_sms($mobno,$msg)
   	{
         //For testing
       // echo $msg;
	    $user_id = 'nmch-igiver';
	    $password = 'igiver12';
	    $sendid = 'iGIVER';
	    //$msg="Thank you for initiating order with order: $orderid";		  
	    $url="http://hpsms.nimbuschennai.com:8080/sendsms/bulksms?username=".$user_id."&password=".$password."&type=0&dlr=1&destination=".$mobno."&source=iGIVER&message=".urlencode($msg).""; 
		//echo $url;
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch); 
		curl_close($ch);
        return $response;
    }
	 
    $input_orderid=trim($_GET['orderid']);
    $input_retail_code=trim($_GET['retail_code']);
    $paystatus=$_GET['paystatus'];
    $pay_ref_no=$_GET['payrefno'];
    $delivery_ref_no=$_GET['deliveryrefno'];
    
    $order_desc=$_GET['order_desc'];
    $order_amount=$_GET['order_amount'];
    $order_qty=$_GET['order_qty'];
    $order_sku=$_GET['order_sku'];
    $ngoid=$_GET['ngoid'];
    $donorid=$_GET['donorid'];
    
    $updatedate=date('y-m-d');
    $orderid='';
    $retail_code='';
    
    $pay_ref_no='';
    $row_cnt=0;
    $sql='';
    
    if(strcmp("ACK",$input_retail_code) == 0)//From ACK
    {
        //echo "ACK";
        $pay_ref_no=$input_orderid;//ACK order ID is stored as pay_ref_no in donor_retail_orders Table
        // We need to get the order ID from igiver DB for this ACK order id
         $sql1 = "SELECT orderid,retail_code,order_amount FROM `donor_retail_orders` WHERE pay_ref_no='".$input_orderid."'";
        //echo $sql1;
        $sql=$sql1;
        $res1 = mysqli_query($con,$sql1);
        $row_cnt=mysqli_num_rows($res1);
        if($res1)
        {
        	while($row = mysqli_fetch_array($res1))
        	{
                 $orderid=$row[0];
                 $retail_code=$row[1];
		 $order_amount=$row[2];
            }
        }
        
    }
    else
    {
          //$orderid=$input_orderid;
          // We need to get the order ID from igiver DB for this ACK order id
            $sql2 = "SELECT orderid,retail_code FROM `donor_retail_orders` WHERE orderid='".$input_orderid."'";
            //echo $sql2;
            $sql=$sql2;
            $res2 = mysqli_query($con,$sql2);
            $row_cnt=mysqli_num_rows($res2);
            if($res2)
            {
            	while($row = mysqli_fetch_array($res2))
            	{
                     $orderid=$row[0];
                      $retail_code=$row[1];
                }
            }
        
    }
    
 
    if($row_cnt>0 && ($input_retail_code == 'ACK'))//ID exists, and is from ACK
    {
        
        	$sql="UPDATE `donor_retail_orders` SET `overall_status`='2',`paystatus`='$paystatus',`pay_ref_no`='$pay_ref_no',`delivery_ref_no`='$delivery_ref_no', `updatedate`='$updatedate' WHERE orderid='$orderid'";
            //echo $sql;
           // $order_update_status=mysqli_query($con,$sql);
            $order_update_status=1;
            // echo $order_update_status;
           $err_code='';
            // Perform a query, check for error
            if (!mysqli_query($con,$sql)) {
                $err_code=mysqli_errno($con);
             //echo("Errorcode: " .$err_code );
            }
            
       
            
            //echo "DB status   ".$err_code;
            
            if(strlen($err_code)==0)//
            {
                switch ($paystatus) {
                  case 1:
                    $sms_msg="Order Payment successful for order id ".$input_orderid." And Retailer ".$retail_code." Status Updated Successfully ".$orderid;
                    //Insert the record in product ngo tables  FOR INTIMATING NGO and upload thankyou video etc
                    
                    $cus_id=$ngoid;//cus_id//$ngoid from GET
                    $pro_id=$orderid;
                    $cat_id=7;
                    $sku='';
                    
                    //Get retail_code,order_sku from table donor_retail_orders with Order_id as search key
                    //Then call retail_vendor_products
                    $OrderSKUsql = "SELECT  `order_sku`,donorid,ngoid FROM `donor_retail_orders` WHERE `orderid`='".$orderid."'";
                    //  echo $OrderSKUsql;
                    
                    $res = mysqli_query($con,$OrderSKUsql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $sku=$row[0];
                             $donorid=$row[1];
                             $ngoid=$row[2];
                        }
                    }
                    // echo $ret_code.'  '.$sku;
                    
                    $pro_user_title='';//retail_vendor_products.name
                    $pro_user_desc='';//retail_vendor_products.description
                    $pro_user_img='';//retail_vendor_products.description.image_url
                    
                    $ProdDetailsql = "SELECT  name,description,image_url FROM `retail_vendor_products` WHERE `retail_code`='".$retail_code."' and sku='".$sku."'";
                    // echo $ProdDetailsql;
                    
                    $res = mysqli_query($con,$ProdDetailsql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $pro_user_title=$row[0];$pro_user_desc=$row[1];$pro_user_img=$row[2];;
                        }
                    }
                    // echo $pro_user_title.'  '.$pro_user_desc.'  '.$pro_user_img;
                    
                    $status     = '1';
                	$flag      = '1';
                	$bidsopt    = 'nobids.png';
                	$ngo_range=$order_amount;//donor_retail_orders.order_amount 
                	$noti_status='0';
                	$sponsor=$donorid;//DonorID
                    
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
                	$sqlInsertProdNgo = "INSERT INTO product_ngo (cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,flag,bids_opt,ngo_range,noti_status,sponsor) 
                	VALUES ('$ngoid','$pro_id','$cat_id','$pro_user_title','$pro_user_desc','$pro_user_img','$updatedate','$updatedate','$status','','$bidsopt','$ngo_range','$notiStatus','$sponsor')";
                 	//echo $sqlInsertProdNgo;
                	$stmt = mysqli_prepare($con,$sqlInsertProdNgo);
                	mysqli_stmt_execute($stmt);
                	//$check = mysqli_stmt_affected_rows($stmt);
                	//$last_id = mysqli_insert_id($con);
                    }
                	 
                	 
                    //Send a Push notification to NGO
                    //Send a SMS to NGO
                    //Send mail to igiver support
                     //Sending email to support
                    $curl = curl_init();
        
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.igiver.org/v1/donorreatilorders/send_order_email_to_retailer.php?orderid='.$orderid,
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
                    
                    
                    break;
                  case 2:
                    $sms_msg="Order Payment unsuccesful for order id ".$input_orderid." Status Updated Successfully".$orderid;
                    
                    break;
                  default:
                    $sms_msg="Order Payment failed or error updating for order id".$input_orderid." Status Updated Successfully ".$orderid;
                    
                    break;
                }
                $order_update_status=1;//Payment may fail but Table is updated
                
            }
            else
            {
                 $sms_msg="Error updating  status for order id ".$orderid." with error ".$err_code;
                 $order_update_status=2;
            }
            
            //echo $sms_msg;
            $res=send_sms('7200011175',$sms_msg);
            //echo $res;
            
           
            
            
           
    }
    else //Return failed
    {
        if($row_cnt>0 )//ID exists, and is from Other retailers
        {
            $order_update_status=3;
            $sms_msg="Payment from Insta. Status Update aborted for order id ".$orderid;
            $res=send_sms('7200011175',$sms_msg);
            
        }
        else
        {
            $order_update_status=4;
            $sms_msg="Order ID doesnt exist . Status Update aborted for order id ".$input_orderid;
            $res=send_sms('7200011175',$sms_msg);
            
        }
       
    }

    if(strcmp("ACK",$input_retail_code) == 0)//From ACK
    {
        $orderid=$input_orderid;
    }
       
   $order_info[] =array('orderid'=>$orderid,'message'=>$sms_msg,'status'=>$order_update_status);

    print_r(json_encode($order_info));
  
   mysqli_close($con);
 
 
?>