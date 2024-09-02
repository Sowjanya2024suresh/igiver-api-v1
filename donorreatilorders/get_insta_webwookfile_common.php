<?php
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    include '../whatsapp_api.php';
    
    $paymentid=$_GET['paymentid'];
	$id=$_GET['campid'];
	$retail_code=$_GET['retail_code'];

 
	
    echo "retail_code=".$retail_code;
    echo "campid=".$id;
    echo "paymentid=".$paymentid;

    

    $url='https://www.instamojo.com/api/1.1/payments/'.$paymentid.'/';
    


    $apikey='';
    $apitoken='';
    $sqlxapi = "SELECT x_api_key,x_auth_token FROM `retail_vendor` WHERE retail_code='".$retail_code."'";
    //echo $sqlxapi;
     $res = mysqli_query($con,$sqlxapi);
            	if($res)
            {
              while( $row1 = mysqli_fetch_array($res))
              {
                $apikey="X-Api-Key: ". $row1[0];
                $apitoken="X-Auth-Token: ".$row1[1];
              }
            }

    $sql = "SELECT id,campaign_name,retail_vendor,campaign_desc,unit_price FROM `focus_campaigns` WHERE active='1' and id='".$id."'";
    // echo $sql;
    $respayway = mysqli_query($con,$sql);
    // echo $respayway;
    if($respayway)
    {
         while($row = mysqli_fetch_array($respayway))
     	{
             //$row = mysqli_fetch_array($respayway);
         	$camp_id=$row[0];
         	$camp_name=$row[1];
         	$retail_code=$row[2];
            $unit_price_value=$row[4];
        }
            
    }
        
        
    echo $apikey;
    echo $apitoken;
    echo $camp_id;
    echo $camp_name;
    echo $retail_code;
    echo $unit_price_value;
        

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        $apikey,
        $apitoken,
        
      ),
    ));

    $response = curl_exec($curl);
    
    curl_close($curl);
    //echo $response;
    $data = json_decode($response);
    
    //echo $data->payment->payment_id;
    
    $payment_id= $data->payment->payment_id;
    $payment_status= $data->payment->status;
    $amount= $data->payment->amount;
    $buyer_name= $data->payment->buyer_name;
    $buyer_phone= $data->payment->buyer_phone;
    $buyer_email= $data->payment->buyer_email;
    //$quantity= $data->payment->quantity;
    //$unit_price= $data->payment->unit_price;
    $quantity= $amount / $unit_price_value;
    $unit_price= $unit_price_value;
    $fees= $data->payment->fees;
    
    $billing_instrument= $data->payment->billing_instrument;
    $created_at= $data->payment->created_at;
    
    //echo date( "Y-m-d H:i:s", strtotime($created_at) );
    $date = new DateTime($created_at);
    $result = $date->format('Y-m-d H:i:s');
    echo $result ;

    $sql1="Select * from payment_record where payment_id ='".$payment_id."'";
    
   $cust = mysqli_query($con,$sql1);
   $cust_res = mysqli_fetch_row($cust);
  
   if($cust_res==""){


    $sqlInsert ="INSERT INTO `payment_record`(`camp_id`, `camp_name`,`retail_code`, `payment_id`, `payment_status`, `amount`, `buyer_name`, `buyer_phone`, `buyer_email`, `quantity`, `unit_price`, `fees`, `billing_instrument`, `create_date`) VALUES ('$camp_id','$camp_name',
    '$retail_code','$payment_id','$payment_status','$amount','$buyer_name','$buyer_phone','$buyer_email','$quantity','$unit_price','$fees','$billing_instrument','$result')";
    
    echo $sqlInsert;

    $resultInstert=mysqli_query($con,$sqlInsert);


      // whatsapp send order details to donor,ngo,retailer using whatsapp  
     
      $sql="SELECT (select retail_name from retail_vendor where retail_code=retail_vendor and active='1') as retailname,(select mobile from retail_vendor where retail_code=retail_vendor and active='1') as retailphone,(select cus_name from customer where cus_userId=beneficiary_id) as ngoname,(select cus_phone from customer where cus_userId=beneficiary_id) as ngophone FROM focus_campaigns where id='".$camp_id."'";
           
             $res = mysqli_query($con,$sql);
                    if($res)
                    {
                    	while($row = mysqli_fetch_array($res))
                    	{
                             $retail_name=$row[0];$retail_phone=$row[1];$ngo_name=$row[2];$ngo_phone=$row[3];
                        }
                    }

if($payment_status!="Failed")
{
        send_whatsapp_orderconfirmtodonor($buyer_name,$buyer_phone,$payment_id);
         send_whatsapp_orderplacedtongo($ngo_name,$ngo_phone,$payment_id);
         send_whatsapp_orderplacedtoret($retail_name,$retail_phone,$payment_id); 

         //send email as pdf using serverless
         $data = [
          'ngoid' => $camp_name,
          'name' => $buyer_name,
          'auth' => '123',
          'tempid' => $camp_id,
          'dydata' => $buyer_name,
          'tonumber' => substr($buyer_phone,-10),
          'transactionid' => $payment_id,
          'toemail' => $buyer_email,

      ];
         
          $url="https://yweckh5917.execute-api.us-east-1.amazonaws.com/dev/templatepdf";
      
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $response = curl_exec($curl);
}
   }
   else{
    echo "Payment already exist";
   }
   
        //insert donor record in customer table
     
     $url = 'https://api.igiver.org/v1/donorreatilorders/donor_reg_pay_record.php';

$data = '
{
  "name": '.$buyer_name.',
  "mobile": '.$buyer_phone.',
  "email": '.$buyer_email.'
}
';

$additional_headers = array(                                                                          
   'Accept: application/json',
   'Content-Type: application/json'
);

$ch = curl_init($url);                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers); 

$server_output = curl_exec ($ch);
    //  echo $server_output;  
     

//Add donor details in millionwishes mail subscribe
     
         $url = 'https://www.millionwishes.in/mails/subscribe';
$data = array('name' => $buyer_name, 'api_key' => "1SX6w9F3flVbqGOAbRMi", 'email' => $buyer_email,'list' => "0EJd0UckR892H6cXNwr7yAYw");

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
// echo  "output=".$result;
if ($result === FALSE) { /* Handle error */ } 


// $data = [
//   'ngoid' => $camp_name,
//   'name' => $buyer_name,
//   'auth' => '123',
//   'tempid' => $camp_id,
//   'dydata' => $buyer_name,
//   'tonumber' => substr($buyer_phone,-10),
//   'transactionid' => $payment_id,
//   'toemail' => 'sowjanya@lokas.in',

// ];
 
//   $url="https://yweckh5917.execute-api.us-east-1.amazonaws.com/dev/templatepdf";

//   $curl = curl_init($url);
//   curl_setopt($curl, CURLOPT_POST, true);
//   curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//   $response = curl_exec($curl);

?>