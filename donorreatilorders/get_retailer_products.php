<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
    include '../dbconnect.php';

$authcode =$_GET['authcode'];
$retailcode =$_GET['retailcode'];

if(isset($_GET['authcode']))
{
//Verify authcode
$sql = "SELECT retail_code FROM `retail_vendor` WHERE authcode='".$authcode."'";

$res = mysqli_query($con,$sql);
$row_cnt=$res->num_rows;
//printf("Result set has %d rows.\n", $row_cnt);
if($row_cnt>0)
{
    $sqlproducts = "SELECT `id`,`sku`, `name`, `description`, `unit_price`, `image_url` FROM `retail_vendor_products` WHERE retail_code='".$retailcode."' ORDER BY id DESC";
    $resproducts= mysqli_query($con,$sqlproducts);
    
    if($resproducts)
    {
    	while($row = mysqli_fetch_array($resproducts))
    	{
    		
             $products[] =array('id'=>$row[0],'sku'=>$row[1],'name'=>$row[2],'description'=>$row[3],'unit_price'=>$row[4],'image_url'=>$row[5]);
        }
        print_r(json_encode($products));	
    }
}
}
else
{

$sqlproducts = "SELECT `id`,`sku`, `name`, `description`, `unit_price`, `image_url` FROM `retail_vendor_products`  ORDER BY RAND()";
    $resproducts= mysqli_query($con,$sqlproducts);
    
    if($resproducts)
    {
    	while($row = mysqli_fetch_array($resproducts))
    	{
    		
             $products[] =array('id'=>$row[0],'sku'=>$row[1],'name'=>$row[2],'description'=>$row[3],'unit_price'=>$row[4],'image_url'=>$row[5]);
        }
        print_r(json_encode($products));	
    }

}
 
 
 


mysqli_close($con);
 
?>