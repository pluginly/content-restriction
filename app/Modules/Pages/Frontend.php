<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Pages;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_what_content_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'  => __( 'All Pages', 'content-restriction' ),
			'key'   => 'all_pages',
			'icon'  => $this->get_icon( 'WordPress' ),
			'desc'  => __( 'All the pages will be accessible when the set rule is applied.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		$modules[] = [
			'name'    => __( 'Specific Page', 'content-restriction' ),
			'key'     => 'specific_pages',
			'icon'    => $this->get_icon( 'WordPress' ),
			'desc'    => __( 'Specific page will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'group'   => 'wordpress',
			'options' => [
				'pages' => [
					'title'   => __( 'Selected Pages', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->page_list(),
				],
			],
		];

		$modules[] = [
			'name'  => __( 'Frontpage', 'content-restriction' ),
			'key'   => 'frontpage',
			'icon'  => $this->get_icon( 'WordPress' ),
			'desc'  => __( 'Frontpage will be accessible when the set rule is applied.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		return $modules;
	}

	public static function page_list() {
		$posts = get_posts( [
			'post_type'   => 'page',
			'post_status' => 'publish',
			'numberposts' => -1,
		] );

		$options = [];
		foreach ( $posts as $key => $post ) {
			$options[$post->ID] = $post->post_title;
		}

		return $options;
	}
}