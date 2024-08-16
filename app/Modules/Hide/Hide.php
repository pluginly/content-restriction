<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Hide;

use ContentRestriction\Common\RestrictViewBase;

class Hide extends RestrictViewBase {

	public string $what_content_type;
	public string $post_type;
	public array $then_types = ['all_posts', 'specific_posts', 'posts_with_categories', 'posts_with_tags', 'all_pages', 'specific_pages'];

	public function __construct( $who_can_see, $what_content, array $rule ) {
		$this->type         = 'restrict-view';
		$this->module       = 'hide';
		$this->rule         = $rule;
		$this->who_can_see  = $who_can_see;
		$this->what_content = $what_content;
		$this->post_id      = get_the_ID();
	}

	public function boot(): void {
		$if = ( new $this->who_can_see( $this->rule ) );
		if ( $if->has_access() ) {
			return;
		}

		\ContentRestriction\Utils\Analytics::add( [
			'user_id' => get_current_user_id(),
			'context' => 'locked',
			'id'      => $this->rule['id'],
		] );

		add_action( 'content_restriction_pre_get_posts', [$this, 'exclude'], 10, 2 );
		add_action( 'content_restriction_template_redirect', [$this, 'single_view_hide'] );
	}

	public function exclude( object $query, string $post_type ) {
		$what_content_type = is_array( $this->rule['rule']['what-content'] )
			? array_key_first( $this->rule['rule']['what-content'] )
			: $this->rule['rule']['what-content'];
		$options = $this->rule['rule']['what-content'][$what_content_type] ?? [];

		$this->post_type         = $post_type;
		$this->what_content_type = $what_content_type;

		if ( 'posts' === $post_type ) {
			switch ( $what_content_type ) {
				case 'all_posts':
					$query->set(
						'tax_query',
						[
							'relation' => 'OR',
							[
								'taxonomy' => 'category',
								'field'    => 'term_id',
								'terms'    => [100000000000000000],
								'operator' => 'IN',
							],
						]
					);
					break;

				case 'specific_posts':
					$ids = $options['posts'] ?? [];
					$query->set( 'post__not_in', $ids );
					break;

				case 'posts_with_categories':
					$ids = $options['categories'] ?? [];
					$query->set( 'category__not_in', $ids );
					break;

				case 'posts_with_tags':
					$ids = $options['tags'] ?? [];
					$query->set( 'tag__not_in', $ids );
					break;
			}

		} elseif ( 'page' === $post_type ) {
			switch ( $what_content_type ) {
				case 'all_pages':
					$query->set( 'tax_query', [
						'relation' => 'OR',
						[
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => [100000000000000000],
							'operator' => 'IN',
						],
					] );

					break;

				case 'selected_pages':
					$ids = $options['pages'] ?? [];
					$query->set( 'post__not_in', $ids );
					break;

			}
		} else {
			do_action( 'content_restriction_module_hide', $query, $post_type, $what_content_type, $options );
		}
	}

	public function single_view_hide() {
		if ( is_front_page() || is_archive() || is_home() ) {
			return;
		}

		if ( \ContentRestriction\Utils\Post::type( $this->post_id ) !== $this->post_type ) {
			return;
		}

		// 	public array $then_types = ['selected_posts',  'selected_pages'];

		switch ( $this->what_content_type ) {

			case 'all_posts':
			case 'all_pages':
				$this->redirect_to_home();
				break;

			case 'posts_with_categories':
				if ( has_term( $this->options['categories'], 'category', $this->post_id ) ) {
					$this->redirect_to_home();
				}
				break;

			case 'posts_with_tags':
				if ( has_term( $this->options['tags'], 'post_tag', $this->post_id ) ) {
					$this->redirect_to_home();
				}
				break;
		}
	}

	private function redirect_to_home() {
		wp_redirect( home_url() );
		exit;
	}
}