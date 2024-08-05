<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Redirection;

class Protection {
	public $then;
	public $options;
	public $r;
	public $post_id;

	public function __construct( $then, $options, $r ) {
		$this->then    = $then;
		$this->options = $options;
		$this->r       = $r;
		$this->post_id = get_the_ID();
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function is_needed(): bool {
		$then = new $this->then( $this->r );
		$then->set_post_id( $this->post_id );
		if ( $then->protect() ) {
			return true;
		}

		return false;
	}
}