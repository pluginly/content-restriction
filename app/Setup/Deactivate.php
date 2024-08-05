<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Setup;

class Deactivate {
	public function deactivate(): void {
		\flush_rewrite_rules();
	}
}