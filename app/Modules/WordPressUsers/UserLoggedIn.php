<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\WordPressUsers;

class UserLoggedIn extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct() {
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		return (bool) is_user_logged_in();
	}
}