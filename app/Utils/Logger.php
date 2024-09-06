<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.1.0
 */
namespace ContentRestriction\Utils;

class Logger {
	public static function add( $data, string $prefix = '' ) {
		error_log( $prefix . ' : ' . print_r( $data, true ) );
	}
}