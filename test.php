<?php
$data = [
    'ngoid' => 'KLDA23',
    'name' => 'sowji',
    'auth' => '123',
    'tempid' => '20',
    'dydata' => 'sowji',
    'tonumber' => substr('9841200531',-10),
    'transactionid' => '123',
    'toemail' => 'sowjanya@lokas.in',

];
   echo $data;
    $url="https://yweckh5917.execute-api.us-east-1.amazonaws.com/dev/templatepdf";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

?>