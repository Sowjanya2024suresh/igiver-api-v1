<?php

header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include '../dbconnect.php';

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



//SELECT `pro_user_id`, `cus_id`, `pro_id`, `cat_id`, `pro_user_title`, `pro_user_desc`, `pro_user_img`, `crdt`, `dndt`, `status`, `flag`, `bids_opt`, `ngo_range`, `noti_status`, `sponsor` FROM `product_ngo` WHERE 1
$retOrderId='';
$ngoid='';
// $sql = "select pro_user_id,cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,status,flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link,sku,orderdate,retail_code,qty from product_ngo WHERE cus_id IN (SELECT cus_userId from customer WHERE flag = 1)"; 
// $sql = "select pro_user_id,a.cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,a.status,a.flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link,sku,orderdate,retail_code,qty,cus_name,cus_image,cus_contact_name,cus_address,cus_phone,ngo_link,cus_field_of_service from product_ngo a left join customer b on a.cus_id=b.cus_userId WHERE a.cus_id IN (SELECT cus_userId from customer WHERE flag = 1) and sponsor='' order by pro_user_id desc ";


if(isset($_GET['ngoid']))
{
    // Do something
    
   $sql ="select pro_user_id,a.cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,a.status,a.flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link,a.sku,orderdate,a.retail_code,qty,cus_name,cus_image,cus_contact_name,cus_address,cus_phone,ngo_link,cus_field_of_service,p.id,l.latitude,l.longitude from product_ngo a left join customer b on a.cus_id=b.cus_userId left join retail_vendor_products p on a.sku=p.sku LEFT JOIN ngo_detail l on b.cus_userId=l.cus_userid  WHERE a.cus_id IN (SELECT cus_userId from customer WHERE flag = 1) and sponsor='' and a.cus_id='".$_GET['ngoid']."' and a.flag=1 order by cast(ngo_range as unsigned)";
}
else if(isset($_GET['random']))
{
$sql="select pro_user_id,a.cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,a.status,a.flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link,a.sku,orderdate,a.retail_code,qty,cus_name,cus_image,cus_contact_name,cus_address,cus_phone,ngo_link,cus_field_of_service,p.id,l.latitude,l.longitude from product_ngo a left join customer b on a.cus_id=b.cus_userId left join retail_vendor_products p on a.sku=p.sku LEFT JOIN ngo_detail l on b.cus_userId=l.cus_userid  WHERE a.cus_id IN (SELECT cus_userId from customer WHERE flag = 1) and sponsor='' and a.flag=1 order by RAND()";
}
else
{
$sql="select pro_user_id,a.cus_id,pro_id,cat_id,pro_user_title,pro_user_desc,pro_user_img,crdt,dndt,a.status,a.flag,bids_opt,ngo_range,noti_status,sponsor,thanks_video_status,thanks_video_link,a.sku,orderdate,a.retail_code,qty,cus_name,cus_image,cus_contact_name,cus_address,cus_phone,ngo_link,cus_field_of_service,p.id,l.latitude,l.longitude from product_ngo a left join customer b on a.cus_id=b.cus_userId left join retail_vendor_products p on a.sku=p.sku LEFT JOIN ngo_detail l on b.cus_userId=l.cus_userid  WHERE a.cus_id IN (SELECT cus_userId from customer WHERE flag = 1) and sponsor='' and a.flag=1 order by cast(ngo_range as unsigned)";
}


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
    
       $filedfor = mysqli_fetch_array(mysqli_query($con,"select GROUP_CONCAT(DISTINCT servicetype_name SEPARATOR ', ') as servicetypes from servicetype where servicetype_id IN (".$row[27].")"));

    
     $cust[] =array('pro_user_id'=>$row[0],'cus_id'=>$row[1],'pro_id'=>$row[2],'cat_id'=>$row[3],'pro_user_title'=>$row[4],'pro_user_desc'=>$row[5],
    'pro_user_img'=>$row[6],'crtd_date'=>$row[7],'modi_date'=>$row[8],'status'=>$row[9],'flag'=>$row[10],'bids_opt'=>$row[11],'ngo_range'=>$row[12],
    'sponsor'=>$row[14],'thanks_video_status'=>$row[15],'thanks_video_link'=>$row[16],'sku'=>$row[17],'orderdate'=>$row[18],'retail_code'=>$row[19],'qty'=>$row[20],'retail_name'=>$RetailerName,'website'=>$RetailerWebUrl,'ngo_link'=>$NGOWebUrl,'ngo_name'=>$row[21],'ngo_image'=>$row[22],'ngo_contact_name'=>$row[23],'ngo_address'=>$row[24],'ngo_phone'=>$row[25],'ngo_service'=>$filedfor[0],'ngo_link'=>$row[26],'product_id'=>$row[28],'lat'=>$row[29],'long'=>$row[30]);
    
   
   
    
}




echo json_encode($cust);
mysqli_close($con);
?>