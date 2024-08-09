<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin;

use ContentRestriction\Utils\Config;

class Menu {
	public function __construct() {
		add_action( 'admin_menu', [$this, 'add'] );
	}

	public function add(): void {
		$content_restriction_icon = apply_filters( 'menu_icon', 'dashicons-admin-generic' );

		if ( ! current_user_can( Config::get( 'menu_cap' ) ) ) {
			return;
		}

		$slug = Config::get( 'menu_slug' );
		$cap  = Config::get( 'menu_cap' );

		add_menu_page(
			__( 'Content Restriction', 'content-restriction' ),
			apply_filters(
				'content_restriction_title',
				__( 'Content Restriction', 'content-restriction' )
			),
			$cap,
			$slug,
			[$this, 'render_dashboard'],
			$content_restriction_icon,
		);

		add_submenu_page(
			$slug,
			__( 'Dashboard', 'content-restriction' ),
			__( 'Dashboard', 'content-restriction' ),
			$cap,
			$slug,
			[$this, 'render_dashboard'],
		);

		add_submenu_page(
			$slug,
			__( 'All Rules', 'content-restriction' ),
			__( 'All Rules', 'content-restriction' ),
			$cap,
			$slug . '#/rules',
			[$this, 'render_dashboard'],
		);

		add_submenu_page(
			$slug,
			__( 'Create Rule', 'content-restriction' ),
			__( 'Create Rule', 'content-restriction' ),
			$cap,
			$slug . '#/rule',
			[$this, 'render_dashboard'],
		);

		add_submenu_page(
			$slug,
			__( 'Integrations', 'content-restriction' ),
			__( 'Integrations', 'content-restriction' ),
			$cap,
			$slug . '#/integrations',
			[$this, 'render_dashboard'],
		);

		if ( ! defined( 'CONTENT_RESTRICTION_PRO_VERSION' ) ) {
			add_submenu_page(
				$slug,
				__( 'Upgrade', 'content-restriction' ),
				__( 'Upgrade', 'content-restriction' ),
				$cap,
				$slug . '-upgrade-to-pro',
				[$this, 'render_admin_dashboard']
			);

			// Rewrite the menu item.
			global $submenu;
			$submenu[$slug][4][2] = 'https://contentrestriction.com/pricing/';
		}
	}

	public function render_dashboard(): void {
		include_once 'Views/dashboard.php';
	}
}