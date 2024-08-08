<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Providers;

class AdminServiceProviders extends \ContentRestriction\Common\ProviderBase {
	public function boot() {
		( new \ContentRestriction\Admin\Enqueuer() );
		( new \ContentRestriction\Admin\Menu() );

		/**
		 * Routes
		 */
		( new \ContentRestriction\Admin\Routes\ModulesRoute() );
		( new \ContentRestriction\Admin\Routes\RulesRoute() );
		( new \ContentRestriction\Admin\Routes\SettingsRoute() );

		add_action( 'wp_loaded', [$this, 'hide_admin_notices'] );
		add_action( 'admin_init', [$this, 'redirect_to_dashboard'] );
	}

	public function hide_admin_notices() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( is_admin() && isset( $_GET["page"] ) && 'content-restriction' === $_GET["page"] ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	public function redirect_to_dashboard() {
		if ( ! get_option( '_content_restriction_redirect_to_dashboard', false ) ) {
			return;
		}

		delete_option( '_content_restriction_redirect_to_dashboard' );

		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			wp_safe_redirect( admin_url( 'admin.php?page=content-restriction#/rule' ) );
			exit();
		}
	}
}