<?php 

$name =  $_POST["name"]; 
$email =  $_POST["email"];
$subject =  $_POST["subject"];
$msg =  $_POST["msg"];

        $message = $name." ".$email."\r\n".$subject."\r\n".$msg;

        $to = 'teamkyanisupplements@gmail.com';
        $subject = 'Free 7 Day Trial Request';
        $header = 'From: teamkyanisupplements.com';
        mail($to,$subject,$message,$header);



header('Location: http://teamkyanisupplements.com/become-a-kyani-distributor.html');

?>