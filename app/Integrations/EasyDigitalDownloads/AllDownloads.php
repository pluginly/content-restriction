<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EasyDigitalDownloads;

class AllDownloads extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'edd_all_downloads';
		$this->rule      = $rule;
	}

	public function add_protection() {
		return 'download' === get_post_type( $this->post_id ) ? true : false;
	}
}