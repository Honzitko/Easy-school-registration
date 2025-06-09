<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Template_Students {

	const MENU_SLUG = 'esr_admin_sub_page_students';

	public static function print_page() {
		$template_table = new ESR_Template_Students_Table();

		?>
		<div class="wrap esr-settings esr-students">
			<h1 class="wp-heading-inline"><?php _e('Students Overview', 'easy-school-registration'); ?></h1>
			<div class="esr-student-data">
				<table>
					<tr>
						<th><?php _e('Name', 'easy-school-registration'); ?></th>
						<td class="esr-user-name"></td>
					</tr>
					<tr>
						<th><?php _e('Email', 'easy-school-registration'); ?></th>
						<td class="esr-user-email"></td>
					</tr>
					<tr>
						<th><?php _e('Phone', 'easy-school-registration'); ?></th>
						<td class="esr-user-phone"></td>
					</tr>
					<tr>
						<th><?php _e('Note', 'easy-school-registration'); ?></th>
						<td class="esr-user-note">
							<textarea name="esr_user_note"></textarea>
							<i class="esr_save_spinner"></i>
							<span class="esr_save_confirmed dashicons dashicons-yes"></span>
							<button name="esr_save_student_note"><?php _e('Save Note', 'easy-school-registration'); ?></button>
						</td>
					</tr>
					<tr>
						<th><?php _e('Registered Courses', 'easy-school-registration'); ?></th>
						<td class="esr-user-registrations">
							<table class="table table-default table-bordered">
								<thead>
								<tr>
									<th><?php _e('Status', 'easy-school-registration'); ?></th>
									<th><?php _e('Wave', 'easy-school-registration'); ?></th>
									<th><?php _e('Course', 'easy-school-registration'); ?></th>
								</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<th><?php _e('Payments', 'easy-school-registration'); ?></th>
						<td class="esr-user-payments">
							<table class="table table-default table-bordered">
								<thead>
								<tr>
									<th><?php _e('Wave', 'easy-school-registration'); ?></th>
									<th><?php _e('Status', 'easy-school-registration'); ?></th>
									<th><?php _e('To Pay', 'easy-school-registration'); ?></th>
									<th><?php _e('Paid', 'easy-school-registration'); ?></th>
								</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<?php $template_table->print_table(); ?>
		</div>
		<?php
	}
}
