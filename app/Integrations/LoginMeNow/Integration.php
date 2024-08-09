<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\LoginMeNow;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! class_exists( 'LoginMeNow' ) ) {
			return;
		}

		add_filter( 'content_restriction_load_modules', [$this, 'load'], 11 );

		( new Frontend() )->boot();
	}

	public function load( $modules ): array {
		$modules['login_me_now_facebook_verified'] = Facebook::class;
		$modules['login_me_now_google_verified']   = Google::class;

		return $modules;
	}
}