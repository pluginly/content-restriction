<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Admin\Routes;

class SettingsRoute extends \ContentRestriction\Common\RouteBase {
	private $endpoint = 'settings';

	public function register_routes(): void {
		$this->post( $this->endpoint . '/fields', [\ContentRestriction\Admin\Controllers\SettingsController::class, 'fields'] );
		$this->post( $this->endpoint . '/get-all', [\ContentRestriction\Admin\Controllers\SettingsController::class, 'get_all'] );
		$this->post( $this->endpoint . '/update', [\ContentRestriction\Admin\Controllers\SettingsController::class, 'update'] );
		$this->post( $this->endpoint . '/integrations', [\ContentRestriction\Admin\Controllers\SettingsController::class, 'integrations'] );
	}
}