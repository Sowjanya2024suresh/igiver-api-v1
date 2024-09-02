<?php
// Importing DBConfig.php file.
    include 'dbconnect.php';

$ids =$_POST['ngo_userid'];
$sql = "SELECT  `share_text`, `share_image_url`,`share_link` FROM `ngo_social_share_msg_template` WHERE `ngo_userid`='".$ids."'";
 //echo $sql;
$res = mysqli_query($con,$sql);
//$result = array();
//var_dump($res) ;
$rowcount=mysqli_num_rows($res);
 // printf("Result set has %d rows.\n",$rowcount);
if($rowcount >0)
{
	while($row = mysqli_fetch_array($res))
	{
	
                  $share_data[] =array('share_text'=>$row[0],'share_image_url'=>$row[1],'share_link'=>$row[2]);
                  
                  //increment count in Tracking table
                  $sql = "UPDATE `ngo_campaign_performance` SET `share_count`= `share_count`+1 WHERE `ngo_id`='". $ids ."'";
                  //echo $sql;
                 $res = mysqli_query($con,$sql);
    }
}
else
{
  
    $genMsg= "Dear Donor,  Our NGO is a part of iGiver family. iGiver is a new way to help us anonymously, directly by giving books, groceries, 
    vegetables etc to our Home.I am personally requesting you to help us by giving through this link.";
    $imageurl='productImage/homeimage.png';
    $share_link='https://www.igiver.org/';
     $share_data[] =array('share_text'=>$genMsg,'share_image_url'=>$imageurl,'share_link'=>$share_link);
    
}

	
	print_r(json_encode($share_data));	
	

//Insert count - Track NGO performance
mysqli_close($con);
 
?>