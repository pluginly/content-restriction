<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Repositories;

use ContentRestriction\Utils\Options;
use ContentRestriction\Utils\Plugin;

class SettingsRepository {
	private static array $settings;
	private static string $key = 'settings';
	public static function all(): array {
		if ( ! isset( self::$settings ) ) {
			self::$settings = Options::get( self::$key, [] );
		}

		return self::$settings;
	}

	public static function get( string $key ) {
		return self::all()[$key] ?? '';
	}

	public static function update( string $key, $value ): bool {
		$settings = self::all();
		$settings[$key] ??= '';
		$settings[$key] = $value;

		return Options::set( self::$key, $settings );
	}

	public static function integrations() {
		$settings = self::all();
		$arr      = self::get_integrations();
		foreach ( $arr as $key => $i ) {
			$arr[$key]['icon']      = self::get_icon( $i['icon'] );
			$arr[$key]['installed'] = Plugin::is_active( $i['plugin'] );
			$arr[$key]['status']    = $settings[$i['key']] ?? false;
		}

		return $arr;
	}

	private static function get_integrations() {
		return [
			[
				'title'     => __( 'WooCommerce', 'content-restriction' ), // integration name
				'icon'      => 'WooCommerce', // icon of this plugin
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.', // a link to know more about the integration
				'plugin'    => 'woocommerce/woocommerce.php', // the plugin filename to check is it installed? if not we will don't allow to activate this module
				'key'       => 'woocommerce', // we will save the setting using this key
				'badges'    => [ // we will serve badges like - is pro , upcoming
					'free', // check if pro plugin installed or not, if installed remove the pro badge
				],
				'status'    => false, // status of this setting
				'installed' => false, // check whether plugin installed? if not then don't allow to trigger the option
				'link'      => '#',
			],
			[
				'title'     => __( 'Directorist', 'content-restriction' ),
				'icon'      => 'Directorist',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'directorist/directorist-base.php',
				'key'       => 'directorist',
				'badges'    => [
					'premium',
				],
				'installed' => false,
				'status'    => false,
				'action'    => 'upgrade',
			],
			[
				'title'     => __( 'FluentCRM', 'content-restriction' ),
				'icon'      => 'FluentCRM',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'fluent-crm/fluent-crm.php',
				'key'       => 'fluent_crm',
				'badges'    => [
					'free',
				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'Login Me Now', 'content-restriction' ),
				'icon'      => 'LoginMeNow',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'login-me-now/login-me-now.php',
				'key'       => 'login_me_now',
				'badges'    => [
					'free',
				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'Easy Digital Downloads', 'content-restriction' ),
				'icon'      => 'EasyDigitalDownloads',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'easy-digital-downloads/easy-digital-downloads.php',
				'key'       => 'easy_digital_downloads',
				'badges'    => [
					'premium',
				],
				'installed' => false,
				'status'    => false,
				'action'    => 'upgrade',
			],
			[
				'title'     => __( ' Easy Digital Downloads - All Access', 'content-restriction' ),
				'icon'      => 'EasyDigitalDownloads',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'edd-all-access/edd-all-access.php',
				'key'       => 'easy_digital_downloads_all_access',
				'badges'    => [
					'premium',
				],
				'installed' => false,
				'status'    => false,
				'action'    => 'upgrade',
			],
			[
				'title'     => __( 'Block Editor', 'content-restriction' ),
				'icon'      => 'BlockEditor',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => '#',
				'key'       => 'block_editor',
				'badges'    => [
					'upcoming',
				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'Elementor', 'content-restriction' ),
				'icon'      => 'Elementor',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'elementor/elementor.php',
				'key'       => 'elementor',
				'badges'    => [
					'upcoming',
				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'BuddyPress', 'content-restriction' ),
				'icon'      => 'BuddyPress',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'buddypress/bp-loader.php',
				'key'       => 'buddypress',
				'badges'    => [
					'upcoming',
				],
				'installed' => false,
				'status'    => false,
			],
		];
	}

	private static function get_icon( string $module ) {
		return CONTENT_RESTRICTION_IMAGES . "{$module}.svg?" . CONTENT_RESTRICTION_VERSION;
	}
}