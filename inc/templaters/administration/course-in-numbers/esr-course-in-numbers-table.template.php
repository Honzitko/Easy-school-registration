<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Template_Courses_In_Numbers_Table {

	public static function esr_print_table( $wave_id ) {
		$user_hide_passed_courses = filter_var(get_user_meta(get_current_user_id(), 'esr_hide_passed_courses', true), FILTER_VALIDATE_BOOLEAN);

		if (($user_hide_passed_courses !== '') && $user_hide_passed_courses) {
			$summaries = ESR()->course_summary->get_active_course_summary_by_wave( $wave_id );
		} else {
			$summaries = ESR()->course_summary->get_course_summary_by_wave( $wave_id );
		}
		$user_can_view_registrations = current_user_can( 'esr_registration_view' );

		if ( $summaries !== null ) { ?>
			<label id="esr_hide_passed_courses" class="esr_checkbox_input"><input id="esr_hide_passed_courses" type="checkbox" name="esr_hide_passed_courses" <?php checked(true, $user_hide_passed_courses) ?>><?php _e('Hide passed courses', 'easy-school-registration'); ?></label>
			<table id="datatable" class="table table-default table-bordered esr-course-in-numbers-datatable esr-datatable esr-copy-table esr-excel-export">
			<colgroup>
				<col width="300">
				<col width="150">
			</colgroup>
			<thead>
			<tr>
				<th class="esr-filter-disabled no-sort"><?php _e( 'Course', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Status', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Day', 'easy-school-registration' ); ?></th>
				<th><?php _e( 'Time', 'easy-school-registration' ); ?></th>
				<th class="esr-filter-disabled no-sort"><?php _e( 'Solo', 'easy-school-registration' ); ?></th>
				<th class="esr-filter-disabled no-sort"><?php _e( 'Leaders', 'easy-school-registration' ); ?></th>
				<th class="esr-filter-disabled no-sort"><?php _e( 'Followers', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Level', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Group', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Hall', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'First Teacher', 'easy-school-registration' ); ?></th>
				<th class="no-sort"><?php _e( 'Second Teacher', 'easy-school-registration' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $summaries as $key => $summary ) {
				$hall    = ESR()->hall->get_hall( $summary->hall_key );
				$is_full = ESR()->course_summary->esr_is_course_full( $summary->summary_course_id );
				$classes = [];
				if ( $is_full ) {
					$classes = [ 'esr-full' ];
				}
				?>
				<tr class="<?php echo implode( ' ', $classes ) ?>">
					<td>
						<?php if ( $user_can_view_registrations ) { ?>
							<a target="_blank" href="admin.php?page=esr_admin_sub_page_registrations&cin_course_id=<?php echo $summary->summary_course_id ?>&cin_wave_id=<?php echo $summary->wave_id ?>">
								<?php echo $summary->title ?>
							</a>
						<?php } else {
							echo $summary->title;
						} ?>
					</td>
					<td><?php echo $is_full ? __( 'Course Full', 'easy-school-registration' ) : __( 'Spots Available', 'easy-school-registration' ) ?></td>
					<td><?php echo ESR()->day->get_day_title( $summary->day ) ?></td>
					<td><?php echo $summary->time_from . '/' . $summary->time_to ?></td>
					<?php if ( $summary->is_solo ) { ?>
						<td><?php echo $summary->registered_solo . '/' . $summary->max_solo . ( ( ESR()->pairing_mode->is_solo_manual( $summary->pairing_mode ) ) ? ' (' . $summary->waiting_solo . ')' : '' ); ?></td>
						<td></td>
						<td></td>
					<?php } else { ?>
						<td></td>
						<td><?php echo $summary->registered_leaders . '/' . $summary->max_leaders . ' (' . $summary->waiting_leaders . ')'; ?></td>
						<td><?php echo $summary->registered_followers . '/' . $summary->max_followers . ' (' . $summary->waiting_followers . ')'; ?></td>
					<?php } ?>
					<td><?php echo ESR()->course_level->get_title( $summary->level_id ); ?></td>
					<td><?php echo ESR()->course_group->get_title( $summary->group_id ); ?></td>
					<td><?php echo $hall !== [] ? $hall['name'] : '-' ?></td>
					<td><?php echo ESR()->teacher->get_teacher_name( $summary->teacher_first ) ?></td>
					<td><?php echo ESR()->teacher->get_teacher_name( $summary->teacher_second ) ?></td>
				</tr>
				<?php
			}
		}
		?></tbody></table><?php
	}
}

add_action( 'esr_print_course_in_numbers_table', [ 'ESR_Template_Courses_In_Numbers_Table', 'esr_print_table' ] );
