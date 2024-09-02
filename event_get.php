<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
$sql = "select eid,cust_id,ename,edate,evideo,eaudio,epdfdoc,ephoto1,ephoto2,ephoto3,ephoto4,edesc,status,flag,crdt,crby,dndt,dnby,globaleventtagid,ngouserid from event";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	 $cust[] =array('eid'=>$row[0],'cust_id'=>$row[1],'ename'=>$row[2],'edate'=>$row[3],'evideo'=>$row[4],'eaudio'=>$row[5],'epdfdoc'=>$row[6],'ephoto1'=>$row[7],'ephoto2'=>$row[8],'ephoto3'=>$row[9],'ephoto4'=>$row[10],'edesc'=>$row[11],'status'=>$row[12],'flag'=>$row[13],'crdt'=>$row[14],'crby'=>$row[15],'dndt'=>$row[16],'dnby'=>$row[17],'globaleventtagid'=>$row[18],'ngouserid'=>$row[19]);
}
 
echo json_encode($cust);
 
mysqli_close($con);
 
?>