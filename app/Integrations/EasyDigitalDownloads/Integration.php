<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EasyDigitalDownloads;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! function_exists( 'EDD' ) ) {
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
		$modules['edd_all_downloads']             = AllDownloads::class;
		$modules['edd_downloads_with_categories'] = DownloadsWithCategories::class;
		$modules['edd_specific_downloads']        = SpecificDownloads::class;

		$modules['edd_placed_order'] = PlacedOrder::class;

		return $modules;
	}
}