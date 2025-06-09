<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Payment_Statistics_Template
{
	public static function esr_print_statistics($wave_id)
	{
		if (intval(ESR()->settings->esr_get_option('show_basic_statistics', -1)) !== -1) {
			$statistics = ESR()->statistics->esr_get_payment_statistics($wave_id);
			if ($statistics) {
				?>
				<div class="esr-statistics-box">
					<h4><?php _e('Basic Statistics', 'easy-school-registration'); ?></h4>
					<table>
						<tr>
							<th><?php echo ESR()->payment_status->get_title(ESR_Enum_Payment::PAID); ?>:</th>
							<td><?php echo ESR()->currency->prepare_price($statistics->paid); ?></td>
						</tr>
						<tr>
							<th><?php echo ESR()->payment_status->get_title(ESR_Enum_Payment::NOT_PAYING); ?>:</th>
							<td><?php echo ESR()->currency->prepare_price($statistics->not_paying); ?></td>
						</tr>
						<tr>
							<th><?php echo ESR()->payment_status->get_title(ESR_Enum_Payment::NOT_PAID); ?>:</th>
							<td><?php echo ESR()->currency->prepare_price($statistics->no_paid); ?></td>
						</tr>
						<tr>
							<th><?php _e('Total', 'easy-school-registration'); ?>:</th>
							<td><?php echo ESR()->currency->prepare_price($statistics->total); ?></td>
						</tr>
					</table>
				</div>
				<?php
			}
		}
	}
}

add_action('esr_print_payment_statistics', ['ESR_Payment_Statistics_Template', 'esr_print_statistics']);
