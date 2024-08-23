<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\EasyDigitalDownloads;

use ContentRestriction\Common\IntegrationBase;

class Frontend extends IntegrationBase {
	public function boot(): void {

		add_filter( 'content_restriction_module_group_list', [$this, 'add_group'] );
		add_filter( 'content_restriction_what_content_module_list', [$this, 'what_content'] );
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'who_can_see'] );

		/**
		 * Code goes here
		 */
	}

	public function add_group( array $groups ): array {
		$groups['easy-digital-downloads'] = [
			'title' => __( 'Easy Digital Downloads', 'content-restriction' ),
			'icon'  => $this->get_icon( 'EasyDigitalDownloads' ),
		];

		return $groups;
	}

	public function what_content( array $modules ): array {
		$modules[] = [
			'name'  => __( 'All Downloads', 'content-restriction' ),
			'key'   => 'edd_all_downloads',
			'group' => 'edd',
			'meta'  => ['downloads', 'edd', 'all downloads'],
			'icon'  => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'  => __( 'All EasyDigitalDownloads Downloads is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
		];

		$modules[] = [
			'name'    => __( 'Specific Downloads', 'content-restriction' ),
			'key'     => 'edd_specific_downloads',
			'group'   => 'edd',
			'meta'    => ['downloads', 'edd', 'all downloads'],
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'Specific EasyDigitalDownloads Downloads is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'downloads' => [
					'title'   => __( 'Select Downloads', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->download_list(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Downloads With Categories', 'content-restriction' ),
			'key'     => 'edd_downloads_with_categories',
			'meta'    => ['downloads', 'edd', 'all downloads'],
			'group'   => 'edd',
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'Downloads With Categories is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'categories' => [
					'title'   => __( 'Select Categories', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->term_list( 'download_category' ),
				],
			],
			'is_pro'  => true,
		];

		return $modules;
	}

	public function download_list() {
		$posts = get_posts( [
			'post_type'   => 'download',
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
			'key'     => 'edd_placed_order',
			'group'   => 'edd',
			'meta'    => ['order', 'edd', 'has orders'],
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'All Edd Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'status' => [
					'title'   => __( 'Select Payment Status', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->get_payment_statuses(),
				],
			],
		];

		// $modules[] = [
		// 	'name'    => __( 'Bought Specific Downloads', 'content-restriction' ),
		// 	'key'     => 'edd_bought_specific_downloads',
		// 	'group'   => 'edd',
		// 	'meta'    => ['checkout', 'purchased', 'bought', 'edd', 'products'],
		// 	'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
		// 	'desc'    => __( 'All edd Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
		// 	'type'    => 'section',
		// 	'options' => [
		// 		'downloads' => [
		// 			'title'   => __( 'Select Products', 'content-restriction' ),
		// 			'type'    => 'multi-select',
		// 			'options' => $this->download_list(),
		// 		],
		// 	],
		// 	'is_pro'  => true,
		// ];

		if ( class_exists( 'EDD_All_Access' ) ) {
			$modules[] = [
				'name'   => __( 'All Access Pass', 'content-restriction' ),
				'key'    => 'edd_all_access_pass',
				'group'  => 'edd',
				'meta'   => ['downloads', 'edd', 'all downloads'],
				'icon'   => $this->get_icon( 'EasyDigitalDownloads' ),
				'desc'   => __( 'All EasyDigitalDownloads Access is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
				'is_pro' => true,
			];
		}

		return $modules;
	}

	public function get_payment_statuses() {
		return edd_get_payment_statuses();
	}
}