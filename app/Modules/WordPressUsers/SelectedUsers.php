<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\WordPressUsers;

class SelectedUsers extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $r ) {
		$this->type         = 'who-can-see';
		$this->module       = 'selected_users';
		$this->r            = $r;
		$this->options      = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		if ( empty( $this->options['selected_users'] ) ) {
			return false;
		}

		if ( in_array( $this->current_user->ID, $this->options['selected_users'] ) ) {
			return true;
		}

		return false;
	}
}