<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Routes;

class ModulesRoute extends \ContentRestriction\Common\RouteBase {

	private $endpoint = 'modules';

	public function register_routes(): void {
		$this->post( $this->endpoint . '/who-can-see', [\ContentRestriction\Admin\Controllers\ModuleController::class, 'who_can_see'] );
		$this->post( $this->endpoint . '/what-content', [\ContentRestriction\Admin\Controllers\ModuleController::class, 'what_content'] );
		$this->post( $this->endpoint . '/restrict-view', [\ContentRestriction\Admin\Controllers\ModuleController::class, 'else_view'] );

		$this->post( $this->endpoint . '/groups', [\ContentRestriction\Admin\Controllers\ModuleController::class, 'groups'] );
	}
}