<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Providers;

class RestrictionServiceProviders extends \ContentRestriction\Common\ProviderBase {

	public function boot() {
		$repo = new \ContentRestriction\Repositories\ModuleRepository();
		if ( ! $repo->has_restrictions() ) {
			return;
		}

		/**
		 * Blur, Randomize, & Replace
		 */
		add_filter( 'the_title', [$this, 'the_title'], 10, 2 );
		add_filter( 'get_the_excerpt', [$this, 'the_excerpt'], 11, 2 );
		add_filter( 'the_content', [$this, 'the_content'] );

		/**
		 *  Hide
		 */
		add_action( 'pre_get_posts', [$this, 'pre_get_posts'], 110 );

		/**
		 * LoginBack & Redirection
		 */
		add_action( 'template_redirect', [$this, 'template_redirect'] );
		add_filter( 'register_url', [$this, 'register_url'] );

		$repo->load();
	}

	public function the_title( $title, $post_id ) {
		return apply_filters( 'content_restriction_the_title', $title, $post_id );
	}

	public function the_excerpt( $excerpt, $post ) {
		return apply_filters( 'content_restriction_the_excerpt', $excerpt, $post );
	}

	public function the_content( $content ) {
		return apply_filters( 'content_restriction_the_content', $content, get_the_ID() );
	}

	public function pre_get_posts( $query ) {
		if ( is_admin() ) {
			return;
		}

		$post_type = (string) isset( $query->query_vars['post_type'] ) ? $query->query_vars['post_type'] : 'posts';

		do_action( 'content_restriction_pre_get_posts', $query, $post_type );
	}

	public function template_redirect() {
		do_action( 'content_restriction_template_redirect', get_the_ID() );
	}

	public function register_url( $str ) {
		do_action( 'content_restriction_register_url', $str );
	}
}