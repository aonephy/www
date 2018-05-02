<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'src/Exception.php';
	require 'src/PHPMailer.php';
	require 'src/SMTP.php';
	
	$mail = new PHPMailer();                              // Passing `true` enables exceptions
	try {
	    //Server settings
	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'anjinfeng@funtsui.com';                 // SMTP username
	    $mail->Password = '~!@1qaz2wsx';                           // SMTP password
	    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;		                             // TCP port to connect to
		$mail->CharSet = 'UTF-8';
		
	    //Recipients
	    $mail->setFrom('anjinfeng@qq.com', 'Mailer');
	    $mail->addAddress($_POST['toMail'], $_POST['toMail']);     // Add a recipient
//	    $mail->addAddress('anjinfeng@qq.com');               // Name is optional
//	    $mail->addReplyTo('info@example.com', 'Information');
//	    $mail->addCC('cc@example.com');
//	    $mail->addBCC('bcc@example.com');
	
	    //Attachments
//	    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//	    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $_POST['title'];
	    $mail->Body = $_POST['content'];
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	    $mail->send();
	    echo 'Message has been sent';
	} catch (Exception $e) {
	    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
?>