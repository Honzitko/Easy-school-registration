<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Template_Student_Payment {

	public static function esr_print_student_payment_page_callback($attr) {
		if (isset($attr['stp'])) {
			$payment = ESR()->payment->esr_get_payment_by_md5($attr['stp']);
			$is_processing = apply_filters('esr_student_payment_process', ['payment' => $payment, 'attr' => $attr, 'is_processing' => false]);

			if ($payment === null) {
				_e('No payment found', 'easy-school-registration');
			} else {
				$already_paid = max(floatval($payment->payment), 0);
				if (floatval($payment->to_pay) > $already_paid) {
					$full_price = 0;
					?>
					<table>
						<thead>
						<tr>
							<th><?php _e('Course') ?></th>
							<th><?php _e('Price') ?></th>
						</tr>
						</thead>
						<?php
						$courses = ESR()->registration->get_confirmed_registrations_by_wave_and_user($payment->wave_id, $payment->user_id);
						$to_pay = floatval($payment->to_pay);
						foreach ($courses as $ck => $course) {
							$full_price += floatval($course->price);
							?>
							<tr>
								<td><?php echo $course->title ?></td>
								<td><?php echo $course->price ?></td>
							</tr>
							<?php
						}
						if ($full_price !== $to_pay) {
							?>
							<tr>
								<td><?php _e('Discount') ?></td>
								<td><?php echo $full_price - $to_pay; ?></td>
							</tr>
							<?php
						}
						if ($already_paid != 0) {
							?>
							<tr>
								<td><?php _e('Already paid') ?></td>
								<td><?php echo $already_paid; ?></td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td><?php _e('To Pay') ?></td>
							<td><?php echo $to_pay - $already_paid; ?></td>
						</tr>
					</table>
					<?php
					do_action('esr_student_payment_button', $payment, $attr);
				} else {
					_e('Already paid', 'easy-school-registration');
				}
			}
		} else {
			_e('No payment found', 'easy-school-registration');
		}
	}

}

add_action('esr_print_student_payment_page', ['ESR_Template_Student_Payment', 'esr_print_student_payment_page_callback']);