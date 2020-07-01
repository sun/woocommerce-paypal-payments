<?php

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\WcGateway\Settings;

use Inpsyde\PayPalCommerce\Onboarding\Environment;

trait SettingsTrait
{
    /**
     * @var Environment
     */
    private $environment;

    private function defaultFields(): array
    {
        $isSandbox = ($this->environment) ? $this->environment->currentEnvironmentIs(Environment::SANDBOX) : false;
        $sandbox = [
            'type' => 'ppcp_info',
            'title' => __('Sandbox'),
            'text' => ($isSandbox) ? __('You are currently in the sandbox mode. Click Reset if you want to change your mode.', 'woocommerce-paypal-commerce-gateway') : __('You are in production mode. Click Reset if you want to change your mode.', 'woocommerce-paypal-commerce-gateway'),
        ];
        return array_merge(
            [
                'enabled' => [
                    'title' => __('Enable/Disable', 'woocommerce-paypal-gateway'),
                    'type' => 'checkbox',
                    'label' => __('Enable PayPal Payments', 'woocommerce-paypal-gateway'),
                    'default' => 'yes',
                ],
                'title' => [
                    'title' => __('Title', 'woocommerce-paypal-gateway'),
                    'type' => 'text',
                    'description' => __(
                        'This controls the title which the user sees during checkout.',
                        'woocommerce-paypal-gateway'
                    ),
                    'default' => __('PayPal', 'woocommerce-paypal-gateway'),
                    'desc_tip' => true,
                ],
                'description' => [
                    'title' => __('Description', 'woocommerce-paypal-gateway'),
                    'type' => 'text',
                    'desc_tip' => true,
                    'description' => __(
                        'This controls the description which the user sees during checkout.',
                        'woocommerce-paypal-gateway'
                    ),
                    'default' => __(
                        'Pay via PayPal; you can pay with your credit card if you don\'t have a PayPal account.',
                        'woocommerce-paypal-gateway'
                    ),
                ],

                'account_settings' => [
                    'title' => __('Account Settings', 'woocommerce-paypal-gateway'),
                    'type' => 'title',
                    'description' => '',
                ],
                'sandbox_on' => $sandbox,
                'reset' => [
                    'type' => 'ppcp_reset',
                ],
            ],
            $this->buttons()
        );
    }


    private function buttons(): array
    {
        return [
            'button_settings' => [
                'title' => __('SmartButton Settings', 'woocommerce-paypal-gateway'),
                'type' => 'title',
                'description' => __(
                    'Customize the appearance of PayPal Payments on your site.',
                    'woocommerce-paypal-gateway'
                ),
            ],
            'button_single_product_enabled' => [
                'title' => __('Buttons on Single Product', 'woocommerce-paypal-gateway'),
                'type' => 'checkbox',
                'label' => __('Enable on Single Product', 'woocommerce-paypal-gateway'),
                'default' => 'yes',
            ],
            'button_mini_cart_enabled' => [
                'title' => __('Buttons on Mini Cart', 'woocommerce-paypal-gateway'),
                'type' => 'checkbox',
                'label' => __('Enable on Mini Cart', 'woocommerce-paypal-gateway'),
                'default' => 'yes',
            ],
            'button_cart_enabled' => [
                'title' => __('Buttons on Cart', 'woocommerce-paypal-gateway'),
                'type' => 'checkbox',
                'label' => __('Enable on Cart', 'woocommerce-paypal-gateway'),
                'default' => 'yes',
            ],
            'button_color' => [
                'title' => __('Color', 'woocommerce-paypal-gateway'),
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'default' => 'gold',
                'desc_tip' => true,
                'description' => __(
                    'Controls the background color of the primary button. Use "Gold" to leverage PayPal\'s recognition and preference, or change it to match your site design or aesthetic.',
                    'woocommerce-paypal-gateway'
                ),
                'options' => [
                    'gold' => __('Gold (Recommended)', 'woocommerce-paypal-gateway'),
                    'blue' => __('Blue', 'woocommerce-paypal-gateway'),
                    'silver' => __('Silver', 'woocommerce-paypal-gateway'),
                    'black' => __('Black', 'woocommerce-paypal-gateway'),
                ],
            ],
            'button_shape' => [
                'title' => __('Shape', 'woocommerce-paypal-gateway'),
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'default' => 'rect',
                'desc_tip' => true,
                'description' => __(
                    'The pill-shaped button\'s unique and powerful shape signifies PayPal in people\'s minds. Use the rectangular button as an alternative when pill-shaped buttons might pose design challenges.',
                    'woocommerce-paypal-gateway'
                ),
                'options' => [
                    'pill' => __('Pill', 'woocommerce-paypal-gateway'),
                    'rect' => __('Rectangle', 'woocommerce-paypal-gateway'),
                ],
            ],
            'disable_funding' => [
                'title' => __('Disable funding sources', 'woocommerce-paypal-gateway'),
                'type' => 'multiselect',
                'class' => 'wc-enhanced-select',
                'default' => [],
                'desc_tip' => true,
                'description' => __(
                    'By default all possible funding sources will be shown. You can disable some sources, if you wish.',
                    'woocommerce-paypal-gateway'
                ),
                'options' => [
                    'card' => _x('Credit or debit cards', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'credit' => _x('PayPal Credit', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'venmo' => _x('Venmo', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'sepa' => _x('SEPA-Lastschrift', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'bancontact' => _x('Bancontact', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'eps' => _x('eps', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'giropay' => _x('giropay', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'ideal' => _x('iDEAL', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'mybank' => _x('MyBank', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'p24' => _x('Przelewy24', 'Name of payment method', 'woocommerce-paypal-gateway'),
                    'sofort' => _x('Sofort', 'Name of payment method', 'woocommerce-paypal-gateway'),
                ],
            ],
        ];
    }
}