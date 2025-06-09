<?php
if (version_compare(get_site_option('esr_db_version'), '3.8.1', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_registration ADD COLUMN waiting_email_sent_timestamp timestamp NULL DEFAULT NULL;");
}
