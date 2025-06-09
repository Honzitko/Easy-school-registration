<?php
if (version_compare(get_site_option('esr_db_version'), '3.0.9', '<')) {
	//Update payments
	$registration_list = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_course_registration WHERE status = %d", [ESR_Registration_Status::CONFIRMED]));
	$worker_payment = new ESR_Payments_Worker();

	foreach ($registration_list as $key => $registration) {
		$course_data = ESR()->course->get_course_data($registration->course_id);
		$worker_payment->update_user_payment($registration->user_id, $course_data->wave_id);
	}

	global $wpdb;

	//Update solo summary
	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_summary AS cs
					JOIN(
					SELECT cr.course_id, COUNT(cr.course_id) AS count
					  FROM {$wpdb->prefix}esr_course_registration AS cr
					  JOIN {$wpdb->prefix}esr_course_data AS cd ON cr.course_id = cd.id
					 WHERE cd.is_solo
					   AND cr.status = %d
					 GROUP BY cr.course_id) AS nd
					 ON nd.course_id = cs.course_id
					 SET cs.registered_solo = nd.count, cs.registered_followers = 0, cs.registered_leaders = 0", [ESR_Registration_Status::CONFIRMED]));

	//Update leader summary
	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_summary AS cs
						JOIN(
						SELECT cr.course_id, COUNT(cr.course_id) AS count
						  FROM {$wpdb->prefix}esr_course_registration AS cr
						  JOIN {$wpdb->prefix}esr_course_data AS cd ON cr.course_id = cd.id
						 WHERE NOT cd.is_solo
						   AND cr.status = %d
						   AND cr.dancing_as = %d
						 GROUP BY cr.course_id) AS nd
						    ON nd.course_id = cs.course_id
						 SET cs.registered_leaders = nd.count", [ESR_Registration_Status::CONFIRMED, ESR_Dancing_As::LEADER]));

	//Update follower summary
	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_summary AS cs
						JOIN(
						SELECT cr.course_id, COUNT(cr.course_id) AS count
						  FROM {$wpdb->prefix}esr_course_registration AS cr
						  JOIN {$wpdb->prefix}esr_course_data AS cd ON cr.course_id = cd.id
						 WHERE NOT cd.is_solo
						   AND cr.status = %d
						   AND cr.dancing_as = %d
						 GROUP BY cr.course_id) AS nd
						    ON nd.course_id = cs.course_id
						 SET cs.registered_followers = nd.count", [ESR_Registration_Status::CONFIRMED, ESR_Dancing_As::FOLLOWER]));
}
