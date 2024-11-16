<?php
/**
 * @package ContentRestriction
 * @since   1.3.1
 * @version 1.3.1
 */

namespace ContentRestriction\Modules\Shortcode;

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

		ob_start();
		echo 34343;
		echo $content;

		// error_log( ' $content : ' . print_r( $content, true ) );
		// error_log( ' $atts[id] : ' . print_r( $atts['id'], true ) );

		return ob_get_clean();
	}
}