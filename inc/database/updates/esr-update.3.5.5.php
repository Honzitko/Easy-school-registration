<?php
if (version_compare(get_site_option('esr_db_version'), '3.5.5', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_wave_data ADD COLUMN wave_settings longtext;");
}
