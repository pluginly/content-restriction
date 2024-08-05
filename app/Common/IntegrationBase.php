<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

abstract class IntegrationBase {
	abstract public function boot(): void;

	public function get_icon( string $module ) {
		return CONTENT_RESTRICTION_IMAGES . "{$module}.svg?" . CONTENT_RESTRICTION_VERSION;
	}
}
