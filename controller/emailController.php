<?php

require_once 'vendor/autoload.php';
// require_once 'config/constant.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername('haokhuy@gmail.com')
  ->setPassword('ooubwhmyfbrwdaju')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);



    function sendVerificationEmail($userEmail, $token, $message){
         // Create a message
         global $mailer;
         $body = '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        
        <body>
            <div class="wrapper">
                <p>Thank you for signing up on our website. Please click on the link below to verify your email</p>
                <a href="http://localhost/shopPurge/' .$message. '?token=' .$token. '">
                    Verify your email address
                </a>
            </div>
        </body>
        
        </html>';
        
        $message = (new Swift_Message('Verified your email address'))
        ->setFrom(['haokhuy@gmail.com'=>'ADMIN'])
        ->setTo($userEmail)
        ->setBody($body, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);
    }

    

?>
