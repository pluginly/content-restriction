<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class BoughtSpecificProducts extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $r ) {
		$this->type         = 'who-can-see';
		$this->module       = 'woocommerce_bought_specific_products';
		$this->r            = $r;
		$this->options      = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		if ( empty( $this->options['products'] ) ) {
			return false;
		}

		$is_purchased_any = false;

		foreach ( $this->options['products'] as $p ) {
			if ( wc_customer_bought_product( $this->current_user->user_email, $this->current_user->ID, $p ) ) {
				$is_purchased_any = true;
				break;
			}
		}

		return $is_purchased_any;
	}
}