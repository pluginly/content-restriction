<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EDDAllAccessPass;

use ContentRestriction\Common\IntegrationBase;

class Frontend extends IntegrationBase {
	public function boot(): void {
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'who_can_see'] );

		/**
		 * Code goes here
		 */
	}

	public function who_can_see( array $modules ): array {
		$modules[] = [
			'name'   => __( 'All Access Pass', 'content-restriction-pro' ),
			'key'    => 'edd_all_access_pass',
			'group'  => 'edd',
			'meta'   => ['downloads', 'edd', 'all downloads'],
			'icon'   => $this->get_icon( 'EasyDigitalDownloads' ),
			'desc'   => __( 'All EasyDigitalDownloads Access is a plugin that allows you to manage posts in WordPress.', 'content-restriction-pro' ),
			'is_pro' => true,
		];

		return $modules;
	}
}