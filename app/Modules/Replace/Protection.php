<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Replace;

class Protection {
	public $what_content;
	public $options;
	public $r;
	public $post_id;

	public function __construct( $what_content, $options, $r ) {
		$this->what_content = $what_content;
		$this->options      = $options;
		$this->r            = $r;
		$this->post_id      = get_the_ID();
		$this->type         = 'what-content';
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function add( string $content, string $override ) {
		if ( ! $this->is_needed() ) {
			return $content;
		}

		return $override;
	}

	private function is_needed(): bool {
		$what_content = new $this->what_content( $this->r );
		$what_content->set_post_id( $this->post_id );
		if ( $what_content->protect() ) {
			return true;
		}

		return false;
	}
}