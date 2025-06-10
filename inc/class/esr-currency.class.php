<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ESR_Currency {

	/**
	 * @codeCoverageIgnore
	 */
	public function esr_get_currencies() {
		$currencies = [
			'USD' => __('US Dollars (&#36;)', 'easy-school-registration'),
			'EUR' => __('Euros (&euro;)', 'easy-school-registration'),
			'GBP' => __('Pound Sterling (&pound;)', 'easy-school-registration'),
			'CZK' => __('Czech Crown (Kč)', 'easy-school-registration'),
			'DKK' => __('Danish Krone (kr)', 'easy-school-registration'),
			'HUF' => __('Hungarian Forint (Ft)', 'easy-school-registration'),
			'PLN' => __('Polish Zloty (Z&#x142;)', 'easy-school-registration'),
		];

		return apply_filters('esr_currencies', $currencies);
	}


	public function esr_get_currency() {
		$currency = ESR()->settings->esr_get_option('currency', 'USD');

		return apply_filters('esr_currency', $currency);
	}


	public function esr_get_currency_position() {
		$currency_position = ESR()->settings->esr_get_option('currency_position', 'after_with_space');

		return apply_filters('esr_currency_position', $currency_position);
	}


	public function esr_currency_symbol($currency = '') {
		if (empty($currency)) {
			$currency = $this->esr_get_currency();
		}

		switch ($currency) :
			case "CZK" :
				$symbol = 'Kč';
				break;
			case "GBP" :
				$symbol = '&pound;';
				break;
			case "EUR" :
				$symbol = '&euro;';
				break;
			case "USD" :
				$symbol = '&#36;';
				break;
			case "HUF" :
				$symbol = 'Ft';
				break;
			case "PLN" :
				$symbol = 'Z&#x142;';
				break;
			case "DKK" :
				$symbol = 'kr';
				break;
			default :
				$symbol = $currency;
				break;
		endswitch;

		return apply_filters('esr_currency_symbol', $symbol, $currency);
	}


	public function prepare_price($price) {
		$currency_position = $this->esr_get_currency_position();

		switch ($currency_position) {
			case 'before':
				{
					$price_with_currency = $this->esr_currency_symbol() . $price;
					break;
				}
			case 'before_with_space':
				{
					$price_with_currency = $this->esr_currency_symbol() . ' ' . $price;
					break;
				}
			case 'after':
				{
					$price_with_currency = $price . $this->esr_currency_symbol();
					break;
				}
			default :
				{
					$price_with_currency = $price . ' ' . $this->esr_currency_symbol();
				}
		}

		return apply_filters('esr_prepare_price', $price_with_currency);
	}

}