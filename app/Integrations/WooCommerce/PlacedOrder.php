<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class PlacedOrder extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $r ) {
		$this->type         = 'who-can-see';
		$this->module       = 'woocommerce_placed_order';
		$this->r            = $r;
		$this->options      = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
	}

	public function give_access(): bool {
		if ( empty( $this->options['status'] ) ) {
			return false;
		}

		$orders = wc_get_orders( [
			'limit'    => 2,
			'customer' => $this->current_user->ID,
			'return'   => 'ids',
			'status'   => $this->options['status'],
		] );

		return ! empty( $orders );
	}
}