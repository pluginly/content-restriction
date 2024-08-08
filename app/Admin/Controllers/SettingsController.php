<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Controllers;

use ContentRestriction\Repositories\SettingsRepository;

class SettingsController {
	public function save() {
	}
	public function integrations(): array {
		return SettingsRepository::integrations();
	}
}