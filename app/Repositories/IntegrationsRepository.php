<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Repositories;

use ContentRestriction\Utils\Plugin;

class IntegrationsRepository {

	public static function get_all() {
		$arr = self::integrations();
		foreach ( $arr as $key => $i ) {
			$arr[$key]['icon']      = self::get_icon( $i['icon'] );
			$arr[$key]['installed'] = Plugin::is_active( $i['plugin'] );
		}

		return $arr;
	}

	private static function integrations() {
		return [
			[
				'title'     => __( 'WooCommerce', 'content-restriction' ), // integration name
				'icon'      => 'WooCommerce', // icon of this plugin
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.', // a link to know more about the integration
				'plugin'    => 'woocommerce/woocommerce.php', // the plugin filename to check is it installed? if not we will don't allow to activate this module
				'key'       => 'woocommerce', // we will save the setting using this key
				'badges'    => [ // we will serve badges like - is pro , upcoming
					// check if pro plugin installed or not, if installed remove the pro badge
				],
				'status'    => false, // status of this setting
				'installed' => false, // check whether plugin installed? if not then don't allow to trigger the option
			],
			[
				'title'     => __( 'Directorist', 'content-restriction' ),
				'icon'      => 'Directorist',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'directorist/directorist-base.php',
				'key'       => 'directorist',
				'badges'    => [

				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'FluentCRM', 'content-restriction' ),
				'icon'      => 'FluentCRM',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'fluent-crm/fluent-crm.php',
				'key'       => 'fluent_crm',
				'badges'    => [

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

				],
				'installed' => false,
				'status'    => false,
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
			[
				'title'     => __( 'Tutor LMS', 'content-restriction' ),
				'icon'      => 'TutorLMS',
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.',
				'plugin'    => 'buddypress/bp-loader.php',
				'key'       => 'buddypress',
				'badges'    => [
					'upcoming',
				],
				'installed' => false,
				'status'    => false,
			],
			[
				'title'     => __( 'WooCommerce Subscriptions', 'content-restriction' ), // integration name
				'icon'      => 'WooCommerce', // icon of this plugin
				'details'   => 'Check out this incredibly useful plugin that will compress and optimize your images, giving you leaner, faster websites.', // a link to know more about the integration
				'plugin'    => 'woocommerce/woocommerce.php', // the plugin filename to check is it installed? if not we will don't allow to activate this module
				'key'       => 'woocommerce-subscriptions', // we will save the setting using this key
				'badges'    => [
					'upcoming',
				],
				'status'    => false, // status of this setting
				'installed' => false, // check whether plugin installed? if not then don't allow to trigger the option
			],
		];
	}

	private static function get_icon( string $module ) {
		return CONTENT_RESTRICTION_IMAGES . "{$module}.svg?" . CONTENT_RESTRICTION_VERSION;
	}
}