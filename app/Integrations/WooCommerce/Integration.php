<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.2.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! class_exists( '\WooCommerce' ) ) {
			return;
		}

		add_filter( 'content_restriction_load_modules', [$this, 'load'], 11 );

		( new Frontend() )->boot();

		/**
		 * Compatibilities
		 */
		( new Hide() );
	}

	public function load( $modules ): array {
		$modules['woocommerce_all_products']             = AllProducts::class;
		$modules['woocommerce_products_with_categories'] = ProductsWithCategories::class;
		$modules['woocommerce_specific_products']        = SpecificProducts::class;

		$modules['woocommerce_placed_order']             = PlacedOrder::class;
		$modules['woocommerce_bought_specific_products'] = BoughtSpecificProducts::class;

		if ( class_exists( 'WC_Subscriptions' ) ) {
			$modules['woocommerce_subscriptions_subscriber'] = Subscriber::class;
		}

		return $modules;
	}
}