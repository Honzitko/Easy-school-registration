<?php
if (version_compare(get_site_option('esr_db_version'), '3.5.0', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_teacher_data ADD COLUMN user_id bigint(20) UNSIGNED DEFAULT NULL;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_teacher_data ADD COLUMN teacher_settings longtext;");

	//Added unique key for registrations and payments
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_registration ADD COLUMN unique_key varchar(25) DEFAULT NULL;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment ADD COLUMN unique_key varchar(25) DEFAULT NULL;");
}
