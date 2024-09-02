<?php
//echo 'hi';
$donor_name=$_GET['donor_name'];
$donor_phone=$_GET['donor_phone'];
$pay_id=$_GET['pay_id'];

echo $donor_phone."<br>";
echo strlen($donor_phone)."<br>";
$donor_phone = '+91'.substr($donor_phone,-10);
echo $donor_phone."<br>";
//exit;
$POSTFIELDS='{
    "from": {
        "phone_number": "+917358203763"
    },
    "to": [
        {
            "phone_number": "donor_phone"
        }
    ],
    "data": {
        "message_template": {
            "storage": "conversation",
            "namespace": "a1ba721f_50a6_43fd_8098_fe6c2c225c9d",
            "template_name": "order_recieved_final_confirmation",
            "language": {
                "policy": "deterministic",
                "code": "en"
            },
            "rich_template_data": {
                "body": {
                    "params": [
                        {
                            "data": "donor_name"
                        },
                        {
                            "data": "pay_id"
                        }
                    ]
                }
            }
        }
    }
}';
$POSTFIELDS= str_replace("donor_phone",$donor_phone,$POSTFIELDS);
$POSTFIELDS= str_replace("donor_name",$donor_name,$POSTFIELDS);
$POSTFIELDS= str_replace("pay_id",$pay_id,$POSTFIELDS);

echo $POSTFIELDS;
//exit;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.in.freshchat.com/v2/outbound-messages/whatsapp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$POSTFIELDS,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJraWQiOiJjdXN0b20tb2F1dGgta2V5aWQiLCJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmcmVzaGNoYXQiLCJzdWIiOiI0OGM0NGJiZS1lOTcwLTRkOTgtODI1Ni03NjY1MzU3ZDViMzciLCJjbGllbnRJZCI6ImZjLWE3ZmQ5ZmFiLTY1MDktNGZmZC04ZTkyLWQ4ZDRjMjdiNzUxOSIsInNjb3BlIjoiYWdlbnQ6cmVhZCBhZ2VudDpjcmVhdGUgYWdlbnQ6dXBkYXRlIGFnZW50OmRlbGV0ZSBjb252ZXJzYXRpb246Y3JlYXRlIGNvbnZlcnNhdGlvbjpyZWFkIGNvbnZlcnNhdGlvbjp1cGRhdGUgbWVzc2FnZTpjcmVhdGUgbWVzc2FnZTpnZXQgYmlsbGluZzp1cGRhdGUgcmVwb3J0czpmZXRjaCByZXBvcnRzOmV4dHJhY3QgcmVwb3J0czpyZWFkIHJlcG9ydHM6ZXh0cmFjdDpyZWFkIGRhc2hib2FyZDpyZWFkIHVzZXI6cmVhZCB1c2VyOmNyZWF0ZSB1c2VyOnVwZGF0ZSB1c2VyOmRlbGV0ZSBvdXRib3VuZG1lc3NhZ2U6c2VuZCBvdXRib3VuZG1lc3NhZ2U6Z2V0IG1lc3NhZ2luZy1jaGFubmVsczptZXNzYWdlOnNlbmQgbWVzc2FnaW5nLWNoYW5uZWxzOm1lc3NhZ2U6Z2V0IG1lc3NhZ2luZy1jaGFubmVsczp0ZW1wbGF0ZTpjcmVhdGUgbWVzc2FnaW5nLWNoYW5uZWxzOnRlbXBsYXRlOmdldCBmaWx0ZXJpbmJveDpyZWFkIGZpbHRlcmluYm94OmNvdW50OnJlYWQgcm9sZTpyZWFkIGltYWdlOnVwbG9hZCIsImlzcyI6ImZyZXNoY2hhdCIsInR5cCI6IkJlYXJlciIsImV4cCI6MTk0MzY5NDAyNSwiaWF0IjoxNjI4MTYxMjI1LCJqdGkiOiIwYzg2MDYyYy00YmI0LTQyZmQtYmFkNy1lY2U0ZGUxNWVhNzgifQ.OoaDL_H2NccjDZapNQb3RO-WwOMWVENs5YGBOkvfEgw',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>