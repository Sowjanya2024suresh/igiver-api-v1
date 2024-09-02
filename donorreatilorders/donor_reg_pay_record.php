
<?php
// required headers
header("Access-Control-Allow-Origin: *");

  
	// Importing DBConfig.php file.
    include '../dbconnect.php';

	 
	function generateRandomString($length = 4) 
	{
    	$characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
     if($_SERVER['REQUEST_METHOD']==='POST' && empty($_POST)) {
   $_POST = json_decode(file_get_contents('php://input'),true); 

     }
    
    
	$cusName=$_POST['name'];
	$cusPhone=$_POST['mobile'];
	$cusemail = $_POST['email'];
	$crtdate=date('y-m-d');
	$moddate=date('y-m-d');
	$status='1';
	$flag='1';
	$cusRoles = '0';
	$cusUserID = "DON".generateRandomString();
// 	echo " Ph".$cusPhone;
	$sql1="Select * from customer where cus_phone ='".$cusPhone."' and cus_role=0";
     echo $sql1;
    $cust = mysqli_query($con,$sql1);
      $cust_res = mysqli_fetch_row($cust);
    //   echo "$cust_res=".$cust_res;
        $existing_cust_id=$cust_res[0];
         echo " Existing id :  ".$existing_cust_id;
        if($cust_res==""){
    			if($cusName !=""){
    			    $sql2="insert into customer (cus_userId,cus_name,cus_email,cus_phone,cus_role,crtd_date,modi_date,status,flag,verification_status,cus_cpwd) values ('$cusUserID','$cusName','$cusemail','$cusPhone','$cusRoles','$crtdate','$moddate','$status','$flag','1','camp123') ";
                    echo $sql2;
                    $r=mysqli_query($con,$sql2);
        		    $last_id = mysqli_insert_id($con);
        		    echo "Success : Inserted";
    		  
    			}
        }
        else
        {
             echo "Success : Already Exist";
        }
    		 
        
	mysqli_close($con);
?>