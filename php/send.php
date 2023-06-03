<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'twilio/sms.php';
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

$ip_adress 	= GetIP();
$name       = addslashes(strip_tags($_POST['name'])); 
$sub 		= addslashes(strip_tags($_POST['subject']));
$email     	= addslashes(strip_tags($_POST['email'])); 
$message    = addslashes(strip_tags($_POST['message'])); 
 
 if(empty($name) || empty($email) || empty($message) || empty($sub)){header("Location:form.php?empty"); }else{
  
$mail = new PHPMailer();
$mail->IsSMTP();                                   
$mail->Host     = "localhost"; // smtp host
$mail->Port     = "25";  // Port
$mail->SMTPAuth = false;    
$mail->Username = 'kde@contactform.page';
$mail->Password = '5:+$2|wK~O';
$mail->From     = "ContactForm@booksandbrewswv.com"; // from mail address
$mail->Fromname = "Books and Brews"; // From Name
$mail->AddAddress("ContactForm@booksandbrewswv.com","Books and Brews"); //your mail address and name
$mail->WordWrap     = 50; 
$mail->Subject      = $sub; // Mail Subject
$mail->Body         = "	Name : ".$name. "
						<br>E-mail: ".$email. "
					<br>Message: ".$message . " 
					<br>IP : ".$ip_adress ; 
     

$mail->AddReplyTo($email,"Contact Form");
$mail->AddAddress('ContactForm@booksandbrewswv.com');  //mail address
$mail->IsHTML(true); 


if ($mail->Send())
 //header("Location: index.html");
     echo "<script>
alert('Thank you');
window.location.href='index.php';
</script>";

}

 

?>
