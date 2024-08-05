<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Transient {
	public static function set( string $key, $value, $expiration = DAY_IN_SECONDS ): bool {
		return set_transient( Key::get( $key ), $value, $expiration );
	}

	public static function get( string $key ) {
		return get_transient( Key::get( $key ) );
	}
}