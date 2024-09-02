<?php
 include "dbconnect.php";
   
   
    //$messageTxt = 'We are running a month long Book Donation Mela! To help underprivileged children. Login to the igiver app and see details! ';
   //$messageTxt = 'Kindly check the requirements posted by NGOs nearby!They need your help.';
    $messageTxt = 'New App version Launched. Now you can buy and give books, breakfast, vegetables and groceries from the app, through well known retail brands directly from the app. Update your App now to try it.';
    $img_url='';$res1=0;
         
   $query = "SELECT * FROM gcm_token where cus_role='0' AND cus_uid != 'NULL' AND cus_uid != ''";
    //echo $query;
   // $query = "SELECT * FROM gcm_token where cus_role='0' AND cus_uid = 'DON770'";
    $result1 = mysqli_query($con,$query) ;
    
    $res1 = mysqli_num_rows($result1);
    //echo "qqqqq". $res1 ;
    
    while($res = mysqli_fetch_array($result1))
    {
    	//echo $res['gcm_tokenid']."<br/>";
    	 $reg_token =$res['gcm_tokenid'];
    	 send_gcm_notify($reg_token, $messageTxt, $img_url);
    }
        

    function send_gcm_notify($reg_id, $message, $img_url) {
	
		define("GOOGLE_API_KEY", "AIzaSyCUHIRYYF6RoxTx0qZ9KkQCb0L6k7Fsa-w");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
            
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => "Thank You!", "body" => $message , "tag" => $tag ,"icon" => "pushicon","color" => "#ff8f20","click_action" => "notid" ),
			'data'						=> array("home" =>$message),
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
        echo $result;
    }
 
 



?>