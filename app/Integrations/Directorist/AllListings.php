<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\Directorist;

class AllListings extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'directorist_all_listings';
		$this->rule      = $rule;
	}

	public function add_protection() {
		return 'at_biz_dir' === get_post_type( $this->post_id ) ? true : false;
	}
}