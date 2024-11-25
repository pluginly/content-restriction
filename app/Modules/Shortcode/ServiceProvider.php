<?php
/**
 * @package ContentRestriction
 * @since   1.3.1
 * @version 1.3.1
 */

namespace ContentRestriction\Modules\Shortcode;

use ContentRestriction\Repositories\ModuleRepository;
use ContentRestriction\Repositories\RuleRepository;

class ServiceProvider extends \ContentRestriction\Common\ProviderBase {
	public function boot() {
		/**
		 * Add shortcode to restrict specific portion of content.
		 * [content_restriction id="123"] Content Goes Here ... [/content_restriction]
		 */
		add_shortcode( 'content_restriction', [$this, 'content_restriction'] );

		/**
		 * Overriding the restrict view modules for shortcode.
		 */
		add_filter( 'content_restriction_replace_before', [$this, 'before_replace'], 10, 2 );
	}

	public function before_replace( bool $bool, $obj ): bool {

		if ( 'ContentRestriction\Modules\Shortcode\Shortcode' === $obj->what_content ) {
			return false;
		}

		return $bool;
	}

	public function content_restriction( $atts, $content = null ) {

		$atts = shortcode_atts(
			[
				'id' => '',
			],
			$atts,
			'content_restriction'
		);

		$rule = ( new RuleRepository() )->get( $atts['id'] );
		if ( ! $rule ) {
			return $content;
		}

		// Skip rule if it's inactive or invalid
		if ( empty( $rule['status'] ) || ! ModuleRepository::is_valid_rule( $rule['rule'] ) ) {
			return $content;
		}

		$who_can_see_key   = ModuleRepository::resolve_rule_module( $rule['rule']['who-can-see'] );
		$what_content_key  = ModuleRepository::resolve_rule_module( $rule['rule']['what-content'] );
		$restrict_view_key = ModuleRepository::resolve_rule_module( $rule['rule']['restrict-view'] );

		if ( 'shortcode' !== $what_content_key ) {
			return $content;
		}

		// Current user has no access, no restrict the content
		$who_can_see_class   = ModuleRepository::get_module( $who_can_see_key );
		$restrict_view_class = ModuleRepository::get_module( $restrict_view_key );
		$restrict_view_obj   = new $restrict_view_class(
			$what_content_key,
			$who_can_see_class,
			$rule['rule']
		);

		// error_log( ' $rule[] : ' . print_r( $rule['rule'], true ) );
		ob_start();

		echo $restrict_view_obj->modify_content( $content, 'shortcode_content' );

		return ob_get_clean();
	}
}