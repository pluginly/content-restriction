<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

abstract class WhatContentBase extends ModuleBase {
	public int $post_id;
	public $what_content;
	public array $options;
	public array $r;
	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function protect() {
		$this->options = $this->r['rule'][$this->type][$this->module] ?? [];

		return $this->add_protection();
	}

	abstract public function add_protection();
}
