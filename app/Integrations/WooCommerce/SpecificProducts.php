<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class SpecificProducts extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $r ) {
		$this->type   = 'what-content';
		$this->module = 'woocommerce_specific_products';
		$this->r      = $r;
	}

	public function add_protection() {
		return in_array(
			$this->post_id,
			$this->options['products']
		);
	}
}