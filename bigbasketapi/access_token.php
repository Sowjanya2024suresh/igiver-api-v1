<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     // For Live mode 
//curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/oauth2/token/');      // For Sandbox mode
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

$payload = Array(
    'grant_type' => 'client_credentials',
    'client_id' => 'uN5yzxLSETADhMK6HtyhWyyr45YdKrZLS6xlijVN',
    'client_secret' => 'HYGzbFApXltF3A1ZCuqjCSqALOtJmaoVkJmW5D5dE1CfDNhSt18rvTKtITxS9eSDrASRQ4tvc4dYOBQ7jbLqwX1s1SH8kPuyND5UTl2kGplJka5E0rZ6YydhefPOZUG2',
    //'scope' => 'virtual-accounts:write'
);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
echo($ch);
$response = curl_exec($ch);
curl_close($ch); 

$decodedText = html_entity_decode($response);
$myArray = array(json_decode($response, true));

$access_token = $myArray[0]["access_token"];

echo $response;

echo '<br>';
echo '<br>';

echo $access_token;

?>