<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Blur;

use ContentRestriction\Utils\Random;

class Protection {

	public $what_content;
	public $options;
	public $r;
	public $post_id;

	public function __construct( $what_content, $options, $r ) {
		$this->what_content = $what_content;
		$this->options      = $options;
		$this->r            = $r;
		$this->post_id      = get_the_ID();
	}

	public function set_post_id( $post_id ) {
		$this->post_id = $post_id;
	}

	public function add( $content ) {
		if ( ! $this->is_needed() ) {
			return $content;
		}

		$html_tag      = 'div';
		$add_rand_text = apply_filters( 'content_restriction_blur_protection_rand_text', true );
		if ( $add_rand_text ) {
			$content = Random::randomize( $content );
		}

		$blur_level = $this->options['level'] ?? 10;
		$spread     = $this->options['spread'] ?? 10;

		return sprintf(
			'<%s class="aiocr-blur" style="-webkit-filter: blur(%spx); text-shadow: 0 0 %spx #000;">%s</%s>',
			$html_tag,
			esc_attr( $blur_level ),
			esc_attr( $spread ),
			$content,
			$html_tag
		);
	}

	private function is_needed(): bool {
		$what_content = new $this->what_content( $this->r );
		$what_content->set_post_id( $this->post_id );
		if ( $what_content->protect() ) {
			return true;
		}

		return false;
	}
}