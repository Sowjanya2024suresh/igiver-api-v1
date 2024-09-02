<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payments/MOJO1c17Z05Q12517610/');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:b2a28665682ad6eaab812396b8e31e5d",
                  "X-Auth-Token:be57326cd160e3c3f2d5a75ca22213c4"));

$response = curl_exec($ch);
curl_close($ch); 

echo $response;

?>