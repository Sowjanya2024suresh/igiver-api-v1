<?php
// Importing DBConfig.php file.
include 'dbconnect.php';

$cusuid = $_GET['id'];
$prid = $_GET['id1'];
$cureqid = $_GET['id2'];
//echo $cusuid."dsd"; 
//echo $prid."p"; 
//echo $cureqid."r"; 

$sql = "UPDATE product_bids SET pro_sold='0',pro_awarded='$cureqid' WHERE pro_cus_id='$cusuid' and pro_user_id='$prid' and cus_id='$cureqid'";
		//echo $sql;
		//echo "<br/>";
		$res = mysqli_query($con,$sql);
           //$r=mysqli_query($con,"UPDATE customer
        //SET cus_name=$cusName,cus_email=$cusEmail,cus_phone=$cusPhone WHERE cus_userId=$cusuid");
		if($res){
			$json= 1;
		}else {
			$json= 0;
		}
	$sql4 = "Select pro_user_title from product_user WHERE pro_user_id='$prid'";
	$res4 = mysqli_query($con,$sql4);
	while($row4 = mysqli_fetch_array($res4)){
		$prdname =$row4[0];
	}
	//echo $prdname;
	//echo "</br>";
	
	$sql1 = "Select cus_id from product_bids WHERE pro_cus_id='$cusuid' and pro_user_id='$prid'";
	$res1 = mysqli_query($con,$sql1);
	while($row = mysqli_fetch_array($res1)){
	$cusID = $row[0];
		$sql2 = "UPDATE product_bids SET pro_sold='0'WHERE pro_cus_id='$cusuid' and pro_user_id='$prid' and cus_id='$cusID'";
		//echo $sql2;
		$res2 = mysqli_query($con,$sql2);
			$queryG = "SELECT * FROM gcm_token where cus_role='1' and cus_uid='".$cusID."'";
			//echo $queryG;
			$resultG = mysqli_query($con,$queryG) ;
			///$res1 = mysqli_num_rows($result1);
			//echo "THTHTH".($res1)."<br />";
			while($resG = mysqli_fetch_array($resultG)){
				//echo $res['gcm_tokenid']."<br/>";
				 $cusIDG =$resG['cus_uid'];
				 $reg_tokenG =$resG['gcm_tokenid'];
				 //echo $cusIDG."jf 0".$cureqid;
				 if($cusIDG == $cureqid){
					 //echo $prdname;
					 $notImage = $prdname;
					 //$notImage ="Award";
					 //send_gcm_notify1($reg_tokenG, $notImage, $notTitle);
				 }else{
						$notImage = $prdname;
						//$notTitle = "okk";
						//send_gcm_notify($reg_tokenG, $notImage, $notTitle);
				 }
			}
	}
	$sql3 = "UPDATE product_user SET flag='0' WHERE pro_user_id='$prid'";
	$res3 = mysqli_query($con,$sql3);
 
echo json_encode($json);

function send_gcm_notify($reg_id, $bidprdname, $dumy) {
	
		//define("GOOGLE_API_KEY", "AIzaSyDn5cmOSNRLrvkQkfM5faJGZpOUpSOTnDg");
		define("GOOGLE_API_KEY", "AIzaSyA6GfHjmq6v_3s-wikqMs1gf075eYMeUw8");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "Bid Closed", "body" => "Product Name is: ".$bidprdname, "tag" => "HJello" ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "noti1"),
			'data'						=> array("bidsdet" =>$bidprdname, "image1"=> "Closed"),
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
		//echo "<br>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        //echo $result;
    }
	
	function send_gcm_notify1($reg_id, $bidprdname, $dumy) {
	
		//define("GOOGLE_API_KEY", "AIzaSyDn5cmOSNRLrvkQkfM5faJGZpOUpSOTnDg");
		define("GOOGLE_API_KEY", "AIzaSyA6GfHjmq6v_3s-wikqMs1gf075eYMeUw8");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "Congrats! Bid Awarded", "body" => "Product Name is: ".$bidprdname, "tag" => $tag ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "noti1"),
			'data'						=> array("bidsdet" =>$bidprdname, "image1"=> "Awarded"),
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
		//echo "<br>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        //echo $result;
    }
	

 
mysqli_close($con);
 
?>