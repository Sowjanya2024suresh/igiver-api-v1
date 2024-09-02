<?php
header('Access-Control-Allow-Origin: *');
// Importing DBConfig.php file.
include 'dbconnect.php';

/** Last seven days images with current date ***/
//$sql = "SELECT * FROM add_notification WHERE ndate BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND NOW()";

/** Last seven days images without current date ***/
//$sql = "SELECT * FROM add_notification WHERE ndate BETWEEN DATE_SUB(CURDATE(), INTERVAL 10 DAY) AND CURDATE() - INTERVAL 1 DAY ORDER BY DATE(ndate) DESC";
 
$sql = "select * from category where flag='1' order by cat_name";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	$flag[]=$row;
        $cate[] =array('cat_id'=>$row[0],'cat_name'=>$row[1],'created_date'=>$row[2],'modified_date'=>$row[3],'status'=>$row[4],'flag'=>$row[5],'image_url'=>$row[6]);
}
 
//print json_encode($flag);
print json_encode($cate);
 
mysqli_close($con);
 
?>