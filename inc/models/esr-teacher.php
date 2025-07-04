<?php
declare(strict_types=1);

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}


class ESR_Teacher {

	/**
	 * @codeCoverageIgnore
	 */
       public function esr_get_teacher_settings_preferences(): array {
		return [
			'limit_registrations' => [
				'type' => 'checkbox'
			]
		];
	}


	/**
	 * @return array|null|object
	 */
       public function get_teachers_data(): array {
		global $wpdb;

               $results = $wpdb->get_results(
                       $wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_teacher_data ORDER BY id", [])
               );

		$teachers = [];
		if ($results) {
			foreach ($results as $key => $result) {
				$teachers[$key] = $this->esr_prepare_teacher_settings($result);
			}
		}

		return $teachers;
	}


	/**
	 * @param int $id teacher id
	 *
	 * @return object
	 */
       public function get_teacher_data(int $id) {
		global $wpdb;
		$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_teacher_data WHERE id = %d", [$id]));

		if ($result) {
			return $this->esr_prepare_teacher_settings($result);
		}

		return $result;
	}


       public function get_teacher_data_by_user(int $user_id) {
		global $wpdb;
		$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}esr_teacher_data WHERE user_id = %d", [$user_id]));

		if ($result) {
			return $this->esr_prepare_teacher_settings($result);
		}

		return $result;
	}


       public function get_teacher_name(int $id): string {
		$teacher = $this->get_teacher_data($id);

		if ($teacher) {
			if ($teacher->nickname !== null) {
				return $teacher->nickname;
			} else {
				return $teacher->name;
			}
		}

		return '';
	}


	/**
	 * @param int $teacher_first
	 * @param int|null $teacher_second
	 *
	 * @return string
	 */
       public function get_teachers_names(int $teacher_first, ?int $teacher_second): string {
		return ($teacher_first ? $this->get_teacher_name($teacher_first) : '') . ($teacher_second ? ($teacher_first && $teacher_second ? ' & ' : '') . $this->get_teacher_name($teacher_second) : '');
	}


       private function esr_prepare_teacher_settings($result): object {
		if (isset($result->teacher_settings)) {
			$settings = $result->teacher_settings;
			unset($result->teacher_settings);

			return (object) array_merge((array) $result, (array) json_decode($settings, true));
		} else { //Historical check for not updated tables
			return $result;
		}
	}


       public function esr_is_user_teacher(int $user_id): bool {
		global $wpdb;
		return intval($wpdb->get_var($wpdb->prepare("SELECT EXISTS (SELECT 1 FROM {$wpdb->prefix}esr_teacher_data WHERE user_id = %d)", [$user_id]))) === 1;
	}
}