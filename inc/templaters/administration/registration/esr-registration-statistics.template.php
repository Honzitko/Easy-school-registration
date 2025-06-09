<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Registrations_Statistics_Template
{


	public static function esr_print_statistics($wave_id)
	{
		if (intval(ESR()->settings->esr_get_option('show_basic_statistics', -1)) !== -1) {
			$statistics = ESR()->statistics->esr_get_registration_statistics($wave_id);
			if ($statistics) {
				?>
				<div class="esr-statistics-box">
					<h4><?php _e('Basic Statistics', 'easy-school-registration'); ?></h4>
					<table>
						<tr>
							<th><?php _e('Confirmed', 'easy-school-registration'); ?>:</th>
							<td><?php echo $statistics->confirmed ?></td>
						</tr>
						<tr>
							<th><?php _e('Waiting', 'easy-school-registration'); ?>:</th>
							<td><?php echo $statistics->waiting ?></td>
						</tr>
						<tr>
							<th><?php _e('Deleted', 'easy-school-registration'); ?>:</th>
							<td><?php echo $statistics->deleted ?></td>
						</tr>
					</table>
				</div>
				<?php
			}
		}
	}
}

add_action('esr_print_registration_statistics', ['ESR_Registrations_Statistics_Template', 'esr_print_statistics']);
