<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Registration_Note_Email_Templater {

	public static function esr_process_registration_note_email_callback( $user_id, $wave_ids, $user_info, $note ) {
		return self::esr_send_email( $user_id, $wave_ids, $user_info, $note );
	}


	public static function esr_send_email( $user_id, $wave_ids, $user_info, $note ) {
		$email = ESR()->settings->esr_get_option( 'admin_note_email', false );

		if ( ! empty( $email ) ) {
			$subject = 'New registration with note';
			$body    = '<p>There is new registration with student note</p><br/><p>[note]</p><br>[registration_link]';
			$link    = '<a href="' . admin_url( 'admin.php?page=esr_admin_sub_page_registrations&cin_wave_id=' . reset( $wave_ids ) . '&cin_student_id=' . $user_id ) . '">Registrations</a>';

			if ( ! empty( $body ) ) {
				$body         = str_replace( '[note]', $note, $body );
				$body         = str_replace( '[registration_link]', $link, $body );
				$worker_email = new ESR_Email_Worker();

				return $worker_email->send_email( $email, $subject, $body, '_registration_note' );
			}
		}

		return false;
	}

}

add_filter( 'esr_process_registration_note_email', [ 'ESR_Registration_Note_Email_Templater', 'esr_process_registration_note_email_callback' ], 10, 4 );