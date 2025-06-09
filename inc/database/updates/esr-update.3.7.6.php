<?php
if (version_compare(get_site_option('esr_db_version'), '3.7.6', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN description_type tinyint(1) DEFAULT 0;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN course_link varchar(255) DEFAULT NULL;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data ADD COLUMN description text DEFAULT NULL;");
}
