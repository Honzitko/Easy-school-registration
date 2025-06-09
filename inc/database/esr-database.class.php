<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Database {

	public static function esr_update_db_check() {
		if (get_site_option('esr_db_version') == NULL) {
			self::database_install();
		} else if (version_compare(get_site_option('esr_db_version'), ESR_VERSION, '<')) {
			self::database_update();
		}
	}

	private static function database_install() {
		self::create_tables();

		add_option('esr_db_version', ESR_VERSION);
	}

	public static function database_uninstall() {
		self::drop_tables();

		delete_option('esr_db_version');
	}

	private static function database_update() {
		include_once 'updates/esr-update.3.0.9.php';
		include_once 'updates/esr-update.3.0.10.php';
		include_once 'updates/esr-update.3.1.6.php';
		include_once 'updates/esr-update.3.1.8.php';
		include_once 'updates/esr-update.3.1.10.php';
		include_once 'updates/esr-update.3.1.12.php';
		include_once 'updates/esr-update.3.2.0.php';
		include_once 'updates/esr-update.3.2.1.php';
		include_once 'updates/esr-update.3.2.3.php';
		include_once 'updates/esr-update.3.3.0.php';
		include_once 'updates/esr-update.3.3.6.php';
		include_once 'updates/esr-update.3.4.2.php';
		include_once 'updates/esr-update.3.4.4.php';
		include_once 'updates/esr-update.3.4.7.php';
		include_once 'updates/esr-update.3.5.0.php';
		include_once 'updates/esr-update.3.5.5.php';
		include_once 'updates/esr-update.3.6.1.php';
		include_once 'updates/esr-update.3.6.2.php';
		include_once 'updates/esr-update.3.6.9.php';
		include_once 'updates/esr-update.3.7.0.php';
		include_once 'updates/esr-update.3.7.6.php';
		include_once 'updates/esr-update.3.7.7.php';
		include_once 'updates/esr-update.3.8.1.php';

		update_option('esr_db_version', ESR_VERSION);
	}

	public static function create_tables() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$wpdb->prefix}esr_wave_data (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			title mediumtext NOT NULL,
			registration_from datetime,
			registration_to datetime,
			is_passed tinyint(1) DEFAULT 0,
			wave_settings longtext,
			PRIMARY KEY id (id)
		) $charset_collate;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esr_teacher_data (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(50) NOT NULL,
			nickname varchar(50),
			active tinyint(1) NOT NULL DEFAULT 1,
			user_id bigint(20) UNSIGNED DEFAULT NULL,
			teacher_settings longtext,
			PRIMARY KEY id (id)
		) $charset_collate;";


		$sql .= "CREATE TABLE {$wpdb->prefix}esr_course_data (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			wave_id bigint(20) UNSIGNED NOT NULL,
			sub_header text,
			teacher_first bigint(20) UNSIGNED,
			teacher_second bigint(20) UNSIGNED,
			course_from datetime,
			course_to datetime,
			day int(10),
			time_from varchar(10),
			time_to varchar(10),
			is_solo tinyint(1) NOT NULL DEFAULT 0,
			max_leaders int(10),
			max_followers int(10),
			max_solo int(10),
			price int(10),
			is_passed tinyint(1) DEFAULT 0,
			hall_key varchar(20) DEFAULT NULL,
			title mediumtext,
			group_id int,
			level_id int,
			pairing_mode int DEFAULT 1,
			enforce_partner tinyint(1) DEFAULT 0,
			description_type tinyint(1) DEFAULT 0,
			course_link varchar(255) DEFAULT NULL,
			description text DEFAULT NULL,
			course_settings longtext,
			PRIMARY KEY id (id)
		) $charset_collate;";

		$sql .= "ALTER TABLE {$wpdb->prefix}esr_course_data ADD CONSTRAINT fk_wave_id FOREIGN KEY (wave_id) REFERENCES {$wpdb->prefix}esr_wave_data(id) ON DELETE CASCADE;";
		$sql .= "ALTER TABLE {$wpdb->prefix}esr_course_data ADD CONSTRAINT fk_teacher_first FOREIGN KEY (teacher_first) REFERENCES {$wpdb->prefix}esr_teacher_data(id) ON DELETE SET NULL;";
		$sql .= "ALTER TABLE {$wpdb->prefix}esr_course_data ADD CONSTRAINT fk_teacher_second FOREIGN KEY (teacher_second) REFERENCES {$wpdb->prefix}esr_teacher_data(id) ON DELETE SET NULL;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esr_course_registration (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id bigint(20) UNSIGNED NOT NULL,
			partner_id bigint(20) UNSIGNED DEFAULT NULL,
			course_id bigint(20) UNSIGNED NOT NULL,
			time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
			dancing_as tinyint(1) NOT NULL,
			dancing_with text,
			note text,
			status int,
			position int,
			free_registration tinyint(1) NOT NULL DEFAULT 0,
			unique_key varchar(25) DEFAULT NULL,
			confirmation_time timestamp,
			waiting_email_sent_timestamp timestamp NULL DEFAULT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		$sql .= "ALTER TABLE {$wpdb->prefix}esr_course_registration ADD CONSTRAINT fk_course_id FOREIGN KEY (course_id) REFERENCES {$wpdb->prefix}esr_course_data(id) ON DELETE CASCADE;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esr_course_summary (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			course_id bigint(20) UNSIGNED NOT NULL,
			registered_leaders int(10) DEFAULT 0 NOT NULL,
			registered_followers int(10) DEFAULT 0 NOT NULL,
			registered_solo int(10) DEFAULT 0 NOT NULL,
			waiting_leaders int(10) DEFAULT 0 NOT NULL,
			waiting_followers int(10) DEFAULT 0 NOT NULL,
			waiting_solo int(10) DEFAULT 0 NOT NULL,
			PRIMARY KEY id (id)
		) $charset_collate;";

		$sql .= "ALTER TABLE {$wpdb->prefix}esr_course_summary ADD CONSTRAINT fk_course_id FOREIGN KEY (course_id) REFERENCES {$wpdb->prefix}esr_course_data(id) ON DELETE CASCADE;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esr_user_payment (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id bigint(20) UNSIGNED NOT NULL,
			wave_id bigint(20) UNSIGNED NOT NULL,
			payment_type int(10) DEFAULT NULL,
			to_pay float DEFAULT NULL,
			payment float DEFAULT NULL,
			is_paying tinyint(1) NOT NULL DEFAULT 1,
			is_voucher tinyint(1) NOT NULL DEFAULT 0,
			note text DEFAULT NULL,
			status int DEFAULT 0,
			confirm_user_id bigint(20) UNSIGNED DEFAULT NULL,
			confirm_by_user_id tinyint(1) NOT NULL DEFAULT 1,
			insert_timestamp timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
			confirm_timestamp timestamp NULL DEFAULT NULL,
			confirmation_email_sent_timestamp timestamp NULL DEFAULT NULL,
			unique_key varchar(25) DEFAULT NULL,
			discount_info text DEFAULT NULL,
			PRIMARY KEY id (id),
			CONSTRAINT uk_wave_registration UNIQUE (wave_id, unique_key)
		) $charset_collate;";

		$sql .= "ALTER TABLE {$wpdb->prefix}esr_user_payment ADD CONSTRAINT fk_wave_id FOREIGN KEY (wave_id) REFERENCES {$wpdb->prefix}esr_wave_data(id) ON DELETE CASCADE;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esr_log (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			system varchar(50) NOT NULL,
			subtype varchar(50) NOT NULL,
			status varchar(20) NOT NULL,
			user_id bigint(20) UNSIGNED NOT NULL,
			message text,
			insert_tme timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";


		$sql .= "CREATE TABLE {$wpdb->prefix}esr_course_dates (
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

	public static function drop_tables() {
		global $wpdb;

		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_log`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_course_summary`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_user_payment`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_course_registration`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_course_data`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_teacher_data`;");
		$wpdb->query("DROP TABLE `{$wpdb->prefix}esr_wave_data`;");
	}

}

add_action('plugins_loaded', ['ESR_Database', 'esr_update_db_check']);