<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Hide;

use ContentRestriction\Common\RestrictViewBase;

class Hide extends RestrictViewBase {

	public function __construct( $who_can_see, $what_content, array $r ) {
		$this->type         = 'restrict-view';
		$this->module       = 'hide';
		$this->r            = $r;
		$this->who_can_see  = $who_can_see;
		$this->what_content = $what_content;
	}

	public function boot(): void {
		$if = ( new $this->who_can_see( $this->r ) );
		if ( $if->has_access() ) {
			return;
		}

		\ContentRestriction\Utils\Analytics::add( [
			'user_id' => get_current_user_id(),
			'context' => 'locked',
			'id'      => $this->r['id'],
		] );

		add_action( 'content_restriction_pre_get_posts', [$this, 'exclude'], 10, 2 );
	}

	public function exclude( object $query, string $post_type ) {
		$what_content_type = is_array( $this->r['rule']['what-content'] ) ? array_key_first( $this->r['rule']['what-content'] ) : $this->r['rule']['what-content'];
		$options           = $this->r['rule']['what-content'][$what_content_type] ?? [];

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

				case 'selected_posts':
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
}