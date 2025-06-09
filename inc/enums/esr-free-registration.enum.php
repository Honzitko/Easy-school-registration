<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Enum_Free_Registration extends ESR_Enum {
	const
		PAID = 0, FREE = 1;

	/**
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		$this->esr_set_items($this->esr_set_up_items());
	}


	private function esr_set_up_items() {
		return apply_filters('esr_set_up_free_registration_items', [
			self::PAID => [
				'title' => __('Paid Registration', 'easy-school-registration'),
				'change_message' => __('Registration set to paid', 'easy-school-registration'),
			],
			self::FREE => [
				'title' => __('Free Registration', 'easy-school-registration'),
				'change_message' => __('Registration set to free', 'easy-school-registration'),
			]
		]);
	}

	public function esr_get_change_message($key) {
		$item = $this->get_item($key);

		if ($item) {
			return $item['change_message'];
		} else {
			return '';
		}
	}

}