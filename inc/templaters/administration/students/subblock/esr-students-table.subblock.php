<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Template_Students_Table {

	public function print_table() {
		?>

			<table id="datatable" class="table table-default table-bordered esr-datatable esr-settings-students esr-newsletter-email-export">
				<thead>
				<tr>
					<th class="esr-filter-disabled no-sort esr-hide-print"><?php _e('Actions', 'easy-school-registration'); ?></th>
					<th class="esr-filter-disabled no-sort"><?php _e('Student Name', 'easy-school-registration'); ?></th>
					<th class="esr-filter-disabled no-sort esr-student-email"><?php _e('Student Email', 'easy-school-registration'); ?></th>
					<th class="esr-filter-disabled no-sort"><?php _e('Phone Number', 'easy-school-registration'); ?></th>
					<th class="no-sort"><?php _e('Newsletter', 'easy-school-registration'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach (get_users() as $key => $user) {
					$newsletter = get_user_meta($user->ID, 'esr-course-registration-newsletter', true);
					$phone = get_user_meta($user->ID, 'esr-course-registration-phone', true);
					?>
					<tr class="esr-row <?php echo ($newsletter ? 'esr-has-newsletter' : ''); ?>">
						<td class="actions esr-student esr-hide-print">
							<div class="esr-relative">
								<button class="page-title-action"><?php _e('Actions', 'easy-school-registration') ?></button>
								<?php $this->print_action_box($user->ID); ?>
							</div>
						</td>
						<td><?php echo $user->display_name; ?></td>
						<td><?php echo $user->user_email; ?></td>
						<td><?php echo ($phone ? $phone : ''); ?></td>
						<td><?php echo ($newsletter ? __('Yes', 'easy-school-registration') : __('No', 'easy-school-registration')); ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
		<?php
	}


	private function print_action_box($id) {
		?>
		<ul class="esr-actions-box dropdown-menu" data-id="<?php echo $id; ?>">
			<li class="esr-action show">
				<a href="javascript:;">
					<span class="dashicons dashicons-visibility"></span>
					<span><?php _e('Show', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<?php if (intval(ESR()->settings->esr_get_option('gdpr_email_enabled', -1)) !== -1) { ?>
			<li class="esr-action download">
				<a href="javascript:;">
					<span class="dashicons dashicons-download"></span>
					<span><?php _e('Send Export', 'easy-school-registration'); ?></span>
				</a>
			</li>
			<?php } ?>
		</ul>
		<?php
	}

}
