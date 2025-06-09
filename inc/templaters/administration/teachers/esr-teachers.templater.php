<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Templater_Teachers {

	const MENU_SLUG = 'esr_admin_teachers';


	public static function print_content() {
		$subblock_teacher_table = new ESR_Teachers_Table_Subblock_Templater();
		$subblock_edit_form     = new ESR_Teachers_Edit_Form_Subblock_Templater();
		$worker_teacher         = new ESR_Teacher_Worker();

		if (isset($_POST['esr_save_teacher']) && current_user_can('esr_teacher_edit')) {
			$worker_teacher->process_teacher($_POST);
		}
		?>
		<div class="wrap esr-settings ">
			<h1 class="wp-heading-inline"><?php _e('Teachers', 'easy-school-registration'); ?></h1>
			<?php if (current_user_can('esr_teacher_edit')) { ?>
				<a href="#" class="esr-add-new page-title-action"><?php _e('Add New Teacher', 'easy-school-registration'); ?></a>
			<?php } ?>
			<?php
			if (current_user_can('esr_teacher_edit')) {
				$subblock_edit_form->print_content();
			}
			$subblock_teacher_table->print_table();
			?>
		</div>
		<?php
	}

}
