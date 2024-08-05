<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Providers;

class FrontendServiceProviders extends \ContentRestriction\Common\ProviderBase {

	public function boot() {
		foreach ( $this->get() as $_f ) {
			$f = new $_f();
			if ( $f instanceof \ContentRestriction\Common\FrontendBase ) {
				$f->boot();
			}
		}
	}

	private function get(): array {
		return [
			\ContentRestriction\Modules\Blur\Frontend::class,
			\ContentRestriction\Modules\Hide\Frontend::class,
			\ContentRestriction\Modules\LoginBack\Frontend::class,
			\ContentRestriction\Modules\Replace\Frontend::class,
			\ContentRestriction\Modules\Pages\Frontend::class,
			\ContentRestriction\Modules\Posts\Frontend::class,
			\ContentRestriction\Modules\Redirection\Frontend::class,
			\ContentRestriction\Modules\WordPressUsers\Frontend::class,
		];
	}
}