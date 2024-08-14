<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\WooCommerce;

use ContentRestriction\Common\IntegrationBase;

class Frontend extends IntegrationBase {
	public function boot(): void {
		add_filter( 'content_restriction_module_group_list', [$this, 'add_group'] );
		add_filter( 'content_restriction_what_content_module_list', [$this, 'what_content'] );
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'who_can_see'] );
	}

	public function add_group( array $groups ): array {
		$groups['woocommerce'] = [
			'title'   => __( 'WooCommerce', 'content-restriction' ),
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'details' => '#',
		];

		return $groups;
	}

	public function what_content( array $modules ): array {
		$modules[] = [
			'name'  => __( 'All Products', 'content-restriction' ),
			'key'   => 'woocommerce_all_products',
			'group' => 'woocommerce',
			'meta'  => ['products', 'woocommerce', 'all products'],
			'icon'  => $this->get_icon( 'WooCommerce' ),
			'desc'  => __( 'All WooCommerce Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
		];

		$modules[] = [
			'name'    => __( 'Specific Products', 'content-restriction' ),
			'key'     => 'woocommerce_specific_products',
			'group'   => 'woocommerce',
			'meta'    => ['products', 'woocommerce', 'all products'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'Specific WooCommerce products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'products' => [
					'title'   => __( 'Select Products', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->product_list(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Products With Categories', 'content-restriction' ),
			'key'     => 'woocommerce_products_with_categories',
			'group'   => 'woocommerce',
			'meta'    => ['products', 'woocommerce', 'all products'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'Products With Categories is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'categories' => [
					'title'   => __( 'Select Categories', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->term_list( 'product_cat' ),
				],
			],
		];

		return $modules;
	}

	public function product_list() {
		$posts = get_posts( [
			'post_type'   => 'product',
			'post_status' => 'publish',
		] );

		$options = [];
		foreach ( $posts as $key => $post ) {
			$options[$post->ID] = $post->post_title;
		}

		return $options;
	}

	public function term_list( string $taxonomy ) {
		$terms = get_terms( [
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		] );

		$options = [];
		foreach ( $terms as $key => $term ) {
			$options[$term->term_id] = $term->name;
		}

		return $options;
	}

	public function who_can_see( array $modules ): array {
		$modules[] = [
			'name'    => __( 'Placed Order', 'content-restriction' ),
			'key'     => 'woocommerce_placed_order',
			'group'   => 'woocommerce',
			'meta'    => ['order', 'woocommerce', 'has orders'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'All WooCommerce Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'status' => [
					'title'   => __( 'Select Order Status', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->get_order_statuses(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Bought Specific Products', 'content-restriction' ),
			'key'     => 'woocommerce_bought_specific_products',
			'group'   => 'woocommerce',
			'meta'    => ['checkout', 'purchased', 'bought', 'woocommerce', 'products'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'All WooCommerce Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'products' => [
					'title'   => __( 'Select Products', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->product_list(),
				],
			],
		];

		return $modules;
	}

	public function get_order_statuses() {
		return wc_get_order_statuses();
	}
}