<?php
/**
 * The DCC Applies helper checks if the current installation can use DCC or not.
 *
 * @package WooCommerce\PayPalCommerce\ApiClient\Helper
 */

declare(strict_types=1);

namespace WooCommerce\PayPalCommerce\ApiClient\Helper;

/**
 * Class DccApplies
 */
class DccApplies {

	/**
	 * The matrix which countries and currency combinations can be used for DCC.
	 *
	 * @var array
	 */
	private $allowed_country_currency_matrix = array(
		'AU' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
		'ES' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
		'FR' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
		'GB' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
		'IT' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
		'US' => array(
			'AUD',
			'CAD',
			'EUR',
			'GBP',
			'JPY',
			'USD',
		),
		'CA' => array(
			'AUD',
			'CAD',
			'CHF',
			'CZK',
			'DKK',
			'EUR',
			'GBP',
			'HKD',
			'HUF',
			'JPY',
			'NOK',
			'NZD',
			'PLN',
			'SEK',
			'SGD',
			'USD',
		),
	);

	/**
	 * Which countries support which credit cards. Empty credit card arrays mean no restriction on
	 * currency. Otherwise only the currencies in the array are supported.
	 *
	 * @var array
	 */
	private $country_card_matrix = array(
		'AU' => array(
			'mastercard' => array(),
			'visa'       => array(),
		),
		'ES' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'EUR' ),
		),
		'FR' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'EUR' ),
		),
		'GB' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'GBP', 'USD' ),
		),
		'IT' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'EUR' ),
		),
		'US' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'USD' ),
			'discover'   => array( 'USD' ),
		),
		'CA' => array(
			'mastercard' => array(),
			'visa'       => array(),
			'amex'       => array( 'CAD' ),
			'jcb'        => array( 'CAD' ),
		),
	);

	/**
	 * 3-letter currency code of the shop.
	 *
	 * @var string
	 */
	private $currency;

	/**
	 * 2-letter country code of the shop.
	 *
	 * @var string
	 */
	private $country;

	/**
	 * DccApplies constructor.
	 *
	 * @param string $currency 3-letter currency code of the shop.
	 * @param string $country 2-letter country code of the shop.
	 */
	public function __construct( string $currency, string $country ) {
		$this->currency = $currency;
		$this->country  = $country;
	}

	/**
	 * Returns whether DCC can be used in the current country and the current currency used.
	 *
	 * @return bool
	 */
	public function for_country_currency(): bool {
		if ( ! in_array( $this->country, array_keys( $this->allowed_country_currency_matrix ), true ) ) {
			return false;
		}
		$applies = in_array( $this->currency, $this->allowed_country_currency_matrix[ $this->country ], true );
		return $applies;
	}

	/**
	 * Returns credit cards, which can be used.
	 *
	 * @return array
	 */
	public function valid_cards() : array {
		$cards = array();
		if ( ! isset( $this->country_card_matrix[ $this->country ] ) ) {
			return $cards;
		}

		$supported_currencies = $this->country_card_matrix[ $this->country ];
		foreach ( $supported_currencies as $card => $currencies ) {
			if ( $this->can_process_card( $card ) ) {
				$cards[] = $card;
			}
		}
		if ( in_array( 'amex', $cards, true ) ) {
			$cards[] = 'american-express';
		}
		if ( in_array( 'mastercard', $cards, true ) ) {
			$cards[] = 'master-card';
		}
		return $cards;
	}

	/**
	 * Whether a card can be used or not.
	 *
	 * @param string $card The card.
	 *
	 * @return bool
	 */
	public function can_process_card( string $card ) : bool {
		if ( ! isset( $this->country_card_matrix[ $this->country ] ) ) {
			return false;
		}
		if ( ! isset( $this->country_card_matrix[ $this->country ][ $card ] ) ) {
			return false;
		}

		/**
		 * If the supported currencies array is empty, there are no
		 * restrictions, which currencies are supported by a card.
		 */
		$supported_currencies = $this->country_card_matrix[ $this->country ][ $card ];
		return empty( $supported_currencies ) || in_array( $this->currency, $supported_currencies, true );
	}
}
