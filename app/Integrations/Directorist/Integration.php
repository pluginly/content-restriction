<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\Directorist;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! class_exists( '\Directorist_Base' ) ) {
			return;
		}

		add_filter( 'content_restriction_load_modules', [$this, 'load'] );

		( new Frontend() )->boot();

		/**
		 * Compatibility
		 */
		( new Hide() );
	}

	public function load( $modules ) {
		$modules['directorist_all_listings']      = AllListings::class;
		$modules['directorist_specific_listings'] = SpecificListings::class;

		return $modules;
	}
}