<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Posts;

class PostsWithTags extends \ContentRestriction\Common\WhatContentBase {
	public function __construct( $r ) {
		$this->type   = 'what-content';
		$this->module = 'posts_with_tags';
		$this->r      = $r;
	}

	public function add_protection() {
		return has_tag(
			$this->options['tags'],
			$this->post_id
		);
	}
}