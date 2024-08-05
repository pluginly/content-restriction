<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Utils;

class Sanitize {
	public static function arrays( array $array ): array {
		foreach ( $array as &$value ) {
			if ( ! is_array( $value ) ) {
				$value = sanitize_text_field( $value );
			} else {
				self::arrays( $value );
			}
		}

		return $array;
	}
}