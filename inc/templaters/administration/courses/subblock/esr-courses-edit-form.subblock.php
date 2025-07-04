<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Courses_Edit_Form_Subblock_Templater {

	public function __construct() {
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_title']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_wave_id']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_hall_key']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_teacher_first']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_teacher_second']);
		if (intval(ESR()->settings->esr_get_option('multiple_dates', -1)) === -1) {
			add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_day']);
		}
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_date']);
		if (intval(ESR()->settings->esr_get_option('multiple_dates', -1)) === -1) {
			add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_time']);
		}
		if (intval(ESR()->settings->esr_get_option('multiple_dates', -1)) === 1) {
			add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_days']);
		}
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_is_solo']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_max_leaders']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_max_followers']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_max_solo']);
		add_action('esr_course_edit_main_form_input', [get_called_class(), 'input_price']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_sub_header']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_group_id']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_level_id']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_pairing_mode']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_enforce_partner']);
		add_action('esr_course_edit_additional_form_input', [get_called_class(), 'input_course_settings']);
		add_action('esr_course_edit_form_submit', [get_called_class(), 'input_submit'], 10, 2);
	}


	public function print_content($course_id = null, $duplicate = 0) {
		$course = ESR()->course->get_course_data($course_id);
		?>
		<div>
			<h1 class="wp-heading-inline"><?php _e('Edit Course', 'easy-school-registration') ?></h1>
			<form action="<?php echo ($duplicate === 1) || ($course_id === -1) ? remove_query_arg(['esr_duplicate', 'course_id']) : $_SERVER['REQUEST_URI'] ?>" method="post" class="esr-edit-form esr-course-edit">
				<div class="esr-form-column">
					<h3><?php esc_html_e('Main Info', 'easy-school-registration'); ?></h3>
					<table>
						<?php
						do_action('esr_course_edit_main_form_input', $course);
						do_action('esr_course_edit_form_module_input', $course);
						?>
					</table>
				</div>
				<div class="esr-form-column">
					<h3><?php esc_html_e('Additional Info', 'easy-school-registration'); ?></h3>
					<table>
						<?php
						do_action('esr_course_edit_additional_form_input', $course);
						do_action('esr_course_edit_form_module_input', $course);
						?>
					</table>
				</div>
				<?php do_action('esr_course_edit_form_submit', $course, $duplicate); ?>
			</form>
		</div>
		<?php
	}


	public static function input_title($course) {
		?>
		<tr>
			<th><?php esc_html_e('Title', 'easy-school-registration'); ?></th>
			<td><input required type="text" name="title" value="<?php echo $course !== null ? $course->title : ''; ?>"></td>
		</tr>
		<?php
	}


	public static function input_sub_header($course) {
		?>
		<tr>
			<th><?php esc_html_e('Subtitle', 'easy-school-registration'); ?></th>
			<td><input type="text" name="sub_header" value="<?php echo $course !== null ? $course->sub_header : ''; ?>"></td>
		</tr>
		<?php
	}


	public static function input_content($course) {
		?>
		<tr>
			<th><?php esc_html_e('Content', 'easy-school-registration'); ?></th>
			<td><textarea name="content"></textarea></td>
		</tr>
		<?php
	}


	public static function input_wave_id($course) {
		?>
		<tr>
			<th><?php esc_html_e('Wave', 'easy-school-registration'); ?></th>
			<td>
				<select name="wave_id">
					<option value="" <?php selected($course !== null ? $course->wave_id : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->wave->get_waves_data() as $key => $wave) {
						$wave_settings = json_decode($wave->wave_settings); ?>
						<option value="<?php echo $wave->id; ?>" <?php selected($course !== null ? $course->wave_id : '', $wave->id) ?>
							<?php echo isset($wave_settings->courses_from) && $wave_settings->courses_from ? ' data-course-from="' . $wave_settings->courses_from . '"' : '' ?>
							<?php echo isset($wave_settings->courses_to) && $wave_settings->courses_to ? ' data-course-to="' . $wave_settings->courses_to . '"' : '' ?>
						><?php echo $wave->title; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_hall_key($course) {
		?>
		<tr>
			<th><?php esc_html_e('Hall', 'easy-school-registration'); ?></th>
			<td>
				<select name="hall_key">
					<option value="" <?php selected($course !== null ? $course->hall_key : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->hall->get_halls() as $key => $hall) { ?>
						<option
								value="<?php echo $key; ?>"
								data-couples="<?php echo (isset($hall['couples']) && !empty($hall['couples']) ? $hall['couples'] : 0) ?>"
								data-solo="<?php echo (isset($hall['solo']) && !empty($hall['solo']) ? $hall['solo'] : 0) ?>"
								<?php selected($course !== null ? intval($course->hall_key) : '', $key) ?>
								><?php echo $hall['name']; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}


	private static function add_teacher($course, $name, $key) {
		?>
		<tr>
			<th><?php esc_html_e($name, 'easy-school-registration'); ?></th>
			<td>
				<select name="<?php echo $key ?>">
					<option value="" <?php selected($course !== null ? intval($course->$key) : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->teacher->get_teachers_data() as $teacher_key => $teacher) {
						?>
						<option value="<?php echo $teacher->id; ?>" <?php selected(($course !== null) && isset($course->$key) ? intval($course->$key) : '', $teacher->id) ?> <?php echo !$teacher->active ? 'disabled' : ''; ?>><?php echo $teacher->name; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_teacher_first($course) {
		self::add_teacher($course, 'First Teacher', 'teacher_first');
	}


	public static function input_teacher_second($course) {
		self::add_teacher($course, 'Second Teacher', 'teacher_second');
	}


	public static function input_day($course) {
		?>
		<tr>
			<th><?php esc_html_e('Course Day', 'easy-school-registration'); ?></th>
			<td>
				<select name="day">
					<option value="" <?php selected($course !== null ? $course->day : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->day->get_items() as $key => $item) { ?>
						<option value="<?php echo $key; ?>" <?php selected($course !== null ? $course->day : '', $key) ?>><?php esc_html_e($item['title'], 'easy-school-registration'); ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_date($course) {
		?>
		<tr>
			<th><?php esc_html_e('Course Date From-To', 'easy-school-registration'); ?></th>
			<td>
				<input name="course_from" type="date" value="<?php echo $course !== null ? date('Y-m-d', strtotime($course->course_from)) : ''; ?>">
				<input name="course_to" type="date" value="<?php echo $course !== null ? date('Y-m-d', strtotime($course->course_to)) : ''; ?>">
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('Define the time period when the course is running.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_time($course) {
		?>
		<tr>
			<th><?php esc_html_e('Course Time From-To', 'easy-school-registration'); ?></th>
			<td>
				<input name="time_from" class="esr-time-from" type="time" value="<?php echo $course !== null ? $course->time_from : ''; ?>">
				<input name="time_to" class="esr-time-to" type="time" value="<?php echo $course !== null ? $course->time_to : ''; ?>">
				<?php
				$default_times = ESR()->settings->esr_get_option('course_times', []);
				if (!empty($default_times)) {
					echo '<ul class="default-times">';
					foreach ($default_times as $key => $times) {
						$time_from = (isset($times['from']) ? $times['from'] : '');
						$time_to   = (isset($times['to']) ? $times['to'] : '');
						echo '<li><a href="#" data-time-from="' . $time_from . '" data-time-to="' . $time_to . '">' . $time_from . ' - ' . $time_to . '</a></li>';
					}
					echo '</ul>';
				}
				?>
			</td>
		</tr>
		<?php
	}


	public static function input_days($course) {
		$dates = [];

		if ($course !== null) {
			$dates = ESR()->multiple_dates->esr_get_multiple_dates($course->id);
		}

		if ($course === null) {
			$date            = new stdClass();
			$date->day       = '';
			$date->time_from = '';
			$date->time_to   = '';
			$dates[0]        = $date;
		} else if (empty($dates)) {
			$date            = new stdClass();
			$date->day       = $course->day;
			$date->time_from = $course->time_from;
			$date->time_to   = $course->time_to;
			$dates[0]        = $date;
		}

		?>
		<tr class="esr-course-days">
			<th><?php esc_html_e('Course Days', 'easy-school-registration'); ?></th>
			<td>
				<table>
					<thead>
					<tr>
						<th><?php esc_html_e('Day', 'easy-school-registration'); ?></th>
						<th><?php esc_html_e('Time From / To', 'easy-school-registration'); ?></th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($dates as $dkey => $date) { ?>
						<tr data-name="<?php echo $dkey; ?>">
							<td>
								<select name="course-days[<?php echo $dkey; ?>][day]">
									<option value="" <?php selected($course !== null ? $date->day : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
									<?php foreach (ESR()->day->get_items() as $key => $item) { ?>
										<option value="<?php echo $key; ?>" <?php selected($course !== null ? $date->day : '', $key) ?>><?php esc_html_e($item['title'], 'easy-school-registration'); ?></option>
										<?php
									}
									?>
								</select>
								<a class="esr-add-new-day" href="javascript:;">
									<span class="dashicons dashicons-plus"></span>
									<span><?php _e('Add Day', 'easy-school-registration'); ?></span>
								</a>
							</td>
							<td>
								<div class="esr-course-times">
									<input name="course-days[<?php echo $dkey; ?>][time_from]" class="esr-time-from" type="time" value="<?php echo $course !== null ? $date->time_from : ''; ?>">
									<input name="course-days[<?php echo $dkey; ?>][time_to]" class="esr-time-to" type="time" value="<?php echo $course !== null ? $date->time_to : ''; ?>">
								</div>
								<?php
								$default_times = ESR()->settings->esr_get_option('course_times', []);
								if (!empty($default_times)) {
									echo '<ul class="default-times">';
									foreach ($default_times as $key => $times) {
										$time_from = (isset($times['from']) ? $times['from'] : '');
										$time_to   = (isset($times['to']) ? $times['to'] : '');
										echo '<li><a href="#" data-time-from="' . $time_from . '" data-time-to="' . $time_to . '">' . $time_from . ' - ' . $time_to . '</a></li>';
									}
									echo '</ul>';
								}
								?>
							</td>
							<td><a class="esr-remove-new-day" href="javascript:;">
									<span class="dashicons dashicons-no"></span>
									<span><?php _e('Remove', 'easy-school-registration'); ?></span>
								</a></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</td>
		</tr>
		<?php
	}


	public static function input_is_solo($course) {
		?>
		<tr>
			<th><?php esc_html_e('Solo Class', 'easy-school-registration'); ?></th>
			<td><input type="checkbox" name="is_solo" class="esr-toggle-on-change" <?php checked($course !== null ? intval($course->is_solo) : 0, 1) ?> data-show=".max_solo" data-hide=".max_leaders, .max_followers">
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('If selected, the Course does not have Leader and Follower roles. The default pairing mode is Confirm All, unless changed to Manual.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	private static function add_number($course, $name, $key, $class = '', $hidden = false) {
		?>
		<tr class="<?php echo $class; ?>" <?php echo($hidden ? 'style="display:none;"' : ''); ?>>
			<th><?php esc_html_e($name, 'easy-school-registration'); ?></th>
			<td><input type="number" name="<?php echo $key; ?>" value="<?php echo $course !== null ? $course->{$key} : 0; ?>" class="<?php echo $class ?>"></td>
		</tr>
		<?php
	}


	public static function input_max_leaders($course) {
		self::add_number($course, 'Max Leaders', 'max_leaders', 'hide_solo', $course !== null ? $course->is_solo : false);
	}


	public static function input_max_followers($course) {
		self::add_number($course, 'Max Followers', 'max_followers', 'hide_solo', $course !== null ? $course->is_solo : false);
	}


	public static function input_max_solo($course) {
		self::add_number($course, 'Max Attendance', 'max_solo', 'show_solo', $course !== null ? !$course->is_solo : true);
	}


	public static function input_price($course) {
		?>
		<tr>
			<th><?php esc_html_e('Price', 'easy-school-registration'); ?></th>
			<td><input type="number" name="price" value="<?php echo $course !== null ? $course->price : ESR()->settings->esr_get_option('course_price', 0) ?>"> <?php echo ESR()->currency->esr_currency_symbol(); ?></td>
		</tr>
		<?php
	}


	public static function input_group_id($course) {
		?>
		<tr>
			<th><?php esc_html_e('Group', 'easy-school-registration'); ?></th>
			<td>
				<select name="group_id">
					<option value="" <?php selected($course !== null ? $course->group_id : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->course_group->get_items() as $key => $item) { ?>
						<option value="<?php echo $key; ?>" <?php selected($course !== null ? $course->group_id : '', $key) ?>><?php esc_html_e($item, 'easy-school-registration'); ?></option>
						<?php
					}
					?>
				</select>
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('Groups can be defined in Settings -> General -> Courses. Assigning courses to groups, you are able to define group bulk discounts as well as specific colors and filters in the Registration Form.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_level_id($course) {
		?>
		<tr>
			<th><?php esc_html_e('Level', 'easy-school-registration'); ?></th>
			<td>
				<select name="level_id">
					<option value="" <?php selected($course !== null ? $course->level_id : '', '') ?>><?php esc_html_e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->course_level->get_items() as $key => $item) { ?>
						<option value="<?php echo $key; ?>" <?php selected($course !== null ? $course->level_id : '', $key) ?>><?php esc_html_e($item, 'easy-school-registration'); ?></option>
						<?php
					}
					?>
				</select>
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('Levels can be defined in Settings -> General -> Courses. Assigning courses to levels, you are able to define specific colors and filters in the Registration Form.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_pairing_mode($course) {
		$default = (int) ESR()->settings->esr_get_option('pairing_mode', ESR_Enum_Pairing_Mode::AUTOMATIC);
		?>
		<tr>
			<th><?php esc_html_e('Pairing Mode', 'easy-school-registration'); ?></th>
			<td>
				<?php foreach (ESR()->pairing_mode->get_items() as $key => $mode) {
					?>
					<label>
						<input type="radio" name="pairing_mode" <?php checked($course !== null ? $course->pairing_mode : $default, $key) ?> value="<?php echo $key; ?>" class="<?php if ($default === $key) {
							echo 'esr-default';
						} ?>"> <?php echo $mode['title']; ?>
						<?php ESR_Tooltip_Templater_Helper::print_tooltip($mode['tooltip']); ?>
					</label><br>
				<?php } ?>
			</td>
		</tr>
		<?php
	}


	public static function input_enforce_partner($course) {
		?>
		<tr>
			<th><?php esc_html_e('Couples Only', 'easy-school-registration'); ?></th>
			<td>
				<input type="checkbox" name="enforce_partner" <?php checked($course !== null ? intval($course->enforce_partner) : 0, 1) ?>>
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('If selected, students will be able to register only with a partner.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_course_settings($course) {
		?>
		<tr>
			<th><?php esc_html_e('Disable Registrations', 'easy-school-registration'); ?></th>
			<td>
				<input type="checkbox" name="course_settings[disable_registration]" <?php checked($course !== null && isset($course->disable_registration) && $course->disable_registration ? intval($course->disable_registration) : 0, 1) ?>>
				<?php ESR_Tooltip_Templater_Helper::print_tooltip(__('If selected, registrations for this course will be disabled.', 'easy-school-registration')); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_submit($course, $duplicate) {
		?>
		<tr>
			<th></th>
			<td>
				<input type="hidden" name="course_id" value="<?php echo ($course !== null) && ($duplicate === 0) ? $course->id : ''; ?>">
				<input type="submit" name="esr_choose_course_submit" value="<?php esc_html_e('Save', 'easy-school-registration'); ?>">
			</td>
		</tr>
		<?php
	}
}
