<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\FluentCRM;

class Integration extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		if ( ! defined( 'FLUENTCRM' ) ) {
			return;
		}

		add_filter( 'content_restriction_load_modules', [$this, 'load'], 11 );

		( new Frontend() )->boot();
	}

	public function load( $modules ): array {
		$modules['fluent_crm_subscriber'] = Subscriber::class;

		return $modules;
	}
}