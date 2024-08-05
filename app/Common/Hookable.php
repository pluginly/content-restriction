<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

trait Hookable {

	public function action( string $tag, string $function, int $priority = 10, int $accepted_args = 1 ): void {
		add_action( $tag, [$this, $function], $priority, $accepted_args );
	}

	public function filter( string $tag, string $function, int $priority = 10, int $accepted_args = 1 ): void {
		add_filter( $tag, [$this, $function], $priority, $accepted_args );
	}
}
