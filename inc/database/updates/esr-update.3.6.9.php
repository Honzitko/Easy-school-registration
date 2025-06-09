<?php
if (version_compare(get_site_option('esr_db_version'), '3.6.9', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment ADD COLUMN discount_info text DEFAULT NULL;");
}
