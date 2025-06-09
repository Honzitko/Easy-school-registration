<?php
if (version_compare(get_site_option('esr_db_version'), '3.1.10', '<')) {
	global $wpdb;

	$waves = ESR()->wave->get_waves_data();

	$cin_worker = new ESR_Course_In_Numbers_Worker();
	foreach ($waves as $wave) {
		$cin_worker->esr_recount_wave_statistics($wave->id);
	}

}
