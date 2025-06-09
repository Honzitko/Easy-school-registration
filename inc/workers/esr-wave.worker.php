<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Wave_Worker {

	public function __construct() {
		add_action( 'esr_wave_add', [ get_called_class(), 'add_wave_action' ] );
		add_action( 'esr_wave_update', [ get_called_class(), 'update_wave_action' ], 10, 2 );
	}


	public function process_wave( $data ) {
		if ( current_user_can( 'esr_wave_edit' ) ) {
			if ( isset( $data['wave_id'] ) && ( $data['wave_id'] !== '' ) ) {
				$prepared_data = $this->prepare_data( $data );
				do_action( 'esr_wave_update', (int) $data['wave_id'], $prepared_data );
			} else {
				do_action( 'esr_wave_add', $this->prepare_data( $data ) );
			}
		}
	}


	public static function add_wave_action( $data ) {
		global $wpdb;

		if ( current_user_can( 'esr_wave_edit' ) ) {
			$result = $wpdb->insert( $wpdb->prefix . 'esr_wave_data', $data );

			if ( $result !== false ) {
				do_action( 'esr_module_wave_add', $wpdb->insert_id, $data );
			}
		}
	}


	public static function update_wave_action( $wave_id, $data ) {
		if ( current_user_can( 'esr_wave_edit' ) ) {

			global $wpdb;
			$wpdb->update( $wpdb->prefix . 'esr_wave_data', $data, [
				'id' => $wave_id
			] );

			do_action( 'esr_module_wave_update', $wave_id, $data );
		}
	}


	private function prepare_data( $data ) {
		$return_data = [];

		$return_data['title']             = sanitize_text_field( $data['title'] );
		$return_data['registration_from'] = $data['registration_from'] . ' ' . $data['registration_from_time'];
		$return_data['registration_to']   = $data['registration_to'] . ' ' . $data['registration_to_time'];


		$wave_settings = [];
		if ( isset( $data['wave_settings'] ) ) {
			foreach ( ESR()->wave->esr_get_wave_settings_preferences() as $key => $setting ) {
				if ( $setting['type'] === 'checkbox' ) {
					$wave_settings[ $key ] = isset( $data['wave_settings'][ $key ] );
				} else if ( isset( $data['wave_settings'][ $key ] ) ) {
					$wave_settings[ $key ] = sanitize_text_field( $data['wave_settings'][ $key ] );
				} else {
					$wave_settings[ $key ] = '';
				}
			}
		}

		$return_data['wave_settings'] = json_encode( $wave_settings );

		return $return_data;
	}


	public static function esr_remove_wave_callback( $wave_id ) {
		if ( ! empty( $wave_id ) && current_user_can( 'esr_wave_edit' ) && ESR()->wave->esr_can_be_removed( $wave_id ) ) {
			global $wpdb;
			$result = $wpdb->delete( $wpdb->prefix . 'esr_wave_data', [ 'id' => intval( $wave_id ) ] );

			if ( $result ) {
				apply_filters( 'esr_after_wave_removed', $wave_id );
			}

			return $result;
		}

		return false;
	}

}

add_filter( 'esr_remove_wave', [ 'ESR_Wave_Worker', 'esr_remove_wave_callback' ] );