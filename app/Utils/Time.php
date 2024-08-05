<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Time {

	/**
	 * Compare timestamp with now
	 */
	public static function expired( int $timestamp ): bool {
		return self::now() > $timestamp;
	}

	/**
	 * Get current timestamp
	 */
	public static function now(): int {
		return \time();
	}

	/**
	 * Get current datetime
	 * in format Y-m-d H:i:s
	 */
	public static function mysql(): string {
		return current_time( 'mysql' );
	}

	public static function mysql2date( string $date ): string {
		return mysql2date( 'Y-m-d H:i:s', $date );
	}

	public static function zone(): string {
		return wp_timezone_string();
	}

	public static function convert_timestamp( string $date_time_string ): int {
		$dateString = \preg_replace( '/\\s+\\(.+\\)/', '', $date_time_string );
		$timestamp  = \strtotime( $dateString );

		return $timestamp;
	}

	public static function create_date( $count = '-7days' ) {
		return date( 'Y-m-d', strtotime( $count, self::now() ) );
	}
}