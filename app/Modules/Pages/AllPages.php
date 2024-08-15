<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Pages;

class AllPages extends \ContentRestriction\Common\WhatContentBase {
	public function __construct( $r ) {
		$this->type   = 'what-content';
		$this->module = 'all_pages';
		$this->r      = $r;
	}

	public function add_protection() {
		return 'page' === get_post_type( $this->post_id ) ? true : false;
	}
}