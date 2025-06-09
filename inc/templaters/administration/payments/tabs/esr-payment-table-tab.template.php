<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Tab_Template_Payment_Table {

	public static function esr_print_table( $selected_wave ) {
		$template_payment_form = new ESR_Payment_Form_Subblock_Templater();
		$user_can_edit         = current_user_can( 'esr_payment_edit' );
		$user_show_emails      = current_user_can( 'esr_show_student_emails' );
		$show_phone            = intval( ESR()->settings->esr_get_option( 'show_phone_in_payments', - 1 ) ) === 1;

		$payments = ESR()->payment->get_payments_by_wave( $selected_wave );

		?>
		<h1 class="wp-heading-inline"><?php _e( 'Payments', 'easy-school-registration' ); ?></h1>
		<?php if ( $user_can_edit ) { ?>
			<a href="#" class="esr-add-new page-title-action"><?php _e( 'Add New Payment', 'easy-school-registration' ); ?></a>
		<?php }

		do_action( 'esr_all_waves_select_print', $selected_wave );
		do_action( 'esr_print_payment_statistics', $selected_wave );

		if ( $user_can_edit ) {
			$template_payment_form->print_form();
		}

		$classes = [ 'esr-datatable table table-default table-bordered esr-payments-table' ];

		if ( $user_can_edit ) {
			$classes[] = 'esr-copy-table esr-excel-export';
		}
		if ( $user_show_emails ) {
			$classes[] = 'esr-email-export';
		}

		?>


		<table id="datatable" class="<?php echo implode( ' ', $classes ) ?>">
			<colgroup>
				<col width="10">
				<?php if ( $user_can_edit ) { ?>
					<col width="100">
				<?php } ?>
			</colgroup>
			<thead>
			<tr>
				<th class="no-sort"><?php _e( 'Status', 'easy-school-registration' ) ?></th>
				<?php if ( $user_can_edit ) { ?>
					<th class="esr-filter-disabled skip-filter no-sort esr-hide-print"><?php _e( 'Actions', 'easy-school-registration' ) ?></th>
				<?php } ?>
				<th class="no-sort"><?php _e( 'Payment Method', 'easy-school-registration' ) ?></th>
				<th class="esr-filter-disabled skip-filter"><?php _e( 'Note', 'easy-school-registration' ) ?></th>
				<th class="esr-filter-disabled skip-filter"><?php _e( 'Student Name', 'easy-school-registration' ) ?></th>
				<?php if ( $user_show_emails ) { ?>
					<th class="esr-filter-disabled skip-filter esr-student-email"><?php _e( 'Student Email', 'easy-school-registration' ) ?></th>
				<?php } ?>
				<?php if ( $show_phone ) { ?>
					<th class="esr-filter-disabled esr-student-phone"><?php _e( 'Phone', 'easy-school-registration' ); ?></th>
				<?php } ?>
				<th class="esr-filter-disabled skip-filter"><?php _e( 'Variable Symbol', 'easy-school-registration' ) ?></th>
				<?php if ( intval( ESR()->settings->esr_get_option( 'show_courses', - 1 ) ) === 1 ) { ?>
					<th class="esr-multiple-filters"><?php _e( 'Courses', 'easy-school-registration' ) ?></th>
				<?php } ?>
				<th class="skip-filter"><?php _e( 'To pay', 'easy-school-registration' ) ?></th>
				<th class="skip-filter"><?php _e( 'Paid', 'easy-school-registration' ) ?></th>
				<?php
				$other_columns = apply_filters( 'esr_payment_table_other_columns_header', [] );
				foreach ( $other_columns as $key => $column ) {
					echo '<th class="' . ( isset( $column['classes'] ) ? $column['classes'] : '' ) . '">' . $column['title'] . '</th>';
				}
				?>
			</tr>
			</thead>
			<tbody class="list">
			<?php
			foreach ( $payments

			as $k => $user_payment ) {
			$user_data   = get_userdata( $user_payment['user_id'] );
			$user_email  = $user_data ? $user_data->user_email : __( 'deleted student', 'easy-school-registration' );
			$user_name   = $user_data ? $user_data->display_name : __( 'deleted student', 'easy-school-registration' );
			$user_phone  = get_user_meta( $user_data->ID, 'esr-course-registration-phone' );
			$paid_status = ESR()->payment_status->get_status( $user_payment );
			?>
			<tr class="esr-row esr-payment-row <?php echo 'paid-status-' . $paid_status; ?>"
				<?php if ( $user_can_edit ) { ?>
					data-id="<?php echo $user_payment['id']; ?>"
					data-email="<?php echo $user_email; ?>"
					data-to_pay="<?php echo $user_payment['to_pay']; ?>"
					data-payment="<?php echo $user_payment['payment']; ?>"
					data-wave_id="<?php echo $user_payment['wave_id'] ?>"
					data-note="<?php echo htmlspecialchars( $user_payment['note'] ) ?>"
				<?php } ?>
			>
				<td class="status"><?php echo ESR()->payment_status->get_title( $paid_status ); ?></td>
				<?php if ( $user_can_edit && $user_data ) { ?>
					<td class="actions esr-payment">
						<div class="esr-relative">
							<button class="page-title-action"><?php _e( 'Actions', 'easy-school-registration' ) ?></button>
							<?php self::print_action_box( $user_payment ); ?>
						</div>
					</td>
				<?php } ?>
				<td class="payment-type"><?php echo ESR()->payment_type->get_title( $user_payment['payment_type'] ); ?></td>
				<td class="esr-note"><?php if ( ( $user_payment['note'] !== null ) && ( $user_payment['note'] !== "" ) ) { ?>
						<span class="dashicons dashicons-admin-comments esr-show-note" title="<?php echo htmlspecialchars( $user_payment['note'] ); ?>"></span>
						<span class="dashicons dashicons-welcome-comments  esr-hide-note"></span>
						<span class="esr-note-message"><?php echo htmlspecialchars( $user_payment['note'] ); ?></span><?php } ?></td>
				<td class="student-surname"><?php echo $user_name; ?></td>
				<?php if ( $user_show_emails ) { ?>
					<td class="student-email"><?php echo $user_email; ?></td>
				<?php } ?>
				<?php if ( $show_phone ) { ?>
					<td class="student-phone"><?php echo ! empty( $user_phone ) ? $user_phone[0] : ''; ?></td>
				<?php } ?>
				<td class="variable-symbol"><?php echo $selected_wave . sprintf( "%04s", $user_payment['user_id'] ); ?></td>
				<?php if ( intval( ESR()->settings->esr_get_option( 'show_courses', - 1 ) ) === 1 ) { ?>
					<td>
						<?php
						$courses = ESR()->registration->get_confirmed_registrations_by_wave_and_user( $user_payment['wave_id'], $user_payment['user_id'] );

						$course_titles = [];
						foreach ( $courses as $course_key => $course ) {
							$course_titles[] = $course->course_id . ' - ' . $course->title;
						}
						if ( ! empty( $courses ) ) {
							echo implode( '<br>', $course_titles );
						}
						?>
					</td>
				<?php } ?>
				<td><?php echo ESR()->currency->prepare_price( $user_payment['to_pay'] ); ?></td>
				<td class="student-paid"><?php echo( ( $user_payment && isset( $user_payment['payment'] ) && ( ! in_array( $paid_status, [ ESR_Enum_Payment::NOT_PAYING, ESR_Enum_Payment::VOUCHER ] ) ) ) ? ESR()->currency->prepare_price( $user_payment['payment'] ) : '' ); ?></td>
				<?php
				$actions = apply_filters( 'esr_payment_table_other_columns_body_calls', [] );
				foreach ( $actions as $key => $action ) {
					do_action( $action['action'], $user_payment );
				}
				?>
				<?php } ?>
			</tbody>
		</table>
		<?php
	}


	private static function print_action_box( $user_payment ) {
		?>
		<ul class="esr-actions-box dropdown-menu" data-id="<?php echo $user_payment['id']; ?>">
			<li class="esr-action edit">
				<a href="javascript:;">
					<span class="dashicons dashicons-edit"></span>
					<span><?php _e( 'Edit', 'easy-school-registration' ); ?></span>
				</a>
			</li>
			<li class="esr-action confirm-payment">
				<a href="javascript:;">
					<span class="dashicons dashicons-yes"></span>
					<span><?php _e( 'Confirm Payment', 'easy-school-registration' ); ?></span>
				</a>
			</li>
			<?php if ( intval( ESR()->settings->esr_get_option( 'debts_enabled', - 1 ) ) === 1 ) { ?>
				<li class="esr-action forgive-payment">
					<a href="javascript:;">
						<span class="dashicons dashicons-thumbs-up"></span>
						<span><?php _e( 'Forgive Payment', 'easy-school-registration' ); ?></span>
					</a>
				</li>
			<?php } ?>
			<?php do_action( 'esr_payment_table_action_box_item', $user_payment ) ?>
		</ul>
		<?php
	}

}

add_action( 'esr_print_payment_table_tab', [ 'ESR_Tab_Template_Payment_Table', 'esr_print_table' ] );