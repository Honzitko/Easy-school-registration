<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Payment_Form_Subblock_Templater {

	public function __construct() {
		add_action('esr_payment_form_input', [get_called_class(), 'input_user_email']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_wave_id']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_payment_type']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_payment_status']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_payment']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_note']);
		add_action('esr_payment_form_input', [get_called_class(), 'input_email_confirmation']);
		add_action('esr_payment_form_submit', [get_called_class(), 'input_submit']);
	}


	public function print_form() {
		?>
		<div id="esr-edit-box" class="esr-edit-box">
			<span class="close"><span class="dashicons dashicons-no-alt"></span></span>
			<form id="payments-form">
				<table>
					<?php
					do_action('esr_payment_form_input');
					do_action('esr_payment_form_submit');
					?>
				</table>
			</form>
		</div>
		<?php
	}


	public static function input_user_email() {
		?>
		<tr class="esr-student">
			<th><label for="user_email"><?php _e('Student Email', 'easy-school-registration') ?></label></th>
			<td>
				<input required type="text" name="user_email">
			</td>
		</tr>
		<?php
	}


	public static function input_wave_id() {
		?>
		<tr>
			<th><?php _e('Wave', 'easy-school-registration'); ?></th>
			<td>
				<select required name="wave_id">
					<option value=""><?php _e('- select -', 'easy-school-registration'); ?></option>
					<?php foreach (ESR()->wave->get_waves_data() as $key => $wave) { ?>
						<option value="<?php echo $wave->id; ?>"><?php echo $wave->title; ?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_payment() {
		?>
		<tr class="payment">
			<th><?php _e('Amount', 'easy-school-registration') ?></th>
			<td>
				<input required type="text" name="payment" class="esr-allow-decimal"><?php echo ESR()->currency->esr_currency_symbol(); ?>
			</td>
		</tr>
		<?php
	}


	public static function input_payment_status() {
		?>
		<tr>
			<th><?php _e('Payment Status', 'easy-school-registration'); ?></th>
			<td>
				<select required name="payment_status">
					<option value=""><?php _e('- select -', 'easy-school-registration'); ?></option>
					<option value="paid"><?php _e('Payment', 'easy-school-registration') ?></option>
					<option value="not_paying"><?php _e('Not paying this wave', 'easy-school-registration') ?></option>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_payment_type() {
		$default_method = intval(ESR()->settings->esr_get_option('default_payment_method', ESR_Enum_Payment_Type::CASH));
		?>
		<tr>
			<th><?php _e('Payment Method', 'easy-school-registration'); ?></th>
			<td>
				<select required name="payment_type">
					<?php foreach (ESR()->payment_type->get_items() as $key => $type) { ?>
						<option value="<?php echo $key ?>" <?php if ($key === $default_method) {
							echo 'data-default="1"';
						} selected($default_method, $key) ?>><?php echo $type['title']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
	}


	public static function input_note() {
		?>
		<tr>
			<th><?php _e('Note', 'easy-school-registration') ?></th>
			<td><textarea name="note"></textarea></td>
		</tr>
		<?php
	}


	public static function input_email_confirmation() {
		if (intval(ESR()->settings->esr_get_option('payment_confirmation_email_enabled', -1)) !== -1) {
			?>
			<tr>
				<th><?php _e('Send Payment Confirmation Email', 'easy-school-registration') ?></th>
				<td><input type="checkbox" name="esr_payment_email_confirmation" checked>
				</td>
			</tr>
			<?php
		}
	}


	public static function input_submit() {
		?>
		<tr>
			<th></th>
			<td>
				<input type="hidden" name="payment_id">
				<input type="submit" name="esr_payment_submit" value="<?php _e('Save Payment', 'easy-school-registration'); ?>">
			</td>
		</tr>
		<?php
	}

}
