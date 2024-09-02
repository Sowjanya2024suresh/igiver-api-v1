<?php

// Importing DBConfig.php file.
include 'dbconnect.php';

$cusuid = $_GET['id'];
 

$sql = "select id,cus_userid,latitude,longitude from ngo_detail where cus_userid='$cusuid'";
//print_r($sql);
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
/*array_push($result1,
array('cus_id'=>$row[0],
'cus_userId'=>$row[1]
));*/
$cusID = $row[0];
$cusUID = $row[1];
//echo $cusID;
}
//echo "</br>".$cusID."id";
$sql1 = "select id,cus_userid,latitude,longitude from ngo_detail where cus_userid='$cusuid'";

$res1 = mysqli_query($con,$sql1);
 
$result = array();
 
while($row_dir = mysqli_fetch_array($res1)){
array_push($result,
array('loc_id'=>$row_dir[0],
'cus_id'=>$row_dir[1],
'latitude'=>$row_dir[2],
'longitude'=>$row_dir[3]
));
} 
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>