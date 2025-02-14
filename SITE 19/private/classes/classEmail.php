<?php

class Email {

	public static function sendEmail($contentEmail, $server_email, $title, $email) {
		
		// Acentuação UTF-8
		
		$contentEmail .= "<br /><b>".$GLOBALS['server_name']."</b><br /><a href='http://".$GLOBALS['server_url']."'>".strtolower($GLOBALS['server_url'])."</a><br />";
		
		if($GLOBALS['useSMTP'] != 1) {
			
			$headers = "MIME-Version: 1.1\n";
			$headers .= "Content-type: text/html; charset=UTF-8\n";
			$headers .= "From: ".$server_email."\n";
			$headers .= "Return-Path: ".$server_email ."\n";
			if(mail($email, $title, $contentEmail, $headers)) {
				return true;
			} else {
				return false;
			}
			
		} else {
			
			require 'private/PHPMailer-master/class.phpmailer.php';
			require 'private/PHPMailer-master/class.phpmaileroauth.php';
			require 'private/PHPMailer-master/class.smtp.php';
			
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->CharSet = 'utf-8';
			$mail->SMTPDebug = 0;
			$mail->Host = trim($GLOBALS['SMTP_host']);
			$mail->Port = intval($GLOBALS['SMTP_port']);
			$mail->SMTPAuth = true;
			$mail->Username = trim($GLOBALS['SMTP_user']);
			$mail->Password = trim($GLOBALS['SMTP_pass']);
			if(!empty($GLOBALS['SMTP_secu'])){ $mail->SMTPSecure = trim($GLOBALS['SMTP_secu']); }
			$mail->setFrom(trim($GLOBALS['SMTP_user']), trim($GLOBALS['server_name']));
			$mail->addAddress($email);
			$mail->Subject = $title;
			$mail->msgHTML($contentEmail);
			$mail->AltBody = strip_tags($contentEmail);
			
			if(!$mail->send()) {
				return false;
			} else {
				return true;
			}
			
		}
		
	}
	
}
