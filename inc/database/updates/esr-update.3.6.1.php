<?php
if (version_compare(get_site_option('esr_db_version'), '3.6.1', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_registration ADD COLUMN confirmation_time timestamp;");

	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_registration cr JOIN (SELECT cr.id, cr.time  FROM {$wpdb->prefix}esr_course_registration AS cr JOIN {$wpdb->prefix}esr_course_data AS cd ON cr.course_id = cd.id WHERE status = %d AND cd.is_solo) AS nt ON cr.id = nt.id SET cr.confirmation_time = nt.time WHERE cr.id = nt.id", [ESR_Registration_Status::CONFIRMED]));

	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_registration cr JOIN (SELECT crl.id AS crl_id, crf.id AS crf_id, CASE WHEN crl.time >= crf.time THEN crl.time ELSE crf.time END AS reg_time FROM {$wpdb->prefix}esr_course_registration AS crl JOIN {$wpdb->prefix}esr_course_registration AS crf ON crl.course_id = crf.course_id AND crl.dancing_as != crf.dancing_as AND crl.partner_id = crf.user_id AND crf.partner_id = crl.user_id JOIN {$wpdb->prefix}esr_course_data AS cd ON crl.course_id = cd.id AND crf.course_id = cd.id WHERE crl.status = %d AND crf.status = %d AND NOT cd.is_solo) AS nt ON cr.id = nt.crl_id OR cr.id = nt.crf_id SET cr.confirmation_time = nt.reg_time WHERE cr.id = nt.crl_id OR cr.id = nt.crf_id", [ESR_Registration_Status::CONFIRMED, ESR_Registration_Status::CONFIRMED]));

	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_registration cr JOIN (SELECT id, time FROM {$wpdb->prefix}esr_course_registration WHERE status = %d AND confirmation_time = '0000-00-00 00:00:00') AS nt ON cr.id = nt.id SET cr.confirmation_time = nt.time WHERE cr.id = nt.id", [ESR_Registration_Status::CONFIRMED]));
}
