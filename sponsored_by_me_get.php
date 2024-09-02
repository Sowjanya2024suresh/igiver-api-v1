<?php
// Importing DBConfig.php file.
include 'dbconnect.php';

function getretandngolinks($con,$retOrderId,$ngoid)
{
    $links=array();
    //Check if retail Order
   
        //Get Retailer Name and web link
        $RetailerName='';
        $RetailerWebUrl='';
        $NGOWebUrl='';
        
        $retailCode=substr($retOrderId,0,3);
        
        //Get retail_code,order_sku from table donor_retail_orders with Order_id as search key
        //Then call retail_vendor_products
        $retinfosql = "SELECT  `retail_name`, `website`  FROM `retail_vendor` WHERE `retail_code`='".$retailCode."'";
       // echo $retinfosql;
        
        $res = mysqli_query($con,$retinfosql);
        if($res)
        {
        	while($row = mysqli_fetch_array($res))
        	{
                 $RetailerName=$row['retail_name'];$RetailerWebUrl=$row['website'];
            }
        }
         //echo $RetailerName.'  '.$RetailerWebUrl;
        
   
    
    
    //Get NGO Weblink
    //SELECT `ngo_link` FROM `customer` WHERE `cus_userId`='NGO150'
     $ngoinfosql = "SELECT `ngo_link` FROM `customer` WHERE `cus_userId`='".$ngoid."'";
        //echo $ngoinfosql;
        
        $res2 = mysqli_query($con,$ngoinfosql);
        if($res2)
        {
        	while($row2 = mysqli_fetch_array($res2))
        	{
                 $NGOWebUrl=$row2['ngo_link'];
            }
        }
        // echo $NGOWebUrl;
     $links[] =array('RetailerName'=>$RetailerName,'RetailerWebUrl'=>$RetailerWebUrl,'NGOWebUrl'=>$NGOWebUrl);
   //print_r($links);
   //exit;
   return $links;
        
    
    
}


$donorid = $_POST['donorid'];

//SELECT `pro_user_id`, `cus_id`, `pro_id`, `cat_id`, `pro_user_title`, `pro_user_desc`, `pro_user_img`, `crdt`, `dndt`, `status`, `flag`, `bids_opt`, `ngo_range`, `noti_status`, `sponsor` FROM `product_ngo` WHERE 1
$retOrderId='';
$ngoid='';
$sql = "select pro_user_id,cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,
flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link 
from product_ngo WHERE cus_id IN (SELECT cus_userId from customer WHERE flag = 1) AND sponsor='".$donorid."'"; 
//echo $sql;
$res = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($res)){
   
    $links=array();
    $retOrderId=$row[2];
    $ngoid=$row[1];
    
    $RetailerName='NA';
    $RetailerWebUrl='NA';
    $NGOWebUrl='NA';
    
    
    if(strlen($retOrderId)>5)
    {
        //echo $retOrderId;
       $links=  getretandngolinks($con,$retOrderId,$ngoid);
         //print_r($links);
         
        $RetailerName=$links[0]['RetailerName'];
        $RetailerWebUrl=$links[0]['RetailerWebUrl'];
        $NGOWebUrl=$links[0]['NGOWebUrl'];
        
        //echo 'RN:::'.$RetailerName;
        
        
    }
     $cust[] =array('pro_user_id'=>$row[0],'cus_id'=>$row[1],'pro_id'=>$row[2],'cat_id'=>$row[3],'pro_user_title'=>$row[4],'pro_user_desc'=>$row[5],
    'pro_user_img'=>$row[6],'crtd_date'=>$row[7],'modi_date'=>$row[8],'status'=>$row[9],'flag'=>$row[10],'bids_opt'=>$row[11],'ngo_range'=>$row[12],
    'sponsor'=>$row[14],'thanks_video_status'=>$row[15],'thanks_video_link'=>$row[16],'retail_name'=>$RetailerName,'website'=>$RetailerWebUrl,'ngo_link'=>$NGOWebUrl);
    
   
   
    
}




echo json_encode($cust);
mysqli_close($con);
?>