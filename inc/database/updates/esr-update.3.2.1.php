<?php
if (version_compare(get_site_option('esr_db_version'), '3.2.1', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment ADD COLUMN confirmation_email_sent_timestamp timestamp NULL DEFAULT NULL;");
}
