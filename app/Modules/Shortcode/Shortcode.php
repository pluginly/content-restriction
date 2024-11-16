<?php
/**
 * @package ContentRestriction
 * @since   1.3.1
 * @version 1.3.1
 */

namespace ContentRestriction\Modules\Shortcode;

class Shortcode extends \ContentRestriction\Common\WhatContentBase {
	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'shortcode';
		$this->rule   = $rule;
	}

	public function add_protection() {
		return true;
	}
}