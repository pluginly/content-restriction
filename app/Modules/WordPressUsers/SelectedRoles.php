<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\WordPressUsers;

class SelectedRoles extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $r ) {
		$this->type         = 'who-can-see';
		$this->module       = 'selected_roles';
		$this->r            = $r;
		$this->options      = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		if ( empty( $this->options['roles'] ) ) {
			return false;
		}

		foreach ( $this->options['roles'] as $role ) {
			if ( in_array( $role, $this->current_user->roles ) ) {
				return true;
			}
		}

		return false;
	}
}