<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Posts;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_what_content_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name' => __( 'All Posts', 'content-restriction' ),
			'key'  => 'all_posts',
			'icon' => $this->get_icon( 'WordPress' ),
			'desc' => __( 'All the posts will be accessible when the set rule is applied.', 'content-restriction' ),
		];

		$modules[] = [
			'name'    => __( 'Specific Post', 'content-restriction' ),
			'key'     => 'specific_posts',
			'icon'    => $this->get_icon( 'WordPress' ),
			'desc'    => __( 'Specific post will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'posts' => [
					'title'   => __( 'Select Posts', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->post_list(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Posts With Categories', 'content-restriction' ),
			'key'     => 'posts_with_categories',
			'icon'    => $this->get_icon( 'WordPress' ),
			'desc'    => __( 'Post with the category will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'categories' => [
					'title'   => __( 'Select Categories', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->term_list( 'category' ),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Posts With Tags', 'content-restriction' ),
			'key'     => 'posts_with_tags',
			'icon'    => $this->get_icon( 'WordPress' ),
			'desc'    => __( 'Post with the tag will be accessible when the set rule is applied.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'tags' => [
					'title'   => __( 'Select Tags', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->term_list( 'post_tag' ),
				],
			],
		];

		return $modules;
	}

	public function post_list() {
		$posts = get_posts( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'numberposts' => -1,
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
}