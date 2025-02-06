<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Blur;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {
	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'       => __( 'Blur', 'content-restriction' ),
			'key'        => 'blur',
			'icon'       => $this->get_icon( 'Blur' ),
			'desc'       => __( 'Blur title, excerpt and description.', 'content-restriction' ),
			'type'       => 'section',
			'group'      => 'wordpress',
			'options'    => [
				'apply_to' => [
					'title'   => __( 'Apply To', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => [
						'title'   => __( 'Title', 'content-restriction' ),
						'content' => __( 'Content', 'content-restriction' ),
						'excerpt' => __( 'Excerpt', 'content-restriction' ),
					],
				],
				'level'    => [
					'title'   => __( 'Level', 'content-restriction' ),
					'type'    => 'range',
					'default' => 20,
				],
				'spread'   => [
					'title'   => __( 'Spread', 'content-restriction' ),
					'type'    => 'range',
					'default' => 40,
				],
			],
			'conditions' => apply_filters(
				'content_restriction_module_blur_conditions',
				[
					'what_content' => [
						'all_posts',
						'posts_with_categories',
						'specific_posts',
						'posts_with_tags',
						'all_pages',
						'specific_pages',
						'frontpage',
						'shortcode'
					],
					'compare'      => 'has_any',
				],
			),
		];

		return $modules;
	}
}