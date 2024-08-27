<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Controllers;

use ContentRestriction\Repositories\IntegrationsRepository;
use ContentRestriction\Repositories\SettingsRepository;

class SettingsController {
	public function fields() {
		return SettingsRepository::get_fields();
	}

	public function get_all() {
		return SettingsRepository::all();
	}

	public function update( \WP_REST_Request $request ) {
		$settings = $request->get_params();

		return SettingsRepository::update_batch( $settings );
	}

	public function integrations(): array {
		return IntegrationsRepository::get_all();
	}
}