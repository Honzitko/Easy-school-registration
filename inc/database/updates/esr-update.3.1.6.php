<?php
if (version_compare(get_site_option('esr_db_version'), '3.1.6', '<')) {
	global $wpdb;

	$wpdb->query($wpdb->prepare("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN pairing_mode int DEFAULT %d;", [ESR_Enum_Pairing_Mode::AUTOMATIC]));

	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_registration SET dancing_as = %d WHERE dancing_as IS NULL;", [ESR_Dancing_As::SOLO]));

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_summary ADD COLUMN waiting_solo int(10) DEFAULT 0 NOT NULL;");
}
