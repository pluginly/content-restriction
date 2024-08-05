<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Post {
	public static function exists( int $id ): bool {
		return self::status( $id )?\true : \false;
	}

	public static function status( int $id ): string {
		return get_post_status( $id ) ?? '';
	}

	public static function type( int $id ): string {
		return get_post_type( $id ) ?? '';
	}
}