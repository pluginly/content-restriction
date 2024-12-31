<?php
/**
 * @package ContentRestriction
 * @since   1.4.0
 * @version 1.4.0
 */

namespace ContentRestriction\Integrations\Directorist;

class SpecificDirectoryTypeListings extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'directorist_listings_with_directory_type';
		$this->rule   = $rule;
	}

	public function add_protection() {
		$type = (int) get_post_meta( $this->post_id, '_directory_type', true );

		error_log( '$type : ' . print_r( $type, true ) );
		error_log( '$types : ' . print_r( $this->options['directory_types'], true ) );

		return in_array(
			$type,
			$this->options['directory_types']
		);
	}
}