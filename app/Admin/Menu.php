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
	}

	public function render_dashboard(): void {
		include_once 'Views/dashboard.php';
	}
}