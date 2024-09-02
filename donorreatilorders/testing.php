
<?php
// required headers
header("Access-Control-Allow-Origin: *");
  
	// Importing DBConfig.php file.
    include '../dbconnect.php';
 include '../whatsapp_api.php';
	 
               $orderid="402f820c4e3b45cbbaf6cb7257a45e90";
               $Detailsql = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,(select cus_phone from customer where donor_id=cus_userId) as donor_phone,mojo_id FROM `wallet_donor_transaction` where payrequetId='". $orderid."'";
                    // echo $DonorDetailsql;
                    
                    $resretail = mysqli_query($con,$Detailsql);
                    if($resretail)
                    {
                    	while($row = mysqli_fetch_array($resretail))
                    	{
                             $donor_name=$row[0];$donor_phone=$row[1];$mojo_id=$row[2];
                        }
                    }

echo $donor_name."=".$donor_phone."=".$mojo_id;
$donor_phone="9841200531";
               
            send_whatsapp_orderconfirmtodonor($donor_name,$donor_phone,$mojo_id); 
echo $donor_name."=".$donor_phone."=".$mojo_id;
	mysqli_close($con);
?>