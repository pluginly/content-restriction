<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Boot;

class App {

	public static bool $loaded;
	public static App $instance;

	public static function instance() {
		if ( empty( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function boot( $plugin_root_file, $plugin_root_dir ) {
		if ( ! empty( static::$loaded ) ) {
			return;
		}

		$this->constants( $plugin_root_file );
	}

	public function load() {
		if ( ! empty( static::$loaded ) ) {
			return;
		}

		/**
		 * Providers
		 */
		( new \ContentRestriction\Providers\AdminServiceProviders() )->boot();
		( new \ContentRestriction\Providers\FrontendServiceProviders() )->boot();
		( new \ContentRestriction\Modules\Shortcode\ServiceProvider )->boot();
		( new \ContentRestriction\Providers\IntegrationServiceProviders() )->boot();
		( new \ContentRestriction\Providers\RestrictionServiceProviders )->boot();

		static::$loaded = \true;
	}

	private function constants( $plugin_root_file ): void {
		define( 'CONTENT_RESTRICTION_VERSION', \ContentRestriction\Utils\Config::get( 'version' ) );
		define( 'CONTENT_RESTRICTION_FILE', $plugin_root_file );
		define( 'CONTENT_RESTRICTION_URL', plugins_url( '', CONTENT_RESTRICTION_FILE ) );
		define( 'CONTENT_RESTRICTION_PATH', dirname( CONTENT_RESTRICTION_FILE ) );
		define( 'CONTENT_RESTRICTION_TEMPLATE_PATH', CONTENT_RESTRICTION_PATH . '/templates' );
		define( 'CONTENT_RESTRICTION_APP_PATH', CONTENT_RESTRICTION_PATH . '/app/' );
		define( 'CONTENT_RESTRICTION_APP_URL', CONTENT_RESTRICTION_URL . '/app/' );

		define( 'CONTENT_RESTRICTION_MODULES', CONTENT_RESTRICTION_APP_PATH . 'modules' );
		define( 'CONTENT_RESTRICTION_MODULES_URL', CONTENT_RESTRICTION_URL . '/modules/' );

		define( 'CONTENT_RESTRICTION_ASSETS_PATH', CONTENT_RESTRICTION_PATH . '/assets/' );
		define( 'CONTENT_RESTRICTION_ASSETS', CONTENT_RESTRICTION_URL . '/assets/' );
		define( 'CONTENT_RESTRICTION_IMAGES', CONTENT_RESTRICTION_URL . '/assets/icons/' );

		define( 'CONTENT_RESTRICTION_ADMIN_URL', CONTENT_RESTRICTION_APP_URL . 'Admin' );
		define( 'CONTENT_RESTRICTION_ADMIN_PATH', CONTENT_RESTRICTION_APP_PATH . 'Admin' );
	}
}