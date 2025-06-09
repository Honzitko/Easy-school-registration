<?php
if (version_compare(get_site_option('esr_db_version'), '3.2.3', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN enforce_partner tinyint(1) DEFAULT 0;");
}
