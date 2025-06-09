<?php
if (version_compare(get_site_option('esr_db_version'), '3.2.0', '<')) {
	//Update payments
	global $wpdb;
	$registration_list = $wpdb->get_results($wpdb->prepare("SELECT cr.user_id, cd.wave_id FROM {$wpdb->prefix}esr_course_registration AS cr JOIN {$wpdb->prefix}esr_course_data AS cd ON cr.course_id = cd.id LEFT JOIN {$wpdb->prefix}esr_user_payment AS up ON cr.user_id = up.user_id AND cd.wave_id = up.wave_id WHERE up.id IS NULL AND cr.status = %d GROUP BY cr.user_id, cd.wave_id ORDER BY cr.user_id", [ESR_Registration_Status::CONFIRMED]));
	$worker_payment = new ESR_Payments_Worker();

	foreach ($registration_list as $key => $registration) {
		$worker_payment->update_user_payment($registration->user_id, $registration->wave_id);
	}
}
