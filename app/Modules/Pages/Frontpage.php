<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Pages;

class Frontpage extends \ContentRestriction\Common\WhatContentBase {
	public function add_protection() {
		return is_front_page();
	}
}