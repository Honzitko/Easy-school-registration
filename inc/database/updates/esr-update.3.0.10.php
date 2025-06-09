<?php
if (version_compare(get_site_option('esr_db_version'), '3.0.10', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment MODIFY to_pay FLOAT;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_user_payment MODIFY payment FLOAT;");
}
