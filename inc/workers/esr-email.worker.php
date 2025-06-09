<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Email_Worker {

	/**
	 * @param string $email
	 * @param string $subject
	 * @param string $body
	 * @param string $email_type
	 * @param array $attachments
	 *
	 * @return bool
	 * @codeCoverageIgnore
	 */
	public function send_email($email, $subject, $body, $email_type = '', $attachments = []) {
		if (!is_email($email)) {
			do_action('esr_log_esr_message', 'email' . $email_type, 'error', sprintf('%s is not a valid e-mail.', $email));

			return 0;
		} else {
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/html; charset=utf-8";
			$headers[] = "Content-Transfer-Encoding: base64";
			$headers[] = "From: " . ESR()->settings->esr_get_option('from_name', get_bloginfo('name')) . " <" . ESR()->settings->esr_get_option('from_email', get_bloginfo('admin_email')) . ">";

			if (ESR()->settings->esr_get_option('bcc_email')) {
				$headers[] = "Bcc: " . ESR()->settings->esr_get_option('bcc_email');
			}

			$body = chunk_split(base64_encode(wpautop($body)));

			//$subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

			$mail_callback        = 'wp_mail';//apply_filters('esr_mail_callback', 'wp_mail');
			$mail_callback_params = apply_filters('esr_mail_callback_params', [$email, $subject, $body, implode("\r\n", $headers), $attachments]);

			$status = call_user_func_array($mail_callback, $mail_callback_params);

			if ($status) {
				do_action('esr_log_esr_message', 'email' . $email_type, 'success', sprintf('E-mail successfully sent to %s', $email));
			} else {
				$error = error_get_last();
				if (isset($error['message'])) {
					do_action('esr_log_esr_message', 'email' . $email_type, 'error', sprintf('Could not send e-mail to %s because of %s', $email, $error['message']));
				} else {
					do_action('esr_log_esr_message', 'email' . $email_type, 'error', sprintf('Could not send e-mail to %s', $email));
				}
			}

			return $status;
		}
	}


	public static function esr_mail_callback_callback() {
		if (ESR()->settings->esr_get_option('use_wp_mail', false)) {
			return 'wp_mail';
		} else {
			return 'mail';
		}
	}


	public static function esr_mail_callback_params_callback($parameters) {
		if (ESR()->settings->esr_get_option('use_wp_mail', false)) {
			return $parameters;
		} else {
			$parameters[4] = '';
			return $parameters;
		}
	}

}

add_filter('esr_mail_callback', ['ESR_Email_Worker', 'esr_mail_callback_callback']);
add_filter('esr_mail_callback_params', ['ESR_Email_Worker', 'esr_mail_callback_params_callback']);