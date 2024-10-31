<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.2.0
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
			'desc'  => __( 'All the products will be accessible when the set rule is applied.', 'content-restriction' ),
		];

		$modules[] = [
			'name'    => __( 'Specific Products', 'content-restriction' ),
			'key'     => 'woocommerce_specific_products',
			'group'   => 'woocommerce',
			'meta'    => ['products', 'woocommerce', 'all products'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'Specific product will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'products' => [
					'title'   => __( 'Select Products', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->product_list(),
				],
			],
			'is_pro'  => true,
		];

		$modules[] = [
			'name'    => __( 'Products With Categories', 'content-restriction' ),
			'key'     => 'woocommerce_products_with_categories',
			'group'   => 'woocommerce',
			'meta'    => ['products', 'woocommerce', 'all products'],
			'icon'    => $this->get_icon( 'WooCommerce' ),
			'desc'    => __( 'Product with the category will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'categories' => [
					'title'   => __( 'Select Categories', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->term_list( 'product_cat' ),
				],
			],
			'is_pro'  => true,
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
			'desc'    => __( 'Only who placed an order should have access to the content.', 'content-restriction' ),
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
			'desc'    => __( 'Only who bought specific product should have access to the content.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'products' => [
					'title'   => __( 'Select Products', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->product_list(),
				],
			],
			'is_pro'  => true,
		];

		if ( class_exists( 'WC_Subscriptions' ) ) {

			$modules[] = [
				'name'    => __( 'Subscriber', 'content-restriction' ),
				'key'     => 'woocommerce_subscriptions_subscriber',
				'group'   => 'woocommerce',
				'meta'    => ['checkout', 'purchased', 'bought', 'woocommerce', 'products'],
				'icon'    => $this->get_icon( 'WooCommerce' ),
				'desc'    => __( 'Only who subscriber should have access to the content.', 'content-restriction' ),
				'type'    => 'section',
				'options' => [
					'status' => [
						'title'   => __( 'Select Subscription Status', 'content-restriction' ),
						'type'    => 'multi-select',
						'options' => $this->subscription_status(),
					],
				],
			];

			$modules[] = [
				'name'    => __( 'Specific Subscription', 'content-restriction' ),
				'key'     => 'woocommerce_subscriptions_specific_subscription',
				'group'   => 'woocommerce',
				'meta'    => ['checkout', 'purchased', 'bought', 'woocommerce', 'products'],
				'icon'    => $this->get_icon( 'WooCommerce' ),
				'desc'    => __( 'Only who subscriber of specific subscriptions should have access to the content.', 'content-restriction' ),
				'type'    => 'section',
				'options' => [
					'subscriptions' => [
						'title'   => __( 'Select Subscriptions', 'content-restriction' ),
						'type'    => 'multi-select',
						'options' => $this->subscription_product_list(),
					],
					'status'        => [
						'title'   => __( 'Select Subscription Status', 'content-restriction' ),
						'type'    => 'multi-select',
						'options' => $this->subscription_status(),
					],
				],
				'is_pro'  => true,
			];
		}

		return $modules;
	}

	public function subscription_product_list() {
		// Retrieve posts of type 'product' with status 'publish' and product type 'subscription'
		$posts = get_posts( [
			'post_type'   => 'product',
			'post_status' => 'publish',
			'numberposts' => -1, // Retrieve all published products
			'tax_query'   => [
				[
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'subscription', // Only subscription products
				],
			],
		] );

		$options = [];
		foreach ( $posts as $post ) {
			$options[$post->ID] = $post->post_title;
		}

		return $options;
	}

	public function subscription_status() {
		return wcs_get_subscription_statuses();
	}

	public function get_order_statuses() {
		return wc_get_order_statuses();
	}
}