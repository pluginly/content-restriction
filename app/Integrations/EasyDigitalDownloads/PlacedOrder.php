<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\EasyDigitalDownloads;

class PlacedOrder extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $rule ) {
		$this->type         = 'who-can-see';
		$this->module       = 'edd_placed_order';
		$this->rule            = $rule;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
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