<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\LoginBack;

class Protection {
	public $what_content;
	public $options;
	public $rule;
	public $post_id;

	public function __construct( $what_content, $options, $rule ) {
		$this->what_content = $what_content;
		$this->options      = $options;
		$this->rule            = $rule;
		$this->post_id      = get_the_ID();
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function is_needed(): bool {
		$what_content = new $this->what_content( $this->rule );
		$what_content->set_post_id( $this->post_id );
		if ( $what_content->protect() ) {
			return true;
		}

		return false;
	}
}