<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\Directorist;

class ListingsWithCategories extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'directorist_listings_with_categories';
		$this->rule      = $rule;
	}

	public function add_protection() {
		return has_term(
			$this->options['categories'],
			'at_biz_dir-category',
			$this->post_id
		);
	}
}