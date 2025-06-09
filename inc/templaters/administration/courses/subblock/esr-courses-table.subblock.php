<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Courses_Table_Subblock_Templater {

	public function print_table() {
		$courses = ESR()->course->get_courses_data();
		$waves   = ESR()->wave->get_waves_data(true);
		$user_can_edit = current_user_can('esr_course_edit');

		?>
		<h1 class="wp-heading-inline"><?php _e('Courses', 'easy-school-registration'); ?></h1>
		<?php if ($user_can_edit) { ?>
			<a href="<?php echo esc_url(add_query_arg('course_id', -1)) ?>" class="esr-add-new page-title-action"><?php _e('Add New Course', 'easy-school-registration'); ?></a>
		<?php } ?>
		<table id="datatable" class="table table-default table-bordered esr-datatable">
			<colgroup>
				<col width="10">
				<col width="90">
				<col width="100">
			</colgroup>
			<thead>
			<tr>
				<?php if ($user_can_edit) { ?>
					<th class="esr-filter-disabled" data-key="esr_id"><?php _e('ID', 'easy-school-registration'); ?></th>
					<th class="esr-filter-disabled no-sort" data-key="esr_actions"><?php _e('Actions', 'easy-school-registration'); ?></th>
				<?php } ?>
				<th class="no-sort" data-key="esr_status"><?php _e('Status', 'easy-school-registration'); ?></th>
				<th class="no-sort" data-key="esr_title"><?php _e('Title', 'easy-school-registration'); ?></th>
				<th class="no-sort" data-key="esr_date"><?php _e('Date', 'easy-school-registration'); ?></th>
				<th class="no-sort" data-key="esr_wave"><?php _e('Wave', 'easy-school-registration'); ?></th>
			</tr>
			</thead>
			<tbody class="list">
			<?php foreach ($courses as $course) { ?>
				<tr class="esr-row<?php echo $course->is_passed ? ' passed' : ''; ?>"
					data-id="<?php echo $course->id; ?>">
					<?php if ($user_can_edit) { ?>
						<td><?php echo $course->id; ?></td>
						<td class="actions esr-course">
							<div class="esr-relative">
								<button class="page-title-action"><?php _e('Actions', 'easy-school-registration') ?></button>
								<?php $this->print_action_box($course->id); ?>
							</div>
						</td>
					<?php } ?>
					<td class="esr_course_status"><?php echo $course->is_passed ? __('Passed', 'easy-school-registration') : __('Active', 'easy-school-registration'); ?></td>
					<td><?php echo stripslashes($course->title); ?></td>
					<td><?php if ($course->day && $course->time_from && $course->time_to) { echo ESR()->day->get_day_title($course->day) . ' - ' . $course->time_from . '/' . $course->time_to; } ?></td>
					<td><?php echo '(' . $course->wave_id . ') ' . $waves[$course->wave_id]->title; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php
	}


	private function print_action_box($id) {
		?>
		<ul class="esr-actions-box dropdown-menu" data-id="<?php echo $id; ?>">
			<li class="esr-action edit">
				<a href="<?php echo esc_url(add_query_arg('course_id', $id)) ?>">
					<span class="dashicons dashicons-edit"></span>
					<span><?php _e('Edit', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<li class="esr-action duplicate">
				<a href="<?php echo esc_url(add_query_arg(['course_id'=> $id, 'esr_duplicate' => true])) ?>">
					<span class="dashicons dashicons-admin-page"></span>
					<span><?php _e('Duplicate', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<li class="esr-action deactivate">
				<a href="javascript:;">
					<span class="dashicons dashicons-hidden"></span>
					<span><?php _e('Set passed', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<li class="esr-action remove-forever">
				<a href="javascript:;">
					<span class="dashicons dashicons-trash"></span>
					<span><?php _e('Delete forever', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<li class="esr-action activate">
				<a href="javascript:;">
					<span class="dashicons dashicons-visibility"></span>
					<span><?php _e('Set active', 'easy-school-registration'); ?></span>
				</a>
			</li>
		</ul>
		<?php
	}

}