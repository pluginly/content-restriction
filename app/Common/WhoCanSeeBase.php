<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

abstract class WhoCanSeeBase extends ModuleBase {
	private $current_user;
	public array $r;
	public array $options;
	public int $user_id;

	public function is_administrator() {
		return is_blog_admin() || is_admin() || user_can( $this->user_id, 'edit_posts' );
	}

	public function has_access(): bool {
		if ( $this->is_administrator() ) {
			return true;
		}

		return (bool) $this->give_access();
	}

	abstract public function give_access(): bool;
}
