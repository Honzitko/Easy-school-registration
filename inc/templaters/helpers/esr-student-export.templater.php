<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Template_Student_Export {

	public function export_student_data($user_id) {
		$html = '';

		$html = apply_filters('esr_student_export_user_info', $html, $user_id);
		$html = apply_filters('esr_student_export_table', $html, $user_id);

		return $html;
	}

	public static function esr_print_user_info($html, $user_id) {
		$user = get_user_by('ID', $user_id);

		$html .= '<h2>' . __('User data', 'easy-school-registration') . '</h2>';
		$html .= '
		<table>
			<tr>
				<th>' . __('Display name', 'easy-school-registration') . '</th>
				<td>' . $user->data->display_name . '</td>
			</tr>
			<tr>
				<th>' . __('User login', 'easy-school-registration') . '</th>
				<td>' . $user->data->user_login . '</td>
			</tr>
			<tr>
				<th>' . __('User Email', 'easy-school-registration') . '</th>
				<td>' . $user->data->user_email . '</td>
			</tr>
			<tr>
				<th>' . __('User Url', 'easy-school-registration') . '</th>
				<td>' . $user->data->user_url . '</td>
			</tr>
			<tr>
				<th>' . __('User Registered', 'easy-school-registration') . '</th>
				<td>' . $user->data->user_registered . '</td>
			</tr>
		</table>
		';


		$user_meta = get_user_meta($user_id);
		$html .= '<h2>' . __('User meta', 'easy-school-registration') . '</h2>';
		$html .= '
		<table>
			<tr>
				<th>' . __('Nickname', 'easy-school-registration') . '</th>
				<td>' . $user_meta['nickname'][0] . '</td>
			</tr>
			<tr>
				<th>' . __('First name', 'easy-school-registration') . '</th>
				<td>' . $user_meta['first_name'][0] . '</td>
			</tr>
			<tr>
				<th>' . __('Last name', 'easy-school-registration') . '</th>
				<td>' . $user_meta['last_name'][0] . '</td>
			</tr>
			<tr>
				<th>' . __('Description', 'easy-school-registration') . '</th>
				<td>' . $user_meta['description'][0] . '</td>
			</tr>
			<tr>
				<th>' . __('Phone', 'easy-school-registration') . '</th>
				<td>' . (isset($user_meta['esr-course-registration-phone'][0]) ? $user_meta['esr-course-registration-phone'][0] : '') . '</td>
			</tr>
			<tr>
				<th>' . __('Terms & Conditions', 'easy-school-registration') . '</th>
				<td>' . (isset($user_meta['esr-course-registration-terms-conditions'][0]) ? $user_meta['esr-course-registration-terms-conditions'][0] : '') . '</td>
			</tr>
		</table>
		';

		return $html;
	}


	public static function esr_print_registrations($html, $user_id) {
		$registrations = ESR()->registration->get_registrations_by_user($user_id);


		if ($registrations) {
			$html .= '<h2>' . __('Registrations', 'easy-school-registration') . '</h2>';
			$html .= '<table>
						<tr>
						<th>' . __('Registration time', 'easy-school-registration') . '</th>
						<th>' . __('Status', 'easy-school-registration') . '</th>
						<th>' . __('Course', 'easy-school-registration') . '</th>
						<th>' . __('Wave', 'easy-school-registration') . '</th>
						<th>' . __('Partner', 'easy-school-registration') . '</th>
						<th>' . __('Dancing As', 'easy-school-registration') . '</th>
						<th>' . __('Dancing With', 'easy-school-registration') . '</th>
						<th>' . __('Note', 'easy-school-registration') . '</th>
						</tr>';
			foreach ($registrations as $id => $registration) {
				$user = get_user_by('ID', $registration->partner_id);
				$html .= '
						<tr>
						<td>' . $registration->time . '</td>
						<td>' . ESR()->registration_status->get_title($registration->status) . '</td>
						<td>' . $registration->course_name . '</td>
						<td>' . $registration->wave_name . '</td>
						<td>' . ($user ? $user->data->display_name : '') . '</td>
						<td>' . ESR()->dance_as->get_title($registration->dancing_as) . '</td>
						<td>' . $registration->dancing_with . '</td>
						<td>' . $registration->note . '</td>
						</tr>';
			}
			$html .= '</table>';
		} else {
			$html = '<div>' . __('No registrations', 'easy-school-registration') . '</div>';
		}

		return $html;
	}


	public static function esr_print_payments($html, $user_id) {
		$payments = ESR()->payment->get_payments_by_user($user_id);
		$html     .= '';

		if ($payments) {
			$html .= '<h2>' . __('Payments', 'easy-school-registration') . '</h2>';
			$html .= '<table>
						<tr>
						<th>' . __('Status', 'easy-school-registration') . '</th>
						<th>' . __('Wave', 'easy-school-registration') . '</th>
						<th>' . __('To Pay', 'easy-school-registration') . '</th>
						<th>' . __('Payment', 'easy-school-registration') . '</th>
						<th>' . __('Is Paying', 'easy-school-registration') . '</th>
						<th>' . __('Is Voucher', 'easy-school-registration') . '</th>
						<th>' . __('Insert Timestamp', 'easy-school-registration') . '</th>
						<th>' . __('Confirm Timestamp', 'easy-school-registration') . '</th>
						</tr>';
			foreach ($payments as $id => $payment) {
				$wave = ESR()->wave->get_wave_data($payment->wave_id);
				$html .= '
						<tr>
						<td>' . ESR()->payment_status->get_title($payment->status) . '</td>
						<td>' . ($wave ? $wave->title : '') . '</td>
						<td>' . $payment->to_pay . '</td>
						<td>' . $payment->payment . '</td>
						<td>' . $payment->is_paying . '</td>
						<td>' . $payment->is_voucher . '</td>
						<td>' . $payment->insert_timestamp . '</td>
						<td>' . $payment->confirm_timestamp . '</td>
						</tr>';
			}
			$html .= '</table>';
		} else {
			$html .= '<div>' . __('No payments', 'easy-school-registration') . '</div>';
		}

		return $html;
	}

}

add_filter('esr_student_export_user_info', ['ESR_Template_Student_Export', 'esr_print_user_info'], 10, 2);
add_filter('esr_student_export_table', ['ESR_Template_Student_Export', 'esr_print_registrations'], 10, 2);
add_filter('esr_student_export_table', ['ESR_Template_Student_Export', 'esr_print_payments'], 11, 2);