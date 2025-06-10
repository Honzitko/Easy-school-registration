<?php


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
        exit;
}


function esr_install() {
	esr_run_install();
}

register_activation_hook(ESR_PLUGIN_FILE, 'esr_install');


function esr_run_install() {
	global $esr_settings;

	$options = [];

	// Populate some default values
	foreach (ESR()->settings->esr_get_registered_settings() as $tab => $sections) {
		foreach ($sections as $section => $settings) {
			// Check for backwards compatibility
			$tab_sections = ESR()->settings->esr_get_settings_tab_sections($tab);
			if (!is_array($tab_sections) || !array_key_exists($section, $tab_sections)) {
				$settings = $sections;
			}

			foreach ($settings as $option) {
				if (!empty($option['type']) && 'checkbox' == $option['type'] && !empty($option['std'])) {
					$options[$option['id']] = '1';
				}
			}
		}

	}

	$merged_options = array_merge($esr_settings, $options);
	$esr_settings   = $merged_options;

	update_option('esr_settings', $merged_options);
	update_option('esr_version', ESR_VERSION);
}
