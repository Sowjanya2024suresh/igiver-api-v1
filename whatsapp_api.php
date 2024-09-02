<?php
// Importing DBConfig.php file.
include 'dbconnect.php';
 
  function send_otp_whatsapp_sms($cusName,$cusPhone,$otp)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'otp' => $otp
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/sendotp";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
 
  function send_whatsapp_orderconfirmtodonor($cusName,$cusPhone,$orderid)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'orderid' => $orderid
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/sendorderconfirm";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
    
     function send_whatsapp_welcomepostregister($cusName,$cusPhone)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10)
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/welcomepostregister";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
  function send_whatsapp_orderplacedtoret($cusName,$cusPhone,$orderid)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'orderid' => $orderid
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/sendorderplacedtoret";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
    
    function send_whatsapp_thankyouvideo($cusName,$cusPhone,$instamojoid,$vpath)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'instamojoid' => $instamojoid,
    'vpath' => $vpath
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/sendthankyouvideo";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
    
      function send_whatsapp_orderplacedtongo($cusName,$cusPhone,$orderid)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'orderid' => $orderid
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/sendorderplacedtongo";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
    
       function send_whatsapp_weekupdatefromigiver($cusName,$cusPhone,$code,$urlval)
    {
             
            $data = [
    'name' => $cusName,
    'number' => substr($cusPhone,-10),
    'code' => $code,
    'url' => $urlval
];
   
    $url="https://gvf39v5c3a.execute-api.us-east-1.amazonaws.com/dev/weekupdatefromigiver";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    //echo $response;
    }
?>