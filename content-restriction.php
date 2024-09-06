<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name: All-in-One Content Restriction
 * Plugin URI: https://wordpress.org/plugins/content-restriction/
 * Description: Content Restriction - A simple and user-friendly plugin to restrict users / visitors from viewing posts by restricting access, as simple as that.
 * Version: 1.2.0
 * Author: Pluginly
 * Author URI: https://profiles.wordpress.org/pluginly/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 6.6
 * Requires PHP: 7.4
 * Domain Path: /languages
 * Text Domain: content-restriction
 *
 * @package ContentRestriction
 */

require_once __DIR__ . '/vendor/autoload.php';

final class ContentRestriction {
	private static ContentRestriction $instance;

	public static function instance(): ContentRestriction {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function load(): void {
		register_activation_hook(
			__FILE__, function () {
				new ContentRestriction\Setup\Activate( __FILE__ );
			}
		);

		register_deactivation_hook(
			__FILE__, function () {
				new ContentRestriction\Setup\Deactivate();
			}
		);

		$application = \ContentRestriction\Boot\App::instance();
		$application->boot( __FILE__, __DIR__ );

		add_action(
			'plugins_loaded', function () use ( $application ): void {

				do_action( 'content_restriction_before_load' );

				$application->load();

				do_action( 'content_restriction_after_load' );
			},
			99
		);
	}
}

ContentRestriction::instance()->load();