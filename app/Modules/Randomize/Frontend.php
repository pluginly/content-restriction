<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Randomize;

class Frontend extends \ContentRestriction\Common\FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'       => __( 'Randomize', 'content-restriction' ),
			'key'        => 'randomize',
			'icon'       => $this->get_icon( 'Randomize' ),
			'desc'       => __( 'Randomize words in the post or page title, excerpt, and description.', 'content-restriction' ),
			'type'       => 'section',
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
			],
			'conditions' => [
				'what_content' => [
					'all_posts',
					'posts_with_categories',
					'specific_posts',
					'posts_with_tags',
					'all_pages',
					'specific_pages',
					'frontpage',
				],
				'compare'      => 'has_any',
			],
			'is_pro'     => true,
		];

		return $modules;
	}
}