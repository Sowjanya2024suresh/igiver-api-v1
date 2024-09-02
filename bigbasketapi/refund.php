<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
	// Importing DBConfig.php file.
include '../dbconnect.php';
include 'instamarketplaceutilities.php'; 

$mojoid=$_GET['mojoid'];
$amount=$_GET['amount'];
echo $mojoid;
echo $amount;
 $sqlpayway = "SELECT * FROM `insta_marketplace_cred`";
    //echo $sqlpayway;
    $respayway= mysqli_query($con,$sqlpayway);
    $row = mysqli_fetch_array($respayway);
    $client_id = $row['client_id'];
    $client_sceret  = $row['client_secret'];
    $accesstoken_data = get_imjo_access_token($client_id,$client_sceret); 
    if($accesstoken_data['http_code'] == '201' || $accesstoken_data['http_code']=='200')
    {
        $access_token = $accesstoken_data["access_token"];
$ch = curl_init();
$url='https://api.instamojo.com/v2/payments/'.$mojoid.'/refund/';
echo $url;

echo $access_token;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$access_token));

$payload = Array(
    'transaction_id' => 'partial_refund_1',
    'type' => 'TNR',
    'body' => 'Need to refund to the buyer.',
    'refund_amount' => $amount
);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
echo $response ;
curl_close($ch); 
}
?>