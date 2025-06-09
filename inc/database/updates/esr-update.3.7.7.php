<?php
if (version_compare(get_site_option('esr_db_version'), '3.7.7', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN course_settings longtext;");
}
