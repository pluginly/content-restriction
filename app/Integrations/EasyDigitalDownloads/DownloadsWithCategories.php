<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EasyDigitalDownloads;

class DownloadsWithCategories extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $rule ) {
		$this->type   = 'what-content';
		$this->module = 'edd_downloads_with_categories';
		$this->rule      = $rule;
	}

	public function add_protection() {
		return has_term(
			$this->options['categories'],
			'download_category',
			$this->post_id
		);
	}
}