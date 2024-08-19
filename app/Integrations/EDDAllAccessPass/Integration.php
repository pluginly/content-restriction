<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EDDAllAccessPass;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! function_exists( 'EDD' ) || ! class_exists( 'EDD_All_Access' ) ) {
			return;
		}

		add_filter( 'content_restriction_load_modules', [$this, 'load'] );

		( new Frontend() )->boot();
	}

	public function load( $modules ) {
		$modules['edd_all_access_pass'] = AllAccessPass::class;

		return $modules;
	}
}