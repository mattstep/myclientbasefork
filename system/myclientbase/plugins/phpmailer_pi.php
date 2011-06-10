<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function phpmail_send($from, $to, $subject, $message, $attachment_path = NULL, $cc = NULL, $bcc = NULL) {

	require_once(APPPATH . 'plugins/phpmailer/class.phpmailer.php');

	$CI =& get_instance();

	$mail = new PHPMailer();

	$mail->CharSet = 'UTF-8';

	$mail->IsHtml();

	if ($CI->mdl_mcb_data->email_protocol == 'smtp') {

		$mail->IsSMTP();

		$mail->SMTPAuth = true;

		if ($CI->mdl_mcb_data->smtp_security) {

			$mail->SMTPSecure = $CI->mdl_mcb_data->smtp_security;

		}

		$mail->Host = $CI->mdl_mcb_data->smtp_host;

		$mail->Port = $CI->mdl_mcb_data->smtp_port;

		$mail->Username = $CI->mdl_mcb_data->smtp_user;

		$mail->Password = $CI->mdl_mcb_data->smtp_pass;

	}

	elseif ($CI->mdl_mcb_data->email_protocol == 'sendmail') {

		$mail->IsSendmail();

	}

	if (is_array($from)) {

		$mail->SetFrom($from[0], $from[1]);

	}

	else {

		$mail->SetFrom($from);

	}

	$mail->Subject = $subject;

	$mail->Body = $message;

	$mail->AddAddress($to);

	if ($cc) {

		$mail->AddCC($cc);

	}

	if ($bcc) {

		$mail->AddBCC($bcc);

	}

	if ($attachment_path) {

		$mail->AddAttachment($attachment_path);

	}

	if ($mail->Send()) {

		$CI->session->set_flashdata('custom_success', $CI->lang->line('email_success'));

		return TRUE;

	}

	else {

		$CI->session->set_flashdata('custom_error', $mail->ErrorInfo);

		return FALSE;

	}

}

?>