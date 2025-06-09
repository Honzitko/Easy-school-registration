<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Enum_Day
{
	const
		MONDAY = 1, TUESDAY = 2, WEDNESDAY = 3, THURSDAY = 4, FRIDAY = 5, SATURDAY = 6, SUNDAY = 7;

	private $items = [];


	/**
	 * @codeCoverageIgnore
	 */
	public function __construct()
	{
		$this->items = [
			self::MONDAY => [
				'title' => __('Monday', 'easy-school-registration'),
				'short_title' => __('Mon', 'easy-school-registration'),
			],
			self::TUESDAY => [
				'title' => __('Tuesday', 'easy-school-registration'),
				'short_title' => __('Tue', 'easy-school-registration'),
			],
			self::WEDNESDAY => [
				'title' => __('Wednesday', 'easy-school-registration'),
				'short_title' => __('Wed', 'easy-school-registration'),
			],
			self::THURSDAY => [
				'title' => __('Thursday', 'easy-school-registration'),
				'short_title' => __('Thu', 'easy-school-registration'),
			],
			self::FRIDAY => [
				'title' => __('Friday', 'easy-school-registration'),
				'short_title' => __('Fri', 'easy-school-registration'),
			],
			self::SATURDAY => [
				'title' => __('Saturday', 'easy-school-registration'),
				'short_title' => __('Sat', 'easy-school-registration'),
			],
			self::SUNDAY => [
				'title' => __('Sunday', 'easy-school-registration'),
				'short_title' => __('Sun', 'easy-school-registration'),
			],
		];
	}


	public function get_items()
	{
		return $this->items;
	}


	public function get_item($key)
	{
		return isset($this->get_items()[$key]) ? $this->get_items()[$key] : NULL;
	}


	public function get_day_title($key, $use_short = false)
	{
		$item = $this->get_item($key);
		if ($item && isset($item['title'])) {
			return $use_short ? $item['short_title'] : $item['title'];
		}
		return '';
	}
}