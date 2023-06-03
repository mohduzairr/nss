<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// include 'twilio/sms.php';
require '../vendor/autoload.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require '../vendor/autoload.php';


function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	}elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	}else{
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}
$token = $_POST['h-captcha-response'];

$data = array(
            'secret' => "0xee2e4C8d07fA26D71F26A32fBDB2a70C095F0dAC",
            'response' => $token
        );

$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($verify);
curl_close ($verify);
$data = json_decode($response, true);
if($data["success"] === true ){
	
$ip_adress 	= GetIP();
	
if(@$_POST['fname'] == ""){
	echo "<script>
	alert('First Name is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['lname'] == ""){
	echo "<script>
	alert('Last Name is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['email'] == ""){
	echo "<script>
	alert('Email is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['phone'] == ""){
	echo "<script>
	alert('Phone is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['service'] == ""){
	echo "<script>
	alert('Service is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['pro'] == ""){
	echo "<script>
	alert('Professional Field is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['date'] == ""){
	echo "<script>
	alert('Date is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}
	
if(@$_POST['time'] == ""){
	echo "<script>
	alert('Time is Required');
	window.location.href='../nails.html';
	</script>";
	return false;
}	
	
$fname = addslashes(strip_tags($_POST['fname']));
if ( !preg_match ("/^[a-zA-Z\s]+$/",$fname)) {
    echo "<script>
	alert('Use only Letter in First Name');
	window.location.href='../nails.html';
	</script>";
	return false;
}	
$lname = addslashes(strip_tags($_POST['lname'])); 
if ( !preg_match ("/^[a-zA-Z\s]+$/",$lname)) {
    echo "<script>
	alert('Use only Letter in Last Name');
	window.location.href='../nails.html';
	</script>";
	return false;
}
$sub = "Nova Nails Booking Form";
$email = addslashes(strip_tags($_POST['email']));
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
    echo "<script>
	alert('Email Format is Wrong');
	window.location.href='../nails.html';
	</script>";
	return false;
}
$phone = addslashes(strip_tags($_POST['phone']));
	


$service    = addslashes(strip_tags($_POST['service']));
$pro    = addslashes(strip_tags($_POST['pro']));
$date    = addslashes(strip_tags($_POST['date']));
$time    = addslashes(strip_tags($_POST['time']));
 
 $toEmail    = "toridanielle722@gmail.com";
 $toSMS = "+13046330627";


 

$mail = new PHPMailer(true);
//    $mail->SMTPDebug=3;
// $mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->isSMTP(); // send as HTML
$mail->Host = "webmail.kdetechnology.com"; // SMTP servers
$mail->SMTPSecure = 'ssl';
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Port = 465;
$mail->Username = 'kde@contactform.page';
$mail->Password = '5:+$2|wK~O';
$mail->setFrom("ContactForm@novasalonandspawv.com");
  $mail->addAddress($toEmail);

$mail->addReplyTo($_POST['email']);
$mail->isHTML(true);
$mail->Subject = $sub;
$mail->Body         = "	Name : " . $fname . " " . " " . " " . $lname . "
 					<br>E-mail: " . $email . "
 					<br>Phone: " . $phone . "
 					<br>Service: " . $service . "
 					<br>Date: " . $date . "
 					<br>Time: " . $time . "
 					<br>IP : " . $ip_adress;


$mail->IsHTML(true);


 try{
	if($mail->send()) {
		
		echo "<script>
		alert('Thank you! We will contact you to confirm your appointment.');
		window.location.href='../index.php';
		</script>";
		return;
	}
} catch (Exception $e) {
	// header("location:../index.php?error=Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
	
}
echo "<script>
alert('Sorry something went wrong!');
window.location.href='../index.php';
</script>";
}
else{
echo "<script>
	alert('Captcha Failed to Validate');
	window.location.href='../lashes.html';
	</script>";
}



?>
