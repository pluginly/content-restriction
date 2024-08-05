<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Setup;

use ContentRestriction\Utils\Config;

class Compatibility {
	public static function php(): bool {
		if ( version_compare( PHP_VERSION, Config::get( 'min_php' ), '<' ) ) {
			return false;
		}

		return true;
	}
}