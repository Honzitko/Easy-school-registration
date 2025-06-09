<?php
if (version_compare(get_site_option('esr_db_version'), '3.7.0', '<')) {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$wpdb->prefix}esr_course_dates (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			course_id bigint(20) UNSIGNED NOT NULL,
			day int(10),
			time_from varchar(10),
			time_to varchar(10),
			hall_key varchar(20) DEFAULT NULL,
			PRIMARY KEY id (id)
		) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
