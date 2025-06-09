<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Add_Over_Limit_Subblock_Templater
{

	public static function esr_print_add_over_limit_tab_callback()
	{
		$worker_add_over_limit = new ESR_Add_Over_Limit_Worker();
		$data                  = $_POST;

		if (isset($data['esr_add_over_limit_submit'])) {
			$worker_add_over_limit->process_form($data);
		}

		$selected_wave = apply_filters('esr_all_waves_select_get', []);
		?>
		<div class="wrap esr-settings">
			<div class="esr_controls">
				<?php do_action('esr_all_waves_select_print', $selected_wave); ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title col-md-6 col-sm-6 col-xs-6">
						<h2><?php _e('Leader', 'easy-school-registration'); ?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_title col-md-6 col-sm-6 col-xs-6">
						<h2><?php _e('Follower', 'easy-school-registration'); ?></h2>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="x_panel">
					<div class="x_content" style="display: block;">
						<form id="esr-add-over-limit" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"
						      data-parsley-validate="" class="form-horizontal form-label-left">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php _e('First Name', 'easy-school-registration'); ?>
										<span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="first-name" name="esr_leader_name"
										       class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php _e('Last Name', 'easy-school-registration'); ?> <span
												class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="last-name" name="esr_leader_surname"
										       class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label for="leader-email"
									       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Email', 'easy-school-registration'); ?> 
                                    <span class="required">*</span>
                                    </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="leader-email" class="form-control col-md-7 col-xs-12" type="email"
										       name="esr_leader_email">
									</div>
								</div>
								<div class="form-group">
									<label for="leader-phone"
									       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Phone', 'easy-school-registration'); ?> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="leader-phone" class="form-control col-md-7 col-xs-12" type="text"
										       name="esr_leader_phone">
									</div>
								</div>
								<?php if (intval(ESR()->settings->esr_get_option('free_registrations_enabled', -1)) != -1) { ?>
									<div class="form-group">
										<label for="leader-free-course"
										       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Free Course', 'easy-school-registration'); ?> </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="leader-free-course" class="form-control col-md-7 col-xs-12" type="checkbox" name="esr_leader_free_registration">
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
									<label for="middle-name"
									       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Course', 'easy-school-registration') ?> </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select name="esr_course_id">
											<?php
											$courses = ESR()->course->get_courses_data_by_wave($selected_wave);
											foreach ($courses as $id => $course) { ?>
												<option value="<?php echo $course->id; ?>"><?php echo stripslashes($course->title) . ' - ' . ESR()->day->get_day_title($course->day) . ' (' . $course->time_from . '/' . $course->time_to . ')'; ?></option>
											<?php }
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button type="submit" class="btn btn-success" name="esr_add_over_limit_submit"><?php _e('Send', 'easy-school-registration'); ?></button>
									</div>
								</div>
								<?php do_action('esr_add_leader_over_limit_form'); ?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php _e('First Name', 'easy-school-registration'); ?>
										<span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="first-name" name="esr_follower_name"
										       class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php _e('Last Name', 'easy-school-registration'); ?> <span
												class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" id="last-name" name="esr_follower_surname"
										       class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class="form-group">
									<label for="follower-email"
									       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Email', 'easy-school-registration'); ?>
                                    <span class="required">*</span>
                                    </label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="follower-email" class="form-control col-md-7 col-xs-12" type="email"
										       name="esr_follower_email">
									</div>
								</div>
								<div class="form-group">
									<label for="follower-phone"
									       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Phone', 'easy-school-registration'); ?></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="follower-phone" class="form-control col-md-7 col-xs-12" type="text"
										       name="esr_follower_phone">
									</div>
								</div>
								<?php if (intval(ESR()->settings->esr_get_option('free_registrations_enabled', -1)) != -1) { ?>
									<div class="form-group">
										<label for="follower-free-course"
										       class="control-label col-md-3 col-sm-3 col-xs-12"><?php _e('Free Course', 'easy-school-registration'); ?> </label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="follower-free-course" class="form-control col-md-7 col-xs-12" type="checkbox" name="esr_follower_free_registration">
										</div>
									</div>
								<?php } ?>
								<?php do_action('esr_add_follower_over_limit_form'); ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}

add_action('esr_print_add_over_limit_tab', ['ESR_Add_Over_Limit_Subblock_Templater', 'esr_print_add_over_limit_tab_callback']);
