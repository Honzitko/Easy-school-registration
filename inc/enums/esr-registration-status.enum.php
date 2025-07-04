<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Registration_Status {
	const
		WAITING = 1, CONFIRMED = 2, DELETED = 3;

	private $items = [];


	/**
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		$this->items = [
			self::WAITING   => [
				'title' => __('Waiting', 'easy-school-registration'),
			],
			self::CONFIRMED => [
				'title' => __('Confirmed', 'easy-school-registration'),
			],
			self::DELETED => [
				'title' => __('Canceled', 'easy-school-registration')
			]
		];
	}


	public function get_items() {
		return $this->items;
	}


	public function get_item($key) {
		return $this->get_items()[$key];
	}


	public function get_title($key) {
		return $this->get_item($key)['title'];
	}


	public function is_waiting($key) {
		return intval($key) === self::WAITING;
	}

}