<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
	
    // Optionally, you can give it a desired string length.
	$cust_id        =$_POST['cust_id'];
	$ename          =$_POST['ename'];
	$edate          =$_POST['edate'];
	$evideo         =$_POST['evideo'];
	$eaudio         =$_POST['eaudio'];
	$epdfdoc        =$_POST['epdfdoc'];
	$ephoto1        =$_POST['ephoto1'];
	$ephoto2        =$_POST['ephoto2'];
	$ephoto3        =$_POST['ephoto3'];
	$ephoto4        =$_POST['ephoto4'];	
	$edesc          =$_POST['edesc'];
	$status         =1;
	$flag           =1;
	$crdt           =date('y-m-d'); 
	$crby           =$_POST['cust_id'];
	$dndt           =date('y-m-d');
	$dnby           =$_POST['cust_id'];
	$globaleventtagid = $_POST['globaleventtagid'];
	$ngouserid = $_POST['ngouserid'];
$sqlquery="insert into event (cust_id,ename,edate,evideo,eaudio,epdfdoc,ephoto1,ephoto2,ephoto3,ephoto4,edesc,status,flag,crdt,crby,dndt,dnby, globaleventtagid, ngouserid) values ('$cust_id','$ename','$edate','$evideo','$eaudio','$epdfdoc','$ephoto1','$ephoto2','$ephoto3','$ephoto4','$edesc','$status','$flag','$crdt','$crby','$dndt','$dnby','$globaleventtagid','$ngouserid') ";

    $r=mysqli_query($con,"insert into event (cust_id,ename,edate,evideo,eaudio,epdfdoc,ephoto1,ephoto2,ephoto3,ephoto4,edesc,status,flag,crdt,crby,dndt,dnby, globaleventtagid, ngouserid) values ('$cust_id','$ename','$edate','$evideo','$eaudio','$epdfdoc','$ephoto1','$ephoto2','$ephoto3','$ephoto4','$edesc','$status','$flag','$crdt','$crby','$dndt','$dnby','$globaleventtagid','$ngouserid') ");


 
    if($r){
    $last_id = mysqli_insert_id($con);
       $r2 = "Select eid from event where eid ='".$last_id."'";
       $value = mysqli_query($con,$r2);
       while($cust_res = mysqli_fetch_row($value)){
    	   $ctk = $cust_res[0];
       }
       
        $json['success'] = $ctk;
    	    
    }else{
		$json['error'] = $sqlquery;
	
	}
	echo json_encode($json);
	mysqli_close($con);
?>