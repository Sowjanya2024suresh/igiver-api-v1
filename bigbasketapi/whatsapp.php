<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.freshchat.com/v2/outbound-messages/whatsapp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "from": 
    {
        "phone_number": "+917358203763"
    },
    "provider": "whatsapp",
    "to": 
    [
        {
            "phone_number": "+917200011175"
        }
    ],
    "data": 
    {
        "message_template": 
        {
            "storage": "conversation",
            "template_name": "welcome_post_registration",
            "namespace": "a1ba721f_50a6_43fd_8098_fe6c2c225c9d",
            "language": 
            {
                "policy": "deterministic",
                "code": "en_US"
            },
            "body": 
            {
                    "params": 
                    [
                        
                        {"data": "Raghav"},
                        {"data": "7200011175"}
                        
                    ]
                
            }
        }
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJraWQiOiJjdXN0b20tb2F1dGgta2V5aWQiLCJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmcmVzaGNoYXQiLCJzdWIiOiJhNmI5ZTk3MC1jNGRkLTQzZGItYTUyNi0zOGI1YzY5NTA2ZTgiLCJjbGllbnRJZCI6ImZjLWMxNjZkNTFhLTg0MjQtNDZiOS05N2VhLTdhNjg4YjI4ZTI1MCIsInNjb3BlIjoiYWdlbnQ6cmVhZCBhZ2VudDpjcmVhdGUgYWdlbnQ6dXBkYXRlIGFnZW50OmRlbGV0ZSBjb252ZXJzYXRpb246Y3JlYXRlIGNvbnZlcnNhdGlvbjpyZWFkIGNvbnZlcnNhdGlvbjp1cGRhdGUgbWVzc2FnZTpjcmVhdGUgbWVzc2FnZTpnZXQgYmlsbGluZzp1cGRhdGUgcmVwb3J0czpmZXRjaCByZXBvcnRzOmV4dHJhY3QgcmVwb3J0czpyZWFkIHJlcG9ydHM6ZXh0cmFjdDpyZWFkIGRhc2hib2FyZDpyZWFkIHVzZXI6cmVhZCB1c2VyOmNyZWF0ZSB1c2VyOnVwZGF0ZSB1c2VyOmRlbGV0ZSBvdXRib3VuZG1lc3NhZ2U6c2VuZCBvdXRib3VuZG1lc3NhZ2U6Z2V0IG1lc3NhZ2luZy1jaGFubmVsczptZXNzYWdlOnNlbmQgbWVzc2FnaW5nLWNoYW5uZWxzOm1lc3NhZ2U6Z2V0IG1lc3NhZ2luZy1jaGFubmVsczp0ZW1wbGF0ZTpjcmVhdGUgbWVzc2FnaW5nLWNoYW5uZWxzOnRlbXBsYXRlOmdldCBmaWx0ZXJpbmJveDpyZWFkIGZpbHRlcmluYm94OmNvdW50OnJlYWQgcm9sZTpyZWFkIGltYWdlOnVwbG9hZCIsImlzcyI6ImZyZXNoY2hhdCIsInR5cCI6IkJlYXJlciIsImV4cCI6MTk0MzQ2NDM3NCwiaWF0IjoxNjI3OTMxNTc0LCJqdGkiOiIxMDE5ZjBjYi1lNTFlLTRlOWEtOGRmNC1jOTg5NGRlY2JjODAifQ.J3-_DvEpf4AlV41UYTilelwC1rJ8MVzFIn3HGLI0d5w',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
