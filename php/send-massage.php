<?php

session_start();
include 'phpmailer/class.phpmailer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// include 'twilio/sms.php';
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
curl_close ($ch);
$data = json_decode($response, true);
if($data["success"] === true){
	
$ip_adress 	= GetIP();
	
if(@$_POST['fname'] == ""){
	echo "<script>
	alert('First Name is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['lname'] == ""){
	echo "<script>
	alert('Last Name is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['email'] == ""){
	echo "<script>
	alert('Email is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['phone'] == ""){
	echo "<script>
	alert('Phone is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['service'] == ""){
	echo "<script>
	alert('Service is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['pro'] == ""){
	echo "<script>
	alert('Professional Field is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['date'] == ""){
	echo "<script>
	alert('Date is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}
	
if(@$_POST['time'] == ""){
	echo "<script>
	alert('Time is Required');
	window.location.href='../massage.html';
	</script>";
	return false;
}	
	
$fname = addslashes(strip_tags($_POST['fname']));
if ( !preg_match ("/^[a-zA-Z\s]+$/",$fname)) {
    echo "<script>
	alert('Use only Letter in First Name');
	window.location.href='../massage.html';
	</script>";
	return false;
}	
$lname = addslashes(strip_tags($_POST['lname'])); 
if ( !preg_match ("/^[a-zA-Z\s]+$/",$lname)) {
    echo "<script>
	alert('Use only Letter in Last Name');
	window.location.href='../massage.html';
	</script>";
	return false;
}
$sub = "Nova Massage Care Booking Form";
$email = addslashes(strip_tags($_POST['email']));
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
    echo "<script>
	alert('Email Format is Wrong');
	window.location.href='../massage.html';
	</script>";
	return false;
}
$phone = addslashes(strip_tags($_POST['phone']));



$service    = addslashes(strip_tags($_POST['service']));
$pro    = addslashes(strip_tags($_POST['pro']));
$date    = addslashes(strip_tags($_POST['date']));
$time    = addslashes(strip_tags($_POST['time']));
 
// $toEmail    = "";
     if($pro == "danett"){
         $toEmail = "zendre1122@gmail.com";
		 $toSMS = "+16812059774";
     }else {
		echo "<script>
		alert('Please Select A Professional');
		window.location.href='../massage.html';
		</script>";
	}

	//$toEmail    = "support@kdetechnology.com";
	
	
	
	 $mail = new PHPMailer();
	
	$mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'ssl://webmail.kdetechnology.com';      //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username = 'kde@contactform.page';
	$mail->Password = '5:+$2|wK~O';                    //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port       = 465;   
	
	$mail->SMTPOptions = array(
		'ssl' => [
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true,
			'peer_name' => 'webmail.kdetechnology.com',
			'cafile' => '/etc/ssl/ca_cert.pem',
		],
	);
	
	$mail->From     = "ContactForm@novasalonandspawv.com"; // from mail address
	$mail->Fromname = "Nova Salon & Spa"; // From Name
	$mail->AddAddress($toEmail); //your mail address and name
	$mail->WordWrap     = 50;
	$mail->Subject      = $sub; // Mail Subject
	$mail->Body         = "	Name : " . $fname . " " . " " . " " . $lname . "
						<br>E-mail: " . $email . "
						<br>Phone: " . $phone . "
						<br>Service: " . $service . "
						<br>Date: " . $date . "
						<br>Time: " . $time . "
						<br>IP : " . $ip_adress;

					
	$mail->AddReplyTo($email, "Contact Form");
	
	$mail->IsHTML(true);

	try {
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
		window.location.href='../hair.html';
		</script>";
 }

?>
