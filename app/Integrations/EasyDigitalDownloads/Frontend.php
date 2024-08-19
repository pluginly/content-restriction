<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EasyDigitalDownloads;

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
			'title' => __( 'Easy Digital Downloads', 'content-restriction-pro' ),
			'icon'  => $this->get_icon( 'EasyDigitalDownloads' ),
		];

		return $groups;
	}

	public function what_content( array $modules ): array {
		$modules[] = [
			'name'  => __( 'All Downloads', 'content-restriction-pro' ),
			'key'   => 'edd_all_downloads',
			'group' => 'edd',
			'meta'  => ['downloads', 'edd', 'all downloads'],
			'icon'  => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'  => __( 'All EasyDigitalDownloads Downloads is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
		];

		$modules[] = [
			'name'    => __( 'Specific Downloads', 'content-restriction-pro' ),
			'key'     => 'edd_specific_downloads',
			'group'   => 'edd',
			'meta'    => ['downloads', 'edd', 'all downloads'],
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'Specific EasyDigitalDownloads Downloads is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
			'type'    => 'section',
			'options' => [
				'downloads' => [
					'title'   => __( 'Select Downloads', 'content-restriction-pro' ),
					'type'    => 'multi-select',
					'options' => $this->download_list(),
				],
			],
			'is_pro'  => true,
		];

		$modules[] = [
			'name'    => __( 'Downloads With Categories', 'content-restriction-pro' ),
			'key'     => 'edd_downloads_with_categories',
			'meta'    => ['downloads', 'edd', 'all downloads'],
			'group'   => 'edd',
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'Downloads With Categories is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
			'type'    => 'section',
			'options' => [
				'categories' => [
					'title'   => __( 'Select Categories', 'content-restriction-pro' ),
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
			'name'    => __( 'Placed Order', 'content-restriction-pro' ),
			'key'     => 'edd_placed_order',
			'group'   => 'edd',
			'meta'    => ['order', 'edd', 'has orders'],
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'All Edd Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
			'type'    => 'section',
			'options' => [
				'status' => [
					'title'   => __( 'Select Payment Status', 'content-restriction-pro' ),
					'type'    => 'multi-select',
					'options' => $this->get_payment_statuses(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Bought Specific Downloads', 'content-restriction-pro' ),
			'key'     => 'edd_bought_specific_downloads',
			'group'   => 'edd',
			'meta'    => ['checkout', 'purchased', 'bought', 'edd', 'products'],
			'icon'    => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'    => __( 'All edd Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
			'type'    => 'section',
			'options' => [
				'downloads' => [
					'title'   => __( 'Select Products', 'content-restriction-pro' ),
					'type'    => 'multi-select',
					'options' => $this->download_list(),
				],
			],
		];

		return $modules;
	}

	public function get_payment_statuses() {
		return edd_get_payment_statuses();
	}
}