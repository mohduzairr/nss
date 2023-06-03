<?php

use Twilio\Rest\Client;
require '../vendor/autoload.php';


function twilioSMS($toPhoneNo, $message)
{
 
    // Your Account  SID and Au;th Token from twilio.com/console
    $account_sid = 'AC2b919356d0b7d0592753543119a1c976';
    $auth_token = '80d81197909e4ce85d5aacdb6a245e41';
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

    // A Twilio number you own with SMS capabilities
    $twilio_number = "+13044439504";
   
    $client = new Client($account_sid, $auth_token);
    
    $sendSMS = $client->messages->create(
        
        // Where to send a text message (your cell phone?)
        $toPhoneNo,
       
        array(
            'from' => $twilio_number,
            'body' => $message
        )
    );
   // echo  $sendSMS;die;
   
    if ($sendSMS) {
        return true;
    } else {
        return false;
    }
}
