<?php
header('Access-Control-Allow-Origin: *');
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    
	
    // Optionally, you can give it a desired string length.
	$emailid        =$_GET['emailid'];
	$refer_id          =$_GET['custid'];
	$crdt           =date('y-m-d'); 

// echo $emailid;
// echo $refer_id;
$refer_id = str_replace('"', "", $refer_id);
  $sql = "insert into refer_email_id (email_id ,refer_id,create_date) values ('$emailid','$refer_id','$crdt')";
    
        
        // echo $sql;
        $res = mysqli_query($con,$sql);
    
    if($res){
    
        $json['success'] = 1;
    	    
    }else{
		$json['success'] = 0;
	
	}
	echo json_encode($json);
	mysqli_close($con);
?>