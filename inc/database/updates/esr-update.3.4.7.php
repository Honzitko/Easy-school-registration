<?php
if (version_compare(get_site_option('esr_db_version'), '3.4.7', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_registration ADD COLUMN free_registration tinyint(1) NOT NULL DEFAULT 0;");
}
