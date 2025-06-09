<?php
if (version_compare(get_site_option('esr_db_version'), '3.1.8', '<')) {
	global $wpdb;

	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_registration MODIFY dancing_as tinyint(1) NOT NULL;");
	$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}esr_course_registration SET dancing_as = %d WHERE course_id IN (SELECT id FROM {$wpdb->prefix}esr_course_data WHERE is_solo);", [ESR_Dancing_As::SOLO]));

	//REMOVE unused columns
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_teacher_data DROP COLUMN description;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_teacher_data DROP COLUMN user_id;");
	$wpdb->query("ALTER TABLE {$wpdb->prefix}esr_course_data DROP COLUMN content;");

	$waves = ESR()->wave->get_waves_data();

	$cin_worker = new ESR_Course_In_Numbers_Worker;
	foreach ($waves as $wave) {
		$cin_worker->esr_recount_wave_statistics($wave->id);
	}

}
