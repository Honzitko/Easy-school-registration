<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Settings_Helper_Templater {

	public static function esr_email_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} elseif ( ! empty( $args['allow_blank'] ) && empty( $esr_settings ) ) {
			$value = '';
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = 'name="esr_settings[' . esc_attr( $args['id'] ) . ']"';

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$html = '<input type="email" class="' . $class . ' ' . 'regular-text" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label class="esr-settings-description" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_text_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );
		$has_tags     = isset( $args['desc_tags'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} elseif ( ! empty( $args['allow_blank'] ) && empty( $esr_settings ) ) {
			$value = '';
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = 'name="esr_settings[' . esc_attr( $args['id'] ) . ']"';

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$html = '<input type="text" class="' . $class . ' ' . 'regular-text" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';

		if ( $has_tags ) {
			$html .= '<br/>';
		}

		$html .= '<label class="esr-settings-description' . ( $has_tags ? ' esr-has-tags' : '' ) . '" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		if ( $has_tags ) {
			$html .= '<br/>' . wp_kses_post( $args['desc_tags'] );
		}

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_number_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} elseif ( ! empty( $args['allow_blank'] ) && empty( $esr_settings ) ) {
			$value = '';
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = 'name="esr_settings[' . esc_attr( $args['id'] ) . ']"';

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$html = '<input type="number" min="' . $args['min'] . '" class="' . $class . ' ' . 'regular-text" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . intval( esc_attr( stripslashes( $value ) ) ) . '"/>';
		$html .= '<label class="esr-settings-description" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_color_picker_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = 'name="esr_settings[' . esc_attr( $args['id'] ) . ']"';

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$html = '<input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label class="esr-settings-description" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_style_course_box_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$values = $esr_settings;
		} else {
			$values = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = esc_attr( $args['id'] );
		$id   = self::esr_sanitize_key( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$value_opacity      = esc_attr( stripslashes( isset( $values['background_opacity'] ) ? $values['background_opacity'] : '' ) );
		$value_border_width = esc_attr( stripslashes( isset( $values['border_width'] ) ? $values['border_width'] : '' ) );

		$html = '<table>
					<tr>
						<th>' . __( 'Background Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Background Opacity', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Border Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Border Width', 'easy-school-registration' ) . '</th>
					</tr>
					<tr>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_background_color]" name="esr_settings[' . $name . '][background_color]" value="' . esc_attr( stripslashes( isset( $values['background_color'] ) ? $values['background_color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_opacity . '</span><input type="range" min="0" max="1" step="0.1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_background_opacity]" name="esr_settings[' . $name . '][background_opacity]" value="' . $value_opacity . '"/></td>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_border_color]" name="esr_settings[' . $name . '][border_color]" value="' . esc_attr( stripslashes( isset( $values['border_color'] ) ? $values['border_color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_border_width . '</span><input type="range" min="0" max="20" step="1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_border_width]" name=esr_settings[' . $name . '][border_width]" value="' . $value_border_width . '"/></td>
					</tr>
				</table>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_style_course_box_with_font_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$values = $esr_settings;
		} else {
			$values = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = esc_attr( $args['id'] );
		$id   = self::esr_sanitize_key( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$value_opacity      = esc_attr( stripslashes( isset( $values['background_opacity'] ) ? $values['background_opacity'] : '' ) );
		$value_border_width = esc_attr( stripslashes( isset( $values['border_width'] ) ? $values['border_width'] : '' ) );
		$value_font_size    = esc_attr( stripslashes( isset( $values['size'] ) ? $values['size'] : '' ) );

		$html = '<table>';
		if ( isset( $args['optional'] ) && $args['optional'] ) {
			$is_checked = isset( $values['enable_style'] ) && $values['enable_style'];
			$html       .= '<tr>
						<th colspan="4" class="esr-settings-enable-style"><label for="esr_settings[' . $name . '][enable_style]"><input type="checkbox" id="esr_settings[' . $id . '_enable_style]" name="esr_settings[' . $name . '][enable_style]"' . ( $is_checked ? ' checked' : '' ) . '/>' . __( 'enable style', 'easy-school-registration' ) . '</label></th>
					</tr>';
		}
		$html .= '<tr>
						<th>' . __( 'Background Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Background Opacity', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Border Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Border Width', 'easy-school-registration' ) . '</th>
					</tr>
					<tr>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_background_color]" name="esr_settings[' . $name . '][background_color]" value="' . esc_attr( stripslashes( isset( $values['background_color'] ) ? $values['background_color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_opacity . '</span><input type="range" min="0" max="1" step="0.1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_background_opacity]" name="esr_settings[' . $name . '][background_opacity]" value="' . $value_opacity . '"/></td>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_border_color]" name="esr_settings[' . $name . '][border_color]" value="' . esc_attr( stripslashes( isset( $values['border_color'] ) ? $values['border_color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_border_width . '</span><input type="range" min="0" max="20" step="1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_border_width]" name=esr_settings[' . $name . '][border_width]" value="' . $value_border_width . '"/></td>
					</tr>
					<tr>
						<th>' . __( 'Text Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Text Size', 'easy-school-registration' ) . '</th>
					</tr>
					<tr>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_color]" name="esr_settings[' . $name . '][color]" value="' . esc_attr( stripslashes( isset( $values['color'] ) ? $values['color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_font_size . '</span><input type="range" min="1" max="40" step="1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_size]" name="esr_settings[' . $name . '][size]" value="' . $value_font_size . '"/></td>
					</tr>
				</table>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_style_course_font_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$values = $esr_settings;
		} else {
			$values = isset( $args['std'] ) ? $args['std'] : '';
		}

		$name = esc_attr( $args['id'] );
		$id   = self::esr_sanitize_key( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$value_font_size = esc_attr( stripslashes( isset( $values['size'] ) ? $values['size'] : '' ) );

		$html = '<table>
					<tr>
						<th>' . __( 'Text Color', 'easy-school-registration' ) . '</th>
						<th>' . __( 'Text Size', 'easy-school-registration' ) . '</th>
					</tr>
					<tr>
						<td><input type="text" class="' . $class . ' esr-color-picker" id="esr_settings[' . $id . '_color]" name="esr_settings[' . $name . '][color]" value="' . esc_attr( stripslashes( isset( $values['color'] ) ? $values['color'] : '' ) ) . '"/></td>
						<td><span class="esr-range-value">' . $value_font_size . '</span><input type="range" min="1" max="40" step="1" class="' . $class . ' esr-range" id="esr_settings[' . $id . '_size]" name="esr_settings[' . $name . '][size]" value="' . $value_font_size . '"/></td>
					</tr>
				</table>';

		//$html .= '';
		//$html .= '<label for="esr_settings[' . $id . ']"> ' . wp_kses_post($args['desc']) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_full_editor_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );
		$has_tags     = isset( $args['desc_tags'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} else {
			if ( ! empty( $args['allow_blank'] ) && empty( $esr_settings ) ) {
				$value = '';
			} else {
				$value = isset( $args['std'] ) ? $args['std'] : '';
			}
		}

		$rows = isset( $args['size'] ) ? $args['size'] : 20;

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		ob_start();
		wp_editor( stripslashes( $value ), 'esr_settings_' . esc_attr( $args['id'] ), [ 'textarea_name' => 'esr_settings[' . esc_attr( $args['id'] ) . ']', 'textarea_rows' => absint( $rows ), 'editor_class' => $class ] );
		$html = ob_get_clean();

		if ( $has_tags ) {
			$html .= '<br/>';
		}

		$html .= '<label class="esr-settings-description' . ( $has_tags ? ' esr-has-tags' : '' ) . '" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		if ( $has_tags ) {
			$html .= '<br/>' . wp_kses_post( $args['desc_tags'] );
		}

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_checkbox_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		$name = 'name="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"';

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		$checked = ! empty( $esr_settings ) ? checked( 1, $esr_settings, false ) : ( isset( $args['std'] ) && $args['std'] ? 'checked' : '' );
		$html    = '<input type="hidden"' . $name . ' value="-1" />';
		$html    .= '<input type="checkbox" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"' . $name . ' value="1" ' . $checked . ' class="' . $class . '"/>';
		$html    .= '<label class="esr-settings-description checkbox-label" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_select_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} else {

			// Properly set default fallback if the Select Field allows Multiple values
			if ( empty( $args['multiple'] ) ) {
				$value = isset( $args['std'] ) ? $args['std'] : '';
			} else {
				$value = ! empty( $args['std'] ) ? $args['std'] : [];
			}

		}

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		// If the Select Field allows Multiple values, save as an Array
		$name_attr = 'esr_settings[' . esc_attr( $args['id'] ) . ']';

		$html = '<select id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" name="' . $name_attr . '" class="' . $class . '">';

		foreach ( $args['options'] as $option => $name ) {
			$html .= '<option value="' . esc_attr( $option ) . '" ' . selected( $option, $value, false ) . '>' . esc_html( $name ) . '</option>';
		}

		$html .= '</select>';
		$html .= '<label class="esr-settings-description" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_add_list_callback( $args ) {
		$items = ESR()->settings->esr_get_option( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		ob_start(); ?>
		<div class="esr_list_items">
			<table class="wp-list-table fixed posts <?php echo $class; ?>">
				<thead>
				<tr>
					<th scope="col"><?php _e( 'ID', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Name', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Remove', 'easy-school-registration' ); ?></th>
				</tr>
				</thead>
				<?php if ( ! empty( $items ) ) : ?>
					<?php foreach ( $items as $key => $item ) : ?>
						<tr data-key="<?php echo self::esr_sanitize_key( $key ) ?>">
							<td class="esr_list_item esr-key-container">
								<?php echo $key; ?>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>]"
								       value="<?php echo esc_html( $item ); ?>"/>
							</td>
							<td>
								<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr data-key="0">
						<td class="esr_list_item esr-key-container">0</td>
						<td class="esr_list_item">
							<input type="text" name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][]"
							       value=""/>
						</td>
						<td>
							<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
						</td>
					</tr>
				<?php endif; ?>
			</table>
			<span class="button-secondary esr-add-list-item"><?php echo __( 'Add', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
		</div>
		<?php
		echo ob_get_clean();
	}


	public static function esr_add_payment_types_list_callback( $args ) {
		$items = ESR()->settings->esr_get_option( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		ob_start(); ?>
		<div class="esr_list_items">
			<table class="wp-list-table fixed posts <?php echo $class; ?>">
				<thead>
				<tr>
					<th scope="col"><?php _e( 'ID', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Name', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Remove', 'easy-school-registration' ); ?></th>
				</tr>
				</thead>
				<?php if ( ! empty( $items ) ) : ?>
					<?php foreach ( $items as $key => $item ) : ?>
						<tr data-key="<?php echo self::esr_sanitize_key( $key ) ?>">
							<td class="esr_list_item esr-key-container">
								<?php echo $key; ?>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>]"
								       value="<?php echo esc_html( $item ); ?>"/>
							</td>
							<td>
								<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr data-key="2">
						<td class="esr_list_item esr-key-container">2</td>
						<td class="esr_list_item">
							<input type="text" name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][2]"
							       value=""/>
						</td>
						<td>
							<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
						</td>
					</tr>
				<?php endif; ?>
			</table>
			<span class="button-secondary esr-add-list-item"><?php echo __( 'Add', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
		</div>
		<?php
		echo ob_get_clean();
	}


	public static function esr_add_list_times_callback( $args ) {
		$items = ESR()->settings->esr_get_option( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		ob_start(); ?>
		<div class="esr_list_items">
			<table class="wp-list-table fixed posts <?php echo $class; ?>">
				<thead>
				<tr>
					<th scope="col"><?php _e( 'ID', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Time From', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Time To', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Remove', 'easy-school-registration' ); ?></th>
				</tr>
				</thead>
				<?php if ( ! empty( $items ) ) : ?>
					<?php foreach ( $items as $key => $item ) : ?>
						<tr data-key="<?php echo self::esr_sanitize_key( $key ) ?>">
							<td class="esr_list_item esr-key-container">
								<?php echo $key; ?>
							</td>
							<td class="esr_list_item">
								<input type="time"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][from]"
								       value="<?php echo esc_html( $item['from'] ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="time"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][to]"
								       value="<?php echo esc_html( $item['to'] ); ?>"/>
							</td>
							<td>
								<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr data-key="0">
						<td class="esr_list_item esr-key-container">0</td>
						<td class="esr_list_item">
							<input type="time"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][from]"
							/>
						</td>
						<td class="esr_list_item">
							<input type="time"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][to]"
							/>
						</td>
						<td>
							<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
						</td>
					</tr>
				<?php endif; ?>
			</table>
			<span class="button-secondary esr-add-list-item"><?php echo __( 'Add', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
		</div>
		<?php
		echo ob_get_clean();
	}


	public static function esr_add_list_halls_callback( $args ) {
		$items = ESR()->settings->esr_get_option( $args['id'] );

		$class = self::esr_sanitize_html_class( $args['field_class'] );

		ob_start(); ?>
		<div class="esr_list_items">
			<table class="wp-list-table fixed posts <?php echo $class; ?>">
				<thead>
				<tr>
					<th scope="col"><?php _e( 'ID', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Name', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Address', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Latitude', 'easy-school-registration' ); ?></th>
					<th scope="col" class="esr_tax_country"><?php _e( 'Longitude', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Default Couples', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Default Solo', 'easy-school-registration' ); ?></th>
					<th scope="col"><?php _e( 'Remove', 'easy-school-registration' ); ?></th>
				</tr>
				</thead>
				<?php if ( ! empty( $items ) ) { ?>
					<?php foreach ( $items as $key => $item ) {
						$new_item = $item;
						if ( ! is_array( $item ) ) {
							$new_item              = [];
							$new_item['name']      = $item;
							$new_item['address']   = '';
							$new_item['latitude']  = '';
							$new_item['longitude'] = '';
						}
						?>
						<tr data-key="<?php echo self::esr_sanitize_key( $key ) ?>">
							<td class="esr_list_item esr-key-container">
								<?php echo $key; ?>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][name]"
								       value="<?php echo esc_html( $new_item['name'] ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][address]"
								       value="<?php echo esc_html( isset( $new_item['address'] ) ? $new_item['address'] : '' ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][latitude]"
								       value="<?php echo esc_html( isset( $new_item['latitude'] ) ? $new_item['latitude'] : '' ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="text"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][longitude]"
								       value="<?php echo esc_html( isset( $new_item['longitude'] ) ? $new_item['longitude'] : '' ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="number"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][couples]"
								       value="<?php echo esc_html( isset( $new_item['couples'] ) ? $new_item['couples'] : 0 ); ?>"/>
							</td>
							<td class="esr_list_item">
								<input type="number"
								       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][<?php echo self::esr_sanitize_key( $key ) ?>][solo]"
								       value="<?php echo esc_html( isset( $new_item['solo'] ) ? $new_item['solo'] : 0 ); ?>"/>
							</td>
							<td>
								<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
							</td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr data-key="0">
						<td class="esr_list_item esr-key-container">0</td>
						<td class="esr_list_item">
							<input type="text"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][name]"
							       value=""/>
						</td>
						<td class="esr_list_item">
							<input type="text"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][address]"
							       value=""/>
						</td>
						<td class="esr_list_item">
							<input type="text"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][latitude]"
							       value=""/>
						</td>
						<td class="esr_list_item">
							<input type="text"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][longitude]"
							       value=""/>
						</td>
						<td class="esr_list_item">
							<input type="number"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][couples]"
							       value=""/>
						</td>
						<td class="esr_list_item">
							<input type="number"
							       name="esr_settings[<?php echo self::esr_sanitize_key( $args['id'] ); ?>][0][solo]"
							       value=""/>
						</td>
						<td>
							<span class="esr_remove_list_item button-secondary"><?php echo __( 'Remove', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
						</td>
					</tr>
				<?php } ?>
			</table>
			<span class="button-secondary esr-add-list-item"><?php echo __( 'Add', 'easy-school-registration' ) . ' ' . $args['singular']; ?></span>
		</div>
		<?php
		echo ob_get_clean();
	}


	public static function esr_license_key_callback( $args ) {
		$esr_settings = ESR()->settings->esr_get_option( $args['id'] );

		$messages = [];
		$license  = get_option( $args['options']['is_valid_license_option'] );

		if ( $esr_settings ) {
			$value = $esr_settings;
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if ( ! empty( $license ) && is_object( $license ) ) {

			// activate_license 'invalid' on anything other than valid, so if there was an error capture it
			if ( false === $license->success ) {

				switch ( $license->error ) {

					case 'expired' :

						$class      = 'expired';
						$messages[] = sprintf( __( 'Your license key expired on %s. Please <a href="%s" target="_blank">contact us</a> about renew your license key.', 'easy-school-registration' ), date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ), 'https://easyschoolregistration.com/contact/' );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'revoked' :

						$class      = 'error';
						$messages[] = sprintf( __( 'Your license key has been disabled. Please <a href="%s" target="_blank">contact support</a> for more information.', 'easy-school-registration' ), 'https://easyschoolregistration.com/contact/' );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'missing' :

						$class      = 'error';
						$messages[] = sprintf( __( 'Invalid license. Please <a href="%s" target="_blank">visit your account page</a> and verify it.', 'easy-school-registration' ), 'https://easyschoolregistration.com/your-account' );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'invalid' :
					case 'site_inactive' :

						$class      = 'error';
						$messages[] = sprintf( __( 'Your %s is not active for this URL. Please <a href="%s" target="_blank">visit your account page</a> to manage your license key URLs.', 'easy-school-registration' ), $args['name'], 'https://easyschoolregistration.com/your-account/' );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'item_name_mismatch' :

						$class      = 'error';
						$messages[] = sprintf( __( 'This appears to be an invalid license key for %s.', 'easy-school-registration' ), $args['name'] );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'no_activations_left':

						$class      = 'error';
						$messages[] = sprintf( __( 'Your license key has reached its activation limit. <a href="%s">View possible upgrades</a> now.', 'easy-school-registration' ), 'https://easyschoolregistration.com/your-account/' );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'license_not_activable':

						$class      = 'error';
						$messages[] = __( 'The key you entered belongs to a bundle, please use the product specific license key.', 'easy-school-registration' );

						$license_status = 'license-' . $class . '-notice';
						break;

					default :

						$class      = 'error';
						$error      = ! empty( $license->error ) ? $license->error : __( 'unknown_error', 'easy-school-registration' );
						$messages[] = sprintf( __( 'There was an error with this license key: %s. Please <a href="%s">contact our support team</a>.', 'easy-school-registration' ), $error, 'https://easyschoolregistration.com/contact/' );

						$license_status = 'license-' . $class . '-notice';
						break;
				}

			} else {

				switch ( $license->license ) {

					case 'valid' :
					default:

						$class = 'valid';

						$now        = current_time( 'timestamp' );
						$expiration = strtotime( $license->expires, current_time( 'timestamp' ) );

						if ( 'lifetime' === $license->expires ) {

							$messages[] = __( 'License key never expires.', 'easy-school-registration' );

							$license_status = 'license-lifetime-notice';

						} elseif ( $expiration > $now && $expiration - $now < ( DAY_IN_SECONDS * 30 ) ) {

							$messages[] = sprintf( __( 'Your license key expires soon! It expires on %s. Please <a href="%s" target="_blank">contact us</a> about renew your license key.', 'easy-school-registration' ), date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ), 'https://easyschoolregistration.com/contact/' );

							$license_status = 'license-expires-soon-notice';

						} else {

							$messages[] = sprintf( __( 'Your license key expires on %s.', 'easy-school-registration' ), date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ) );

							$license_status = 'license-expiration-date-notice';

						}

						break;

				}

			}

		} else {
			$class = 'empty';

			$messages[] = sprintf( __( 'To receive updates, please enter your valid %s license key.', 'easy-school-registration' ), $args['name'] );

			$license_status = null;
		}

		$class .= ' ' . self::esr_sanitize_html_class( $args['field_class'] );

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . sanitize_html_class( $size ) . '-text" id="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" name="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']" value="' . esc_attr( $value ) . '"/>';

		if ( ( is_object( $license ) && 'valid' == $license->license ) || 'valid' == $license ) {
			$html .= '<input type="submit" class="esr-deactivate-license button-secondary" name="' . $args['id'] . '_deactivate" value="' . __( 'Deactivate License', 'easy-school-registration' ) . '"/>';
		}

		$html .= '<label class="esr-settings-description" for="esr_settings[' . self::esr_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

		if ( ! empty( $messages ) ) {
			foreach ( $messages as $message ) {

				$html .= '<div class="esr-license-data esr-license-' . $class . ' ' . $license_status . '">';
				$html .= '<p>' . $message . '</p>';
				$html .= '</div>';

			}
		}

		wp_nonce_field( self::esr_sanitize_key( $args['id'] ) . '-nonce', self::esr_sanitize_key( $args['id'] ) . '-nonce' );

		echo $html;
	}


	public static function esr_submit_callback( $args ) {
		$html        = '';
		$status      = get_option( 'esr_license_status' );
		$license_key = ESR()->settings->esr_get_option( 'license_key' );

		if ( $license_key ) {
			if ( $status !== false && $status == 'valid' ) {
				$license = get_option( 'esr_license_data' );

				if ( $license ) {
					$html .= sprintf( __( 'Your license key expires on %s.', 'easy-digital-downloads' ), date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ) );
				} else {
					$html .= __( 'Your license is activated.', 'easy-school-registration' );
				}

				$html .= '<label for="' . self::esr_sanitize_key( $args['id'] . '_deactivate' ) . '" style="margin-left:10px"><input type="submit" class="button-secondary" name="' . self::esr_sanitize_key( $args['id'] . '_deactivate' ) . '" value="' . $args['name_deactivate'] . '"/></label>';
			} else {
				$html = wp_nonce_field( 'esr_nonce', 'esr_nonce' );
				$html .= '<label for="' . self::esr_sanitize_key( $args['id'] ) . '"><input type="submit" class="button-secondary" name="' . self::esr_sanitize_key( $args['id'] ) . '" value="' . $args['name'] . '"/></label>';
			}
		} else {
			$html = __( 'Please save the license key before activation.', 'easy-school-registration' );
		}

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_description_callback( $args ) {

		$html = '<span> ' . wp_kses_post( $args['desc'] ) . '</span>';

		echo apply_filters( 'esr_after_setting_output', $html, $args );
	}


	public static function esr_sanitize_html_class( $class = '' ) {

		if ( is_string( $class ) ) {
			$class = sanitize_html_class( $class );
		} else if ( is_array( $class ) ) {
			$class = array_values( array_map( 'sanitize_html_class', $class ) );
			$class = implode( ' ', array_unique( $class ) );
		}

		return $class;

	}


	public static function esr_sanitize_key( $key ) {
		$raw_key = $key;
		$key     = preg_replace( '/[^a-zA-Z0-9_\-\.\:\/]/', '', $key );

		return apply_filters( 'esr_sanitize_key', $key, $raw_key );
	}

}
