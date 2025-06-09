<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Templater_User_Info_Courses_Table {

	public function print_content($wave_id) {
		$registrations = ESR()->registration->get_registrations_by_wave_and_user((int) $wave_id, get_current_user_id());
		$waves         = ESR()->wave->get_waves_data(true);
		?>
		<table id="datatable" class="table table-default table-bordered esr-datatable">
		<thead>
		<tr>
			<th><?php _e('Course Status', 'easy-school-registration'); ?></th>
			<th><?php _e('Registration Status', 'easy-school-registration'); ?></th>
			<th><?php _e('Wave', 'easy-school-registration'); ?></th>
			<th><?php _e('Course', 'easy-school-registration'); ?></th>
			<th><?php _e('Day', 'easy-school-registration'); ?></th>
			<th><?php _e('Time', 'easy-school-registration'); ?></th>
			<th><?php _e('Dancing Role', 'easy-school-registration'); ?></th>
			<th><?php _e('Registered Partner', 'easy-school-registration'); ?></th>
		</tr>
		</thead>
		<tbody class="list">
		<?php
		if ( ! empty($registrations)) {
			foreach ($registrations as $key => $registration) {
				$course_enabled = ESR()->course->is_course_enabled($registration->course_id);
				$status = $registration->status == 3 ? 3 : ($registration->status == 2 ? 2 : ($course_enabled ? 1 : 0));
				$student = get_user_by('email', trim($registration->dancing_with));
				$partner_name = (($registration->dancing_with !== '') && ($registration->dancing_with !== null) && $student && $registration->partner_id && ($student->ID == $registration->partner_id) ? get_userdata($registration->partner_id)->display_name : '');
				?>
			<tr class="esr-row status-<?php echo $status; ?>">
				<td class="stat"><?php echo $course_enabled ? __('Not full', 'easy-school-registration') : __('Full', 'easy-school-registration'); ?></td>
				<td class="stat"><?php echo ESR()->registration_status->get_title($registration->status); ?></td>
				<td><?php echo $waves[$registration->wave_id]->title; ?></td>
				<td><?php echo $registration->title; ?></td>
				<td><?php echo ESR()->day->get_day_title($registration->day); ?></td>
				<td><?php echo $registration->time_from . ' / ' . $registration->time_to; ?></td>
				<td><?php echo ESR()->dance_as->get_title($registration->dancing_as); ?></td>
				<td><?php echo $registration->dancing_with; ?></td>
				</tr><?php
			}
		}
		?>
		</tbody>
		</table><?php


	}

}