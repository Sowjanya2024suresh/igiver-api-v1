<?php
    require("class.phpmailer.php");
    $mail = new PHPMailer();

    // ---------- adjust these lines ---------------------------------------
    $mail->Username = "prakashrajto@gmail.com"; // your GMail user name
    $mail->Password = "poorni@prakash"; 
    $mail->AddAddress("thanthonicse@gmail.com"); // recipients email
    $mail->FromName = "Prakash"; // readable name

    $mail->Subject = "Test Mail";
    $mail->Body    = "Testing Purpose"; 
    //-----------------------------------------------------------------------

    $mail->Host = "ssl://smtp.gmail.com"; // GMail
    $mail->Port = 465;
    $mail->IsSMTP(); // use SMTP
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->From = $mail->Username;
    if(!$mail->Send())
        echo "Mailer Error: " . $mail->ErrorInfo;
    else
        echo "Message has been sent";
    ?>