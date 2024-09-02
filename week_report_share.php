<?php
// Importing DBConfig.php file.
    include 'dbconnect.php';
    include 'whatsapp_api.php';

$id =$_POST['id'];
$sql = "SELECT cus_userId,cus_name,cus_email,cus_phone,week_no,link FROM `customer` left join week_report on id='". $id ."' where id='". $id ."' limit 2";
 echo $sql;

$res = mysqli_query($con,$sql);
$rowcount=mysqli_num_rows($res);
if($rowcount >0)
{
	while($row = mysqli_fetch_array($res))
	{
	
                 $name=$row[1];
                 $email=$row[2];
                 $phone=$row[3];
                 $week_no=$row[4];
                 $link=$row[5];
                  echo $name; 
                send_whatsapp_weekupdatefromigiver($name,"7200011175",$week_no,$link);
                  
    }
}
	
	
	

//Insert count - Track NGO performance
mysqli_close($con);
 
?>