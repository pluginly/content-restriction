<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class ProductsWithCategories extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $r ) {
		$this->type   = 'what-content';
		$this->module = 'woocommerce_products_with_categories';
		$this->r      = $r;
	}

	public function add_protection() {
		return has_term(
			$this->options['categories'],
			'product_cat',
			$this->post_id
		);
	}
}