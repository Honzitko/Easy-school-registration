<?php
if (version_compare(get_site_option('esr_db_version'), '3.4.2', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment ADD COLUMN payment_type int(10) DEFAULT NULL;");
}
