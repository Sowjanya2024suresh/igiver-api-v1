<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
    include '../dbconnect.php';


$id =$_GET['id'];

   if ($id=="")
 $sqlproducts = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,amount FROM `wallet_donor_transaction` where transfered_status='1' order by id DESC";
    
      else
    $sqlproducts = "SELECT (select cus_name from customer where donor_id=cus_userId) as donor_name,amount FROM `wallet_donor_transaction` where transfered_status='1' and ngo_id='".$id."' order by id DESC";
    
$resproducts= mysqli_query($con,$sqlproducts);
    
    if($resproducts)
    {
    	while($row = mysqli_fetch_array($resproducts))
    	{
    		
             $products[] =array('donor_name'=>$row[0],'amount'=>$row[1]);
        }
        print_r(json_encode($products));	
    }