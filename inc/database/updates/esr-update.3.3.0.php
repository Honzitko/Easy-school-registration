<?php
if (version_compare(get_site_option('esr_db_version'), '3.3.0', '<')) {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$wpdb->prefix}esr_log (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			system varchar(50) NOT NULL,
			subtype varchar(50) NOT NULL,
			status varchar(20) NOT NULL,
			user_id bigint(20) UNSIGNED NOT NULL,
			message text,
			insert_tme timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
