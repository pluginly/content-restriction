<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\LoginMeNow;

class Google extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $rule ) {
		$this->type         = 'who-can-see';
		$this->module       = 'login_me_now_google_verified';
		$this->rule            = $rule;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		return get_user_meta( $this->current_user->ID, 'login_me_now_google_verified', true );
	}
}