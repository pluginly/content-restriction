<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Posts;

class PostsWithCategories extends \ContentRestriction\Common\WhatContentBase {

	public function __construct( $r ) {
		$this->type   = 'what-content';
		$this->module = 'posts_with_categories';
		$this->r      = $r;
	}

	public function add_protection() {
		return has_term(
			$this->options['categories'],
			'category',
			$this->post_id
		);
	}
}