<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Schedule_Wave_Filter {

	public function print_filter($wave_ids) {
		if ($wave_ids && is_array($wave_ids) && (count($wave_ids) > 1)) {
			?><label><?php _e('Filter by wave:'); ?> <select class="esr-filter-schedule" name="wave-id"><?php
			foreach ($wave_ids as $wave_id) {
				$wave_data = ESR()->wave->get_wave_data($wave_id);
				?>
				<option value="<?php echo $wave_id ?>"><?php echo $wave_data->title; ?></option>
				<?php
			}
				?></select></label><?php
		}
	}

}