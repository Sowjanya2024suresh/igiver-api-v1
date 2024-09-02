<?php
    //ob_start();
 
	// Importing DBConfig.php file.
    include '../dbconnect.php';
    
    /**
     * JSON data to html table
     * 
     * @param object $data
     * 
     */
     function jsonToTable ($data)
    {
        $table = '
        <table  cellpadding="0" cellspacing="0" border="0" width="100%" >
        ';
        foreach ($data as $key => $value) {
            $table .= '
            <tr valign="top">
            ';
            if ( ! is_numeric($key)) {
                $table .= '
                <td width="40%" colspan="2" style=" line-height: 20px;
    text-align: left;
    font-size: 12px;
    padding: 0.5% 4%;
	    opacity: 0.9;">
                    <strong>'. $key .':</strong>
                </td>
                <td>
                ';
            } else {
                $table .= '
                <td width="40%" colspan="2" style=" line-height: 20px;
    text-align: left;
    font-size: 12px;
    padding: 0.5% 4%;
	    opacity: 0.9;">
                ';
            }
            if (is_object($value) || is_array($value)) {
                $table .= jsonToTable($value);
            } else {
                $table .= $value;
            }
            $table .= '
                </td>
            </tr>
            ';
        }
        $table .= '
        </table>
        ';
        return $table;
    }
	 
	 
	 
	 
	function send_email($toemail,$towhom,$orderid,$orderdetailarray,$NgoDetailArray,$DonorDetailArray,$ngoname)
    {
        
    
        //Mail function
       $tableorder= jsonToTable(json_decode($orderdetailarray));
 
       $tableNgo= jsonToTable(json_decode($NgoDetailArray));
       $tableDonor= jsonToTable(json_decode($DonorDetailArray));
       
       
       
       $toemail="raghav@lokas.in";
       $headmsg="";
       $successmessage="";
       $tablecontent='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%;background:#4e3b45">
                                                   <tr>
                                                      <td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%;">
														    ';
														 
                                            if($towhom != "NGO"){  $tablecontent .='<table width="100%"  style="max-width: 380px;
    background: #fff;
    margin: 5% auto;
    width: 80%;
    border-top: 4px solid #ff5c6d;
    border-radius: 8px;border-top: 4px solid #806b6d">
														  
                                                            <tbody>
															<tr><td colspan="2"><h3 style="color: #161515;
                                                font-family:cuprum;
                                                font-size: 28px;
                                                text-align: center;
                                                font-weight: 800;line-height:0px;">
                                               NGO Details
                                             </h3></td>
															</tr>
															  '.$tableNgo.'
                                                           </tbody>
                                                         </table>'; }
												$tablecontent .='		 </td></tr></table>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%;background:#806b6d">
                                                   <tr>
                                                      <td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
														  ';
														 
                                            if($towhom == "NGO" || $towhom == "ADMIN"){ 
                                            
                                             $tablecontent .='<table width="100%" style=" 	max-width: 380px;
    background: #fff;
    margin: 5% auto;
    width: 80%;
    border-top: 4px solid #ff5c6d;
    border-radius: 8px;" >
														  
                                                            <tbody>
															<tr><td colspan="2"><h3 style="color: #161515;
                                                font-family:cuprum;
                                                font-size: 28px;
                                                text-align: center;
                                                font-weight: 800;line-height:0px">
                                               Donor Details
                                             </h3></td>
															</tr>
															'.$tableDonor.'
                                                  </tbody>
                                                         </table>'; }
                                             
                                             $tablecontent .='</td>
                                            
                                             </tr>
                                             </table>';
                                           
       if($towhom=="DONOR")
       {
           $headmsg='Payment Successful from iGiver.Org ';
           $successmessage=' <div class="h3-white-center" style="color: #ff5c6d;
                                                 font-family:Arial,sans-serif; 
                                                font-size: 34px;
                                                line-height: 40px;
                                                text-align: center;
                                                font-weight:600;">
                                                <multiline>Thank you for your order<br>Payment Successful</multiline>
                                             </div>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                <tr>
                                                   <td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                                </tr>
                                             </table>
                                             <div class="text-white-center" style="color:#000; font-family:Arial,sans-serif; font-size:12px; line-height:20px; text-align:center;padding: 0 8%;">
                                                <multiline>Thank you for your donation to '.$ngoname.'. We are thrilled to have your support. Through your donation you truly make the difference for us, and we are extremely grateful!<br><img src="https://lokas.in/Igiver-nl/images/happy.png"></multiline>
                                             </div>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                <tr>
                                                   <td height="20" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                                </tr>
                                             </table>
                                           ';
       }
       else if($towhom=="RETAILER")
       {
           $successmessage='<div class="h3-white-center" style="color: #ff5c6d;
                                                 font-family:Arial,sans-serif; 
                                                font-size: 34px;
                                                line-height: 40px;
                                                text-align: center;
                                                font-weight:600;">
                                                <multiline>You got new order for Wallet Transfer</multiline>
                                             </div>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                <tr>
                                                   <td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                                </tr>
                                             </table>
                                             <div class="text-white-center" style="color:#000; font-family:Arial,sans-serif; font-size:12px; line-height:20px; text-align:center;padding: 0 8%;">
                                                <multiline>You got order for Wallet transfer to '.$ngoname.'\' Big Basket Wallet. Please find the details below and Proceed Next Proccess to reach the fund in respective users wallet.<br><img src="https://lokas.in/Igiver-nl/images/happy.png"></multiline>
                                             </div>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                <tr>
                                                   <td height="20" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                                </tr>
                                             </table>';
           $headmsg='Order Paid from iGiver.Org for '.$ngoname;
       }else if($towhom=="NGO")
       {
           // $tablecontent='';
            $successmessage='<div class="text-white-center" style="color:#000; font-family:Arial,sans-serif; font-size:12px; line-height:20px; text-align:center;padding: 0 8%;">
                                                <multiline><img src="https://lokas.in/Igiver-nl/images/happy.png"></multiline>
                                             </div>';
            $headmsg='You got Donation in Big Basket Wallet from iGiver.Org ';
       }else  if($towhom=="ADMIN")
       {
           // $tablecontent='';
            $successmessage='<div class="text-white-center" style="color:#000; font-family:Arial,sans-serif; font-size:12px; line-height:20px; text-align:center;padding: 0 8%;">
                                                <multiline><img src="https://lokas.in/Igiver-nl/images/happy.png"></multiline>
                                             </div>';
            $headmsg='Big Basket Wallet Settlement full filled from iGiver.Org ';
       }
// 		require("../PHPMailer/class.phpmailer.php");
        require_once('../PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
			$mail->IsSMTP();
    				$mail->Host = "smtp.gmail.com"; 
    				$mail->Port = 587;
    				//$mail->SMTPDebug = 2; 
    			    // used only when SMTP requires authentication   
    				$mail->SMTPAuth = true;		
    				$mail->Username = "support@lokas.in";
    				$mail->Password = "LokasG@2020"; 
    				$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$mail->AddAddress($toemail); // recipients email
	    $mail->AddCC('support@lokas.in'); // recipients email
		$mail->From = 'info@igiver.org';
		$mail->FromName = 'iGiver.Org Support Team'; // readable name
		$mail->Subject =$headmsg.$orderid;  
		$message=$headmsg.$orderid;
		$headContent=$headmsg; //header


	$mail->Body .='<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="format-detection" content="date=no" />
      <meta name="format-detection" content="address=no" />
      <meta name="format-detection" content="telephone=no" />
      <title>Email Template</title>
       <link rel="stylesheet" href="css/simple.css">
      <style type="text/css">
         @font-face {
         font-family: "Cuprum", sans-serif;
         src: url("/images/cuprum-bold.ttf") format("ttf");
         }
         /* Linked Styles */
         body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#eae8e1; -webkit-text-size-adjust:none }
         a { color:#509c2b; text-decoration:none }
         p { padding:0 !important; margin:0 !important } 
         img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer Section*/ } 
         /* Mobile styles */
         @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) { 
		 .gallery img{width: 100% !important;
    max-width: 100% !important;}
         div[class="mobile-br-2"] { height: 2px !important; }
         div[class="mobile-br-5"] { height: 5px !important; }
         div[class="-br-10"] { height: 10px !important; }
         div[class="mobile-br-15"] { height: 15px !important; }
         div[class="mobile-br-25"] { height: 25px !important; }
         th[class="m-td"], 
         td[class="m-td"], 
         div[class="hide-for-mobile"], 
         span[class="hide-for-mobile"] { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }
         span[class="mobile-block"] { display: block !important; }
         div[class="img-m-center"] { text-align: center !important; }
         td[class="text-top"],
         td[class"text-top2"],
         td[class="text-top-l"] 
         td[class="text-table"] 
         td[class="text-right"] 
         div[class="h4-white-c"],
         div[class="text-white-c"],
         div[class="text-white2-c"],
         div[class="text-white3-"],
         div[class="text-grey-right"],
         div[class="text-grey"],
         div[class="text-top"],
         div[class="text-top2"],
         div[class="text-white-right"],
         div[class="text-white-footer"],
         div[class="text-top-l"] { text-align: center !important; }
         div[class="text-table"] { font-size: 10px !important; }
         div[class="text-right"] { font-size: 10px !important; }
         div[class="fluid-img"] img,
         td[class="fluid-img"] img { width:50%; max-width: 50%; height: auto !important; }
         table[class="mobile-shell"] { width: 100%; min-width: 100%; }
         table[class="center"] { margin: 0 auto; }
         table[class="left"] { margin-right: auto; }
         th[class="column-top"],
         th[class="column-rtl"],
         th[class="column"] { float: left !important; width: 100% !important; display: block !important; }
         td[class="td"] { width: 100% !important; min-width: 100% !important; }
         td[class="w50"] { width: 50% !important; }
         td[class="mw1"] { width: 110px !important; }
         td[class="mw2"] { width: 110px !important; }
         td[class="mw3"] { width: auto !important; }
         td[class="content-spacing"] { width: 15px !important; }
         td[class="content-spacing2"] { width: 8px !important; }
         } 
         table.table-data  td {
   line-height: 50px;
    tlign: left;
    font-sizext-ae: 12px;
    padding: 0.5% 4%;
	    opacity: 0.9;
}
.table-data {
	max-width: 380px;
    background: #fff;
    margin: 5% auto;
    width: 80%;
    border-top: 4px solid #ff5c6d;
    border-radius: 8px;
}
table.table-data  tr:nth-child(even) {
    background: #e2e2e2;
}
table.table-data td strong{text-transform:capitalize;}

      </style>
   </head>
   <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#eae8e1; -webkit-text-size-adjust:none">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eae8e1">
      <tr>
         <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>
         <td align="center" valign="top">
            <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
               <tr>
                  <td class="td" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0">
                     <!-- Header -->
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                           <td>
                              <div class="hide-for-mobile">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                    <tr>
                                       <td height="20" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                    </tr>
                                 </table>
                              </div>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                 <tr>
                                    <td height="20" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                 </tr>
                              </table>
                            
                            
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                 <tr>
                                    <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                                    <td>
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                          <tr>
                                             <td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <!-- Column -->
                                             <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="205">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                   <tr>
                                                      <td class="img" style="font-size:0pt; line-height:0pt; text-align:left">
                                                         <div class="img-m-center" style="font-size:0pt; line-height:0pt"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/logo.png" editable="true" border="0" width="133" height="45" alt="" /></a></div>
                                                         <div style="font-size:0pt; line-height:0pt;" class="mobile-br-15"></div>
                                                      </td>
                                                   </tr>
                                                </table>
                                             </th>
                                             <!-- END COlumn -->
                                             <!-- Column -->
                                             <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                   <tr>
                                                      <td class="text-top2" style="color:#666666; font-family:Arial,sans-serif; font-size:11px; line-height:15px; text-align:right; text-transform:uppercase">
                                                         <multiline>
                                                            <a href="https://igiver.org/all-campaigns/" target="_blank" class="link-grey2-u" style="color:#666666; text-decoration:underline"><span class="link-grey2-u" style="color:#666666; text-decoration:underline">Current Campaign<span></a>
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                                            <a href="https://igiver.org/journey/" target="_blank" class="link-grey2-u" style="color:#666666; text-decoration:underline"><span class="link-grey2-u" style="color:#666666; text-decoration:underline">Our Journey</span></a>
                                                            &nbsp; &nbsp; &nbsp; &nbsp; 
                                                         </multiline>
                                                      </td>
                                                   </tr>
                                                </table>
                                             </th>
                                             <!-- END COlumn -->
                                          </tr>
                                       </table>
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                          <tr>
                                             <td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                          </tr>
                                       </table>
                                    </td>
                                    <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <!-- END Header -->
                     <repeater>
                        <!-- Section 2 -->
                        <layout label="Section 2">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td>
                                    <!-- Head -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff">
                                       <tr>
                                         
                                          <td>
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                <tr>
                                                   <td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td>
                                                </tr>
                                             </table>
                                            '.$successmessage.'
                                             
                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%;background:#806b6d">
                                                   <tr>
                                                      <td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">
                                                         <table width="100%" style=" 	max-width: 380px;
    background: #fff;
    margin: 5% auto;
    width: 80%;
    border-top: 4px solid #ff5c6d;
    border-radius: 8px;" >
														  
                                                            <tbody>
															<tr><td colspan="2"><h3 style="color:#161515;
                                                font-family:cuprum;
                                                font-size: 28px;
                                                text-align: center;
                                                font-weight: 800;line-height:0px">
                                               Order Details
                                             </h3></td>
															</tr>
                                                              '.$tableorder.'
                                                            </tbody>
                                                         </table>
														 </td>
														 </tr>
														 </table>
 
 '.$tablecontent.'
 
                                             <!-- END Head -->
                                          </td>
										 
                                       </tr>
                                    </table>
                        </layout>
                        <!-- END Section 2 -->
                        <!-- Section 3 -->
                        <layout label="Section 3">
                        <tablewidth="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td bgcolor="#fff" valign="top" height="100">
                        <div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                        <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                        <td align="center" height="100">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <div class="h3-white-center" style="color: #000;
                           font-family: serif;
                           font-size: 34px;
                           line-height: 40px;
                           text-align: center;
                           font-weight: 800;">
                        <multiline>We Believe<br><small style="color: 000;
                           font-family: serif;
                           font-size: 18px;
                           line-height: 32px;
                           text-align: center;
                           font-weight: 800;">Giving is the celebration of life</small></multiline>
                        </div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="5" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        </td>
                        <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                        </tr>
                        </table>
                        </div>
                        <!--[if gte mso 9]>
                        </v:textbox>
                        </v:rect>
                        <![endif]-->
                        </td>
                        </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="2" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        </layout>
                        <!-- END Section 3 -->
                        <!-- Section 5 -->
                        <layout label="Section 5">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:-20px;">
                        <tr>
                        <td  bgcolor="#fff" style="padding: 0 2%;">
                        <!-- Three Columns -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <!-- Column -->
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="25%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td>
                        <div class="fluid-img"><a href="https://igiver.org/"><img src="https://lokas.in/Igiver-nl/images/d1.png" width="100%"/></a></div>
                        </td>
                        </tr>
                        </table>
                        </th>
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="25%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td>
                        <div class="fluid-img"><a href="https://igiver.org/"><img src="https://lokas.in/Igiver-nl/images/d2.png" width="100%"/></a></div>
                        </td>
                        </tr>
                        </table>
                        </th>
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="25%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td>
                        <div class="fluid-img"><a href="https://igiver.org/all-campaigns/"><img src="https://lokas.in/Igiver-nl/images/d3.png" width="100%"/></a></div>
                        </td>
                        </tr>
                        </table>
                        </th>
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="25%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td>
                        <div class="fluid-img"><a href="https://igiver.org/"><img src="https://lokas.in/Igiver-nl/images/d4.png" width="100%"/></a></div>
                        </td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        </tr>
                        </table>
                        <!-- END Three Columns -->
                        </td>
                        </tr>
                        </table>
                        </layout>
                        <!-- END Section 5 -->
                        <!-- Section 4 -->
                        <layout label="Section 4">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="gallery">
                        <tr>
                        <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                        <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <div class="h3-center" style="color:#383838; font-family:Arial,sans-serif; font-size:26px; line-height:30px; text-align:center"><multiline><strong>On Reach of your kindness</multiline></div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <!-- Row 1 -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/g1.jpg" editable="true" border="0" width="195" height="160" alt="" /></a></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="2"><div style="font-size:0pt; line-height:0pt;" class="mobile-br-2"></div>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/g2.jpg" editable="true" border="0" width="195" height="160" alt="" /></a></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="2"><div style="font-size:0pt; line-height:0pt;" class="mobile-br-2"></div>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/g3.jpg" editable="true" border="0" width="195" height="160" alt="" /></a></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="2" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <!-- END Row 1 -->
                        <!-- Row 2 -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/g4.jpg" editable="true" border="0" width="195" height="160" alt="" /></a></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="2"><div style="font-size:0pt; line-height:0pt;" class="mobile-br-2"></div>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><img src="https://lokas.in/Igiver-nl/images/g5.jpg" editable="true" border="0" width="195" height="160" alt="" /></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0" width="2"><div style="font-size:0pt; line-height:0pt;" class="mobile-br-2"></div>
                        </th>
                        <!-- END COlumn -->
                        <!-- Column -->
                        <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="195">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td><div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left"><img src="https://lokas.in/Igiver-nl/images/g6.jpg" editable="true" border="0" width="195" height="160" alt="" /></div></td>
                        </tr>
                        </table>
                        </th>
                        <!-- END COlumn -->
                        </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="2" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        <!-- END Row 2 -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="50" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                        </td>
                        <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                        </tr>
                        </table>
                        </layout>
                        <!-- END Section 4 -->
                     </repeater>
                     <!-- Footer -->
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#806b6d">
                     <tr>
                     <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                     <td>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="30" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <!-- Column -->
                     <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0" width="270">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td>
                     <div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
                     <div class="img-m-center" style="font-size:0pt; line-height:0pt"><a href="#" target="_blank"><img src="https://lokas.in/Igiver-nl/images/logo-w.png" editable="true" border="0" width="140" height="47" alt="" /></a></div>
                     </div>
                     <div style="font-size:0pt; line-height:0pt;" class="mobile-br-15"></div>
                     </td>
                     </tr>
                     </table>
                     </th>
                     <!-- END COlumn -->
                     <!-- Column -->
                     <th class="column-top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top; Margin:0">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td align="right">
                     <!-- Socials -->
                     <table class="center" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                                                               <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="34"><a href="https://www.facebook.com/iGiver" target="_blank"><img src="https://lokas.in/Igiver-nl/images/fb.png" editable="true" border="0" width="16" height="16" alt="" /></a></td>
                                                               <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="34"><a href="https://twitter.com/igiverworld" target="_blank"><img src="https://lokas.in/Igiver-nl/images/twitter.png" editable="true" border="0" width="16" height="16" alt="" /></a></td>
															    <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="34"><a href="https://www.linkedin.com/company/igiver/" target="_blank"><img src="https://lokas.in/Igiver-nl/images/linkedin.png" editable="true" border="0" width="16" height="16" alt="" /></a></td>
                                                               <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="34"><a href="https://www.instagram.com/igiverworld/" target="_blank"><img src="https://lokas.in/Igiver-nl/images/instagram.png" editable="true" border="0" width="16" height="16" alt="" /></a></td>
                                                               <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="34"><a href="https://www.youtube.com/igiverworld" target="_blank"><img src="https://lokas.in/Igiver-nl/images/youtube.png" editable="true" border="0" width="16" height="16" alt="" /></a></td>
                                                            </tr>
                     </table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="25" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                     <!-- END Socials -->
                     <div class="text-white-right" style="color:#ffffff; font-family:Arial,sans-serif; font-size:12px; line-height:18px; text-align:right">
                     <multiline>
                     
                     <a href="https://igiver.org/" target="_blank" class="link-white-u" style="color:#ffffff; text-decoration:underline"><span class="link-white-u" style="color:#ffffff; text-decoration:underline">www.igiver.org</span></a> &nbsp; <a href="mailto:info@igiver.org" target="_blank" class="link-white-u" style="color:#ffffff; text-decoration:underline"><span class="link-white-u" style="color:#ffffff; text-decoration:underline">info@igiver.org</span></a>
                     </multiline>
                     </div>
                     </td>
                     </tr>
                     </table>
                     </th>
                     <!-- END COlumn -->
                     </tr>
                     </table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="8" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" dir="rtl" style="direction: rtl;">
                     <tr>
                     <!-- Column -->
                     <th class="column-rtl" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0; direction:ltr" >
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td>
                     <div class="text-white-right" style="color:#ffffff; font-family:Arial,sans-serif; font-size:12px; line-height:18px; text-align:right">
                     <multiline>Phone: <a href="tel:+1123456789" target="_blank" class="link-white" style="color:#ffffff; text-decoration:none"><span class="link-white" style="color:#ffffff; text-decoration:none">+91 72000 11175</span></a></multiline>
                     </div>
                     </td>
                     </tr>
                     </table>
                     </th>
                     <!-- END COlumn -->
                     <!-- Column -->
                     <th class="column-rtl" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0; direction:ltr" width="270">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td>
                     <div class="text-white-footer" style="color:#ffffff; font-family:Arial,sans-serif; font-size:12px; line-height:18px; text-align:left"><multiline>Copyright &copy; 2021 Igiver</multiline></div>
                     </td>
                     </tr>
                     </table>
                     </th>
                     <!-- END COlumn -->
                     </tr>
                     </table>
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%"><tr><td height="15" class="spacer" style="font-size:0pt; line-height:0pt; text-align:center; width:100%; min-width:100%">&nbsp;</td></tr></table>
                     </td>
                     <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                     </tr>
                     </table>
                    
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                     <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="30"></td>
                     <td>
                     
                     </td>
                     </tr>
                     </table>
                     </td>
                     </tr>
                     </table>
                  </td>
                  <td class="content-spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>
               </tr>
            </table>
   </body>
</html>';


        // Sending email
        if($mail->send())
        {
            $mail->ClearAllRecipients();
           echo 'Email sent';
        } 
        else
        {
            echo 'Unable to send email. Please try again.';
        }
        
    }
	 
	 
	 
$ngoname="";
$ngoemail="";
$donoremail="";
    $orderid=$_GET['orderid'];
    //echo $orderid."</BR>";
   $orderid="MOJO1901W05N83931265";
   // echo $orderid;
    //Check if this gen orderid exists
    //Order Details
    // "SELECT  `orderid`, `order_desc`, `order_amount`, `order_qty`, `order_sku`, `ngoid`, `donorid`, `orderdate`, `order_source`, `overall_status`, `paystatus`, `pay_ref_no`, `delivery_ref_no`, `flag`, `thanks_video_status`, `thanks_video_link`, `createdate`, `updatedate` ,`retail_code` FROM `donor_retail_orders` WHERE orderid='".$orderid."'"
    $sql1 = "SELECT `orderid`, `donor_id`, `ngo_id`, `wallet_retailer_id`, `amount`, `date_donated`, `transfered_status`, `payrequetId`, `settlement_id`, `settlement_date`, `settlement_name`, `settlement_status`, `mojo_id` FROM `wallet_donor_transaction` WHERE `mojo_id`='".$orderid."'";
    //echo $sql1;
    $resorderdetail = mysqli_query($con,$sql1);
    
     if($resorderdetail)
    {
    	while($row = mysqli_fetch_array($resorderdetail))
    	{
    	   
    	    
    		$NGOid=$row['ngo_id'];
    		$donorid=$row['donor_id'];
    		$retail_code=$row['wallet_retailer_id'];
    		$order_sku=$row['orderid'];
    		// echo "SELECT `name`,`retail_code`,`email`,`phone`,`legal_name` FROM `wallet_retailer_details` WHERE  id='$retail_code'";
    		$retailerdetails = mysqli_fetch_array(mysqli_query($con, "SELECT `name`,`retail_code`,`email`,`phone`,`legal_name` FROM `wallet_retailer_details` WHERE  id='$retail_code'"));
    		$ngoDetails = mysqli_fetch_array(mysqli_query($con, "SELECT `cus_name`,`cus_email`,`cus_phone` FROM `customer` WHERE  cus_userId='$NGOid'"));
    		$orderdesc = 'Donation on Big Basket Wallet For '.$ngoDetails['cus_name'];
           //  print_r($retailerdetails);
            // exit;
            $orderdetailarray[] =array('Order Id'=>$row[0],'Description'=>$orderdesc,'Amount'=>$row[4],'NGO ID'=>$row[2],'Donor Id'=>$row[1],'Donated Date'=>$row[5],'Transfer Status'=>$row[6]==1?'Success':'Fail','Settlement Status'=>$row[11]=1?'Success':'Fail','Payment Ref No'=>$row[12],'Settlement Ref No'=>$row[8],'Bigbasket Wallet Code'=>$retailerdetails['retail_code']);
        
    	    
    	}
       
        //echo 	$retail_code."Order Details</BR>";
        //print_r(json_encode($orderdetailarray));
        
        //Replace Order  SKU
        //$samplejson="{\r\n    \"set_paid\": false,\r\n    \"currency\": \"INR\",\r\n    \"billing\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\",\r\n        \"email\": \"john.doe@example.com\",\r\n        \"phone\": \"(555) 555-5555\"\r\n    },\r\n    \"shipping\": {\r\n        \"first_name\": \"John\",\r\n        \"last_name\": \"Doe\",\r\n        \"address_1\": \"969 Market\",\r\n        \"address_2\": \"\",\r\n        \"city\": \"JAIPUR\",\r\n        \"state\": \"RAJ\",\r\n        \"postcode\": \"302001\",\r\n        \"country\": \"IN\"\r\n    },\r\n    \"line_items\": [\r\n        {\r\n            \"product_id\": SKU_ID,\r\n            \"quantity\": 1\r\n            \r\n        }\r\n    ],\r\n    \"shipping_lines\": [\r\n        {\r\n            \"method_id\": \"free_shipping\",\r\n            \"method_title\": \"Free shipping\",\r\n            \"total\": \"0.00\"\r\n        }\r\n    ],\r\n    \"meta_data\": [\r\n        {\r\n            \"key\": \"order_taken_from\",\r\n            \"value\": \"iGiver\"\r\n        },\r\n        {\r\n            \"key\": \"auth_code\",\r\n            \"value\": \"1234567890\"\r\n        }\r\n    ]\r\n}";
        //echo $order_sku;
        // $samplejson=str_replace("SKU_ID",$order_sku,$samplejson);
         $jayParsedAry['line_items'][0]['product_id']=$order_sku;
         
        
        //NGO Detail
        //echo $NGOid."  ".$donorid;
        
        $sqlGetNGODetail = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`, `cus_image`, bigbasket_wallet_id FROM `customer` where cus_userId='".$NGOid."'";
         
        $resNGO = mysqli_query($con,$sqlGetNGODetail);
        
        if($resNGO)
        {
            while($row = mysqli_fetch_array($resNGO))
            {       //NGO_NAME,NGO_CONTACT_NAME,NGO_ADDRESS,NGO_MOBILE
            		$ngo_name=$row['cus_name'];
            		$ngo_address=$row['cus_address'];
            		$ngo_contact_name=$row['cus_contact_name'];
            		$ngo_mobile=$row['cus_phone'];
            		
            		$jayParsedAry['shipping']['first_name']=$ngo_name;
            		$jayParsedAry['shipping']['last_name']=$ngo_contact_name;
            		$jayParsedAry['shipping']['address_1']=$ngo_address;
            		$jayParsedAry['shipping']['address_2']=$ngo_mobile;
            		
            		
            	    /*	$samplejson=str_replace("NGO_NAME",$ngo_name,$samplejson);
            		$samplejson=str_replace("NGO_ADDRESS",$ngo_address,$samplejson);
            		$samplejson=str_replace("NGO_CONTACT_NAME",$ngo_contact_name,$samplejson);
            		$samplejson=str_replace("NGO_MOBILE",$ngo_mobile,$ngo_mobile);
            		
            		  "shipping" => [
                            "first_name" => "Abode of joy", 
                            "last_name" => "Rajakumari", 
                            "address_1" => "No. 11 5th Street Kabali Nagar Athanoor Road Guduvanchery Chengalpattu Kanchipuram - 603001 Landmark NEAR Guduvanchery Railway Station ", 
                            "address_2" => "9176200203", 
                            "city" => "Temp", 
                            "state" => "Temp", 
                            "postcode" => "600011", 
                            "country" => "IN" 
                         ], */
            		
            		
            	
            		$ngoname=$row[2];
            		$ngoemail=$row[3];
                    $NgoDetailArray[] =array('Big Basket Wallet Id'=> $row['bigbasket_wallet_id'],'Igiver NGO Id'=>$row[1],'NGO Name'=>$row[2],'Email'=>$row[3],'Phone'=>$row[4],'Website'=>$row[12],'Contact Name'=>$row[15],'Address'=>$row[16]);
            }
        	//echo "</BR>NGO Details</BR>";
        	//echo $ngo_address;
        	//echo $samplejson;
        	//print_r(json_encode($NgoDetailArray));	
        		
        
        	
        }
       
        //Donor Detail
        //echo $NGOid."  ".$donorid;
        
        $sqlGetDonorDetail = "SELECT `cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`, `cus_image` FROM `customer` where cus_userId='".$donorid."'";
         
        $resDonor = mysqli_query($con,$sqlGetDonorDetail);
       
        if($resDonor){
        	while($row = mysqli_fetch_array($resDonor)){
        	    //DON_NAME,DON_MOBILE, DON_EMAIL
            		$don_name=$row['cus_name'];
            		$don_email=$row['cus_email'];
            		$don_mobile=$row['cus_phone'];
            		
            		$jayParsedAry['billing']['first_name']=$don_name;
            		$jayParsedAry['billing']['email']=$don_email;
            		$jayParsedAry['billing']['phone']=$don_mobile;
            		
            		
            		/*$samplejson=str_replace("DON_NAME",$don_name,$samplejson);
            		$samplejson=str_replace("DON_EMAIL",$don_email,$samplejson);
            		$samplejson=str_replace("DON_MOBILE",$don_mobile,$samplejson);
            		
            		"billing" => [
                         "first_name" => "DON_NAME", 
                         "last_name" => "DON_NAME", 
                         "address_1" => "Temp", 
                         "address_2" => "", 
                         "city" => "", 
                         "state" => "", 
                         "postcode" => "", 
                         "country" => "IN", 
                         "email" => "sowjanyamca1988@gmail.com", 
                         "phone" => "9841200531" 
                      ], */
            		
            		
        		$donoremail=$row[3];
                    $DonorDetailArray[] =array('Igiver Donor Id'=>$row[1],'Donor Name'=>$row[2],'Email'=>$row[3],'Phone'=>$row[4],'Donor Since'=>$row[8]);
        }
        
            //var_dump($jayParsedAry);
	        //exit;
            	
        
        	//echo "</BR>Donor Details</BR>";
        	//print_r(json_encode($DonorDetailArray));	
        	
        }
        
        // print_r($DonorDetailArray);
    	// exit;  
        //Get retailer email and send 
        $toemailretailer='';
       
        $sql =  "SELECT `name`,`retail_code`,`email`,`phone`,`legal_name` FROM `wallet_retailer_details` WHERE  id='$retail_code'";
        //echo $sql;
        
        $res = mysqli_query($con,$sql);
        //$row_cnt=$res->num_rows;
        //printf("Result set has %d rows.\n", $row_cnt);
        
        if($res)
        {
        	while($row = mysqli_fetch_array($res))
        	{
        		
                 $toemailretailer=$row[0];
                 //echo "To email".$toemailretailer;
            }
        }
      
        // echo "orderdetail==".json_encode($orderdetailarray);
        //  echo "NgoDetailArray==".json_encode($NgoDetailArray);
        //   echo "DonorDetailArray==".json_encode($DonorDetailArray);
       // send_email($donoremail,"DONOR",$orderid,json_encode($orderdetailarray),json_encode($NgoDetailArray),json_encode($DonorDetailArray),$ngoname);
      send_email($toemailretailer,"RETAILER",$orderid,json_encode($orderdetailarray),json_encode($NgoDetailArray),json_encode($DonorDetailArray),$ngoname);
     send_email($ngoemail,"NGO",$orderid,json_encode($orderdetailarray),json_encode($NgoDetailArray),json_encode($DonorDetailArray),$ngoname);
     send_email('support@lokas.in',"ADMIN",$orderid,json_encode($orderdetailarray),json_encode($NgoDetailArray),json_encode($DonorDetailArray),$ngoname);
   
   
       
    }
    mysqli_close($con);
    

    
   
    		       

?>