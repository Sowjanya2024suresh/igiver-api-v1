<?php 
    include '../dbconnect.php';    
    include '../whatsapp_api.php';


$data = $_POST;
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
        
        
        $orderid=$data['payment_request_id'];//amount
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
       // $mac_provided=$mac_calculated;
        
        if($mac_provided == $mac_calculated){
            
              // Do something here
            if($data['status'] == "Credit"){
                
                   $overall_status='2';
               $paystatus='1';
               $pay_ref_no=$data['payment_id'];//From POST payment_id for pay_ref_no
               $updatedate=date('y-m-d');
               $updatesql="UPDATE `wallet_donor_transaction` SET `transfered_status`='".$overall_status."',`mojo_id`='".$pay_ref_no."',`webhookdata`='".$data."',`updatedate`='".$updatedate."' WHERE `payrequetId`='".$orderid."'";
               //echo $updatesql;
               $result = mysqli_query($con,$updatesql);

// Send whatsapp to donor

 $Detailsql = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,(select cus_phone from customer where donor_id=cus_userId) as donor_phone,mojo_id FROM `wallet_donor_transaction` where payrequetId=='".$orderid."'";
                    // echo $DonorDetailsql;
                    
                    $resretail = mysqli_query($con,$Detailsql);
                    if($resretail)
                    {
                    	while($row = mysqli_fetch_array($resretail))
                    	{
                             $donor_name=$row[0];$donor_phone=$row[1];$mojo_id=$row[2];
                        }
                    }
 send_whatsapp_orderconfirmtodonor($donor_name,$donor_phone,$mojo_id); 

            }
        
        }


// Send whatsapp to donor

 $Detailsql = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,(select cus_phone from customer where donor_id=cus_userId) as donor_phone,mojo_id FROM `wallet_donor_transaction` where payrequetId=='".$orderid."'";
                    // echo $DonorDetailsql;
                    
                    $resretail = mysqli_query($con,$Detailsql);
                    if($resretail)
                    {
                    	while($row = mysqli_fetch_array($resretail))
                    	{
                             $donor_name=$row[0];$donor_phone=$row[1];$mojo_id=$row[2];
                        }
                    }
 send_whatsapp_orderconfirmtodonor($donor_name,$donor_phone,$mojo_id); 



?>