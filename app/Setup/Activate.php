<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Setup;

use ContentRestriction\Utils\Config;

class Activate {
	public function __construct( $file_name ) {
		add_option( '_content_restriction_redirect_to_dashboard', true );
	}
}