<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Routes;

class RulesRoute extends \ContentRestriction\Common\RouteBase {

	private $endpoint = 'rules';

	public function register_routes(): void {
		$this->post( $this->endpoint . '/create', [\ContentRestriction\Admin\Controllers\RuleController::class, 'create'] );
		$this->post( $this->endpoint . '/read', [\ContentRestriction\Admin\Controllers\RuleController::class, 'read'] );
		$this->post( $this->endpoint . '/update', [\ContentRestriction\Admin\Controllers\RuleController::class, 'update'] );
		$this->post( $this->endpoint . '/delete', [\ContentRestriction\Admin\Controllers\RuleController::class, 'delete'] );
		
		$this->post( $this->endpoint . '/list', [\ContentRestriction\Admin\Controllers\RuleController::class, 'list'] );
	}
}