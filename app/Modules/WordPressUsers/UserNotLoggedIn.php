<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\WordPressUsers;

class UserNotLoggedIn extends \ContentRestriction\Common\WhoCanSeeBase {
	public function __construct() {
		$this->user_id = 0;
	}

	public function give_access(): bool {
		return ! (bool) is_user_logged_in();
	}
}