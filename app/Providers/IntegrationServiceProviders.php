<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Providers;

class IntegrationServiceProviders extends \ContentRestriction\Common\ProviderBase {

	public function boot() {
		foreach ( $this->get() as $_i ) {
			$i = new $_i();
			if ( $i instanceof \ContentRestriction\Common\IntegrationBase ) {
				$i->boot();
			}
		}
	}

	private function get(): array {
		return [
			\ContentRestriction\Integrations\FluentCRM\Integration::class,
			\ContentRestriction\Integrations\LoginMeNow\Integration::class,
			\ContentRestriction\Integrations\WooCommerce\Integration::class,
		];
	}
}