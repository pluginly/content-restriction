<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Replace;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'       => __( 'Replace', 'content-restriction' ),
			'key'        => 'replace',
			'icon'       => $this->get_icon( 'Replace' ),
			'desc'       => __( 'Replace title, excerpt, and description with custom message.', 'content-restriction' ),
			'type'       => 'section',
			'options'    => [
				'title'   => [
					'title' => __( 'Title', 'content-restriction' ),
					'desc'  => __( 'Title is a plugin that allows you to blur content on your site.', 'content-restriction' ),
					'type'  => 'text',
				],
				'content' => [
					'title' => __( 'Content', 'content-restriction' ),
					'desc'  => __( 'Randomize is a plugin that allows you to blur content on your site.', 'content-restriction' ),
					'type'  => 'textarea',
				],
				'excerpt' => [
					'title' => __( 'Excerpt', 'content-restriction' ),
					'desc'  => __( 'Excerpt is a plugin that allows you to blur content on your site.', 'content-restriction' ),
					'type'  => 'textarea',
				],
			],
			'conditions' => apply_filters(
				'content_restriction_module_replace_conditions',
				[
					'what_content' => [
						'all_listings',
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
			),
		];

		return $modules;
	}
}