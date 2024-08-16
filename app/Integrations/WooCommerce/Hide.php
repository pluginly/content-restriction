<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

class Hide extends \ContentRestriction\Common\IntegrationHide {
	public array $then_types = ['woocommerce_all_products', 'woocommerce_specific_products', 'woocommerce_products_with_categories'];
	public string $post_type = 'product';

	public function single_view_hide() {
		if ( is_front_page() || is_archive() || is_home() ) {
			return;
		}

		if ( \ContentRestriction\Utils\Post::type( $this->post_id ) !== $this->post_type ) {
			return;
		}

		switch ( $this->what_content_type ) {

			case 'woocommerce_all_products':
				$this->redirect_to_home();
				break;

			case 'woocommerce_products_with_categories':
				if ( has_term( $this->options['categories'], 'product_cat', $this->post_id ) ) {
					$this->redirect_to_home();
				}
				break;
		}
	}

	public function hide( $query, $post_type, $what_content_type, $options ) {

		if ( $this->post_type !== $post_type ) {
			return;
		}

		$this->options           = $options;
		$this->what_content_type = $what_content_type;

		if ( ! in_array( $this->what_content_type, $this->then_types ) ) {
			return;
		}

		switch ( $this->what_content_type ) {
			case 'woocommerce_all_products':
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => [100000000000000000],
							'operator' => 'IN',
						],
					]
				);
				break;

			case 'woocommerce_specific_products':
				$ids = $options['products'] ?? [];
				$query->set( 'post__not_in', $ids );
				break;

			case 'woocommerce_products_with_categories':
				$ids = $options['categories'] ?? [];
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $ids,
							'operator' => 'NOT IN',
						],
					]
				);
				break;
		}
	}
}