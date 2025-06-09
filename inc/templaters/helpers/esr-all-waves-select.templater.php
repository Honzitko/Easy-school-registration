<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_All_Waves_Select_Templater {

	public static function esr_print_select($selected_wave = null) {
		$waves = ESR()->wave->get_waves_data();

		if (!$selected_wave) {
			$selected_wave = apply_filters('esr_all_waves_select_get', $waves);
		}

		?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="esr-select-wave">
			<span><?php echo __('Select Wave', 'easy-school-registration') . ': '; ?></span>
			<select name="esr_wave">
				<?php
				foreach ($waves as $key => $wave) {
					?>
					<option
					value="<?php echo $wave->id ?>" <?php if ($wave->id == $selected_wave) { ?>selected="selected"<?php } ?>><?php echo $wave->title; ?></option><?php
				}
				?>
			</select>
			<input type="submit" name="esr_choose_wave_submit" class="page-title-action"  value="<?php _e('Select', 'easy-school-registration'); ?>">
		</form>
		<?php
	}


	/**
	 * @param array $waves
	 *
	 * @return int
	 */
	public static function esr_get_selected_wave($waves = []) {
		$user_saved_wave = get_user_meta(get_current_user_id(), 'esr_user_wave_id');
		if (isset($_POST['esr_choose_wave_submit']) && isset($_POST['esr_wave'])) {
			update_user_meta(get_current_user_id(), 'esr_user_wave_id', $_POST['esr_wave']);
			return $_POST['esr_wave'];
		} else if (count($user_saved_wave) > 0) {
			return $user_saved_wave[0];
		} else if ($waves) {
			return reset($waves);
		} else {
			$waves = ESR()->wave->get_waves_data();
			$wave  = reset($waves);
			if ($wave) {
				return $wave->id;
			}
		}

		return null;
	}
}

add_filter('esr_all_waves_select_get', ['ESR_All_Waves_Select_Templater', 'esr_get_selected_wave']);

add_action('esr_all_waves_select_print', ['ESR_All_Waves_Select_Templater', 'esr_print_select']);