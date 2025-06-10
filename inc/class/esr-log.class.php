<?php
declare(strict_types=1);

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Log {

       public function esr_get_all_logs(): array {
               global $wpdb;

               return (array) $wpdb->get_results(
                       $wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_log", [])
               );
       }

       public function esr_get_logs_by_subtype(string $subtype): array {
               global $wpdb;

               return (array) $wpdb->get_results(
                       $wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_log WHERE subtype = %s", $subtype)
               );
       }

       public static function esr_log_message(string $system, string $subtype, string $status, string $message): void {
               global $wpdb;

		if (intval(ESR()->settings->esr_get_option('log_enabled', -1)) !== -1) {
			$wpdb->insert($wpdb->prefix . 'esr_log', [
				'system'  => $system,
				'subtype' => $subtype,
				'status'  => $status,
				'user_id' => get_current_user_id(),
				'message' => $message,
			]);
		}
	}


       public static function esr_log_esr_message(string $subtype, string $status, string $message): void {
               do_action('esr_log_message', 'easy_school_registration', $subtype, $status, $message);
       }

}

add_action('esr_log_message', ['ESR_Log', 'esr_log_message'], 10, 4);
add_action('esr_log_esr_message', ['ESR_Log', 'esr_log_esr_message'], 10, 3);
