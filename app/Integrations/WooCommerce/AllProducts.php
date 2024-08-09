<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class AllProducts extends \ContentRestriction\Common\WhatContentBase {
	public function add_protection() {
		return 'product' === get_post_type( $this->post_id ) ? true : false;
	}
}