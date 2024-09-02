<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
    include '../dbconnect.php';


$campid =$_GET['campid'];

    $sqlproducts = "SELECT a.id,a.campaign_name,a.campaign_desc,a.retail_vendor,a.sku,a.start_date,a.end_date,target_units,unit_price,(SELECT SUM(b.amount) FROM wallet_donor_transaction b where b.ngo_id=a.beneficiary_id and transfered_status='1') as total FROM `focus_campaigns` a where id='".$campid."'";
     
    $resproducts= mysqli_query($con,$sqlproducts);
    
    if($resproducts)
    {
    	while($row = mysqli_fetch_array($resproducts))
    	{
    		
             $products[] =array('id'=>$row[0],'camp_name'=>$row[1],'camp_desc'=>$row[2],'retail_id'=>$row[3],'sku'=>$row[4],'start_date'=>$row[5],'end_date'=>$row[6],'target_units'=>$row[7],'unit_price'=>$row[8],'total'=>$row[9]);
        }
        print_r(json_encode($products));	
    }

 