<?php
	// Importing DBConfig.php file.
    include 'dbconnect.php';
	
    $name = $_POST['name']; //image name
    $image = $_POST['image']; //image in string format
	$destination = $_POST['path'];


	$img_name = $name;
    //decode the image
    $decodedImage = base64_decode($image);
	//echo $pcateg."caeg"; 
 
    //upload the image
    //file_put_contents("uploads/".$name.".jpg", $decodedImage);  
	//file_put_contents("donorreatilorders/product_images/retail_partner_logo/".$name, $decodedImage);
	file_put_contents($destination.$name, $decodedImage);
echo $destination.$name;
 
 
?>