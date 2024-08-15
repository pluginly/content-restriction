<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin;

use ContentRestriction\Common\EnqueuerBase;
use ContentRestriction\Utils\Config;

class Enqueuer extends EnqueuerBase {

	public function admin_enqueue_scripts(): void {
		$this->action( 'admin_head', 'admin_submenu_css' );

		wp_enqueue_style(
			'content-restriction-admin-menu',
			'?'
		);

		wp_add_inline_style( 'content-restriction-admin-menu', $this->admin_submenu_css() );

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
		if ( Config::get( 'menu_slug' ) !== $page || false === strpos( $page, Config::get( 'menu_slug' ) ) ) {
			return;
		}

		wp_enqueue_style( 'wp-components' );

		$handle            = 'content-restriction-admin-dashboard-app';
		$script_asset_path = CONTENT_RESTRICTION_ASSETS_PATH . 'dashboard-app.asset.php';

		$script_info = file_exists( $script_asset_path ) ? include $script_asset_path : [
			'dependencies' => [],
			'version'      => Config::get( 'version' ),
		];

		$script_dep = array_merge( $script_info['dependencies'], ['updates', 'wp-hooks'] );

		wp_enqueue_script(
			$handle,
			CONTENT_RESTRICTION_ASSETS . 'dashboard-app.js',
			$script_dep,
			$script_info['version'],
			true
		);

		wp_enqueue_style(
			$handle,
			CONTENT_RESTRICTION_ASSETS . 'dashboard-app.css',
			[],
			$script_info['version']
		);

		$localize = [
			'admin_base_url'   => admin_url(),
			'ajax_url'         => admin_url( 'admin-ajax.php' ),

			'current_user'     => ! empty( wp_get_current_user()->user_firstname ) ? ucfirst( wp_get_current_user()->user_firstname ) : ucfirst( wp_get_current_user()->display_name ),

			'update_nonce'     => wp_create_nonce( 'content_restriction_update_admin_setting' ),

			'plugin_name'      => __( 'Content Restriction', 'content-restriction' ),
			'plugin_admin_url' => admin_url( 'admin.php?page=' . Config::get( 'menu_slug' ) ),
			'plugin_base_url'  => CONTENT_RESTRICTION_URL,
			'plugin_rest_base' => rest_url( '/content-restriction' ),
			'plugin_version'   => Config::get( 'version' ),

			'pro_available'    => defined( 'CONTENT_RESTRICTION_PRO_VERSION' ) ? true : false,

			'rest_args'        => [
				'root'  => esc_url_raw( rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			],
		];

		wp_localize_script( $handle, 'content_restriction_admin', $localize );
	}

	public function admin_submenu_css() {
		return '.toplevel_page_content-restriction > div.wp-menu-image:before {
					margin-top: 8px;
					line-height: 27px !important;
					content: "";
					background: url("' . esc_attr( CONTENT_RESTRICTION_IMAGES ) . '/sidebar-icon.svg' . '") no-repeat center center;
					speak: none !important;
					font-style: normal !important;
					font-weight: normal !important;
					font-variant: normal !important;
					text-transform: none !important;
					/* Better Font Rendering =========== */
					-webkit-font-smoothing: antialiased !important;
					-moz-osx-font-smoothing: grayscale !important;
					box-sizing: content-box;
				}

				.toplevel_page_content-restriction .current > div.wp-menu-image:before {
					margin-top: 10px;
					background: url("' . esc_attr( CONTENT_RESTRICTION_IMAGES ) . '/sidebar-icon-current.svg' . '") no-repeat center center;
				}';
	}
}