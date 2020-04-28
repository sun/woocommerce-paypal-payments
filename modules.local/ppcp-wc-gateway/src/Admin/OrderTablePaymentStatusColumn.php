<?php

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\WcGateway\Admin;

use Inpsyde\PayPalCommerce\WcGateway\Gateway\WcGateway;
use Inpsyde\PayPalCommerce\WcGateway\Settings\Settings;

class OrderTablePaymentStatusColumn
{
    private const COLUMN_KEY = 'ppcp_payment_status';
    private const INTENT = 'authorize';
    private const AFTER_COLUMN_KEY = 'order_status';
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register(array $columns): array
    {
        if ($this->settings->get('intent') !== self::INTENT) {
            return $columns;
        }

        $statusColumnPosition = array_search(self::AFTER_COLUMN_KEY, array_keys($columns), true);
        $toInsertPosition = false === $statusColumnPosition ? count($columns) : $statusColumnPosition + 1;

        $columns = array_merge(
            array_slice($columns, 0, $toInsertPosition),
            [
                self::COLUMN_KEY => __('Payment Captured', 'woocommerce-paypal-gateway'),
            ],
            array_slice($columns, $toInsertPosition)
        );

        return $columns;
    }

    public function render(string $column, int $wcOrderId)
    {
        if ($this->settings->get('intent') !== self::INTENT) {
            return;
        }

        if (self::COLUMN_KEY !== $column) {
            return;
        }

        $wcOrder = wc_get_order($wcOrderId);

        if (! is_a($wcOrder, \WC_Order::class) || ! $this->renderForOrder($wcOrder)) {
            return;
        }

        if ($this->isCaptured($wcOrder)) {
            $this->renderCompletedStatus();
        } else {
            $this->renderIncompletedStatus();
        }
    }

    private function renderForOrder(\WC_Order $order): bool
    {
        return !empty($order->get_meta(WcGateway::CAPTURED_META_KEY));
    }

    private function isCaptured(\WC_Order $wcOrder): bool
    {
        $captured = $wcOrder->get_meta(WcGateway::CAPTURED_META_KEY);
        return wc_string_to_bool($captured);
    }

    private function renderCompletedStatus()
    {
        echo '<span class="dashicons dashicons-yes"></span>';
    }

    private function renderIncompletedStatus()
    {
        printf(
            '<mark class="onbackorder">%s</mark>',
            esc_html__('Not captured', 'woocommerce-paypal-gateway')
        );
    }
}