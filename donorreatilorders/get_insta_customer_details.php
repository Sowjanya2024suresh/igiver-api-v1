<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
    include '../dbconnect.php';


$id =$_GET['id'];


if(isset($_GET['status']) && !empty($_GET['status'])){
   if($_GET['status']=="ALL")
{
    if ($id=="")
 $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record`  order by id DESC";
    
      else
    $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record` WHERE camp_id='".$id."' order by id DESC";
}
else
{

    if ($id=="")
 $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record` where payment_status<>'Failed' and payment_status<>'' order by id DESC";
    
      else
    $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record` WHERE camp_id='".$id."' and payment_status<>'Failed' and payment_status<>'' order by id DESC";

}

    
} else {
    
    if ($id=="")
 $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record` where payment_status<>'Failed' and payment_status<>'' order by id DESC";
    
      else
    $sqlproducts = "SELECT id,camp_id,retail_code,payment_id,payment_status,amount,buyer_name,buyer_phone,buyer_email,quantity,unit_price,fees,billing_instrument FROM `payment_record` WHERE camp_id='".$id."' and payment_status<>'Failed' and payment_status<>'' order by id DESC";
    
}




$resproducts= mysqli_query($con,$sqlproducts);
    
    if($resproducts)
    {
    	while($row = mysqli_fetch_array($resproducts))
    	{
    		
             $products[] =array('id'=>$row[0],'camp_id'=>$row[1],'retail_code'=>$row[2],'payment_id'=>$row[3],'payment_status'=>$row[4],'amount'=>$row[5],'buyer_name'=>$row[6],'buyer_phone'=>$row[7],'buyer_email'=>$row[8],'quantity'=>$row[9],'unit_price'=>$row[10],'fees'=>$row[11],'billing_instrument'=>$row[12]);
        }
        print_r(json_encode($products));	
    }

 