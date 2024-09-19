<?php
/**
 * @package ContentRestriction
 * @since   1.2.0
 * @version 1.2.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class Subscriber extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $rule ) {
		$this->type         = 'who-can-see';
		$this->module       = 'woocommerce_subscriptions_subscriber';
		$this->rule         = $rule;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		$status = $this->options['status'] ?? ['wc-active'];

		$query_vars = [
			'type'        => 'shop_subscription',
			'customer_id' => $this->user_id,
			'limit'       => -1,
			'status'      => $status,
			'return'      => 'ids',
		];

		try {
			$query = new \Automattic\WooCommerce\Internal\DataStores\Orders\OrdersTableQuery( $query_vars );

			return $query->found_orders > 0;
		} catch ( \Throwable $th ) {
			return false;
		}
	}
}