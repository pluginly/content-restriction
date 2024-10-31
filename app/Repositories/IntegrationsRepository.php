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
				'title'     => __( 'WooCommerce', 'content-restriction' ),
				'icon'      => 'WooCommerce',
				'details'   => 'Personalize the customer shopping experience with dynamic content based on store-specific rules, such as cart rules, product rules, and customer history. You can show upsells, product recommendations, hide specific content, or display personalized messaging.',
				'plugin'    => 'woocommerce/woocommerce.php',
				'key'       => 'woocommerce',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/woocommerce/',
			],
			[
				'title'     => __( 'Directorist', 'content-restriction' ),
				'icon'      => 'Directorist',
				'details'   => 'Personalize directory listings for users by conditionally displaying or hiding information, such as location, contact details, and more.',
				'plugin'    => 'directorist/directorist-base.php',
				'key'       => 'directorist',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/directorist/',
			],
			[
				'title'     => __( 'FluentCRM', 'content-restriction' ),
				'icon'      => 'FluentCRM',
				'details'   => 'Dynamically display or hide content based on data from funnel stages or marketing automation triggers, such as an LMS course completion success banner, rewarding user, and more.',
				'plugin'    => 'fluent-crm/fluent-crm.php',
				'key'       => 'fluent_crm',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/fluentcrm/',
			],
			[
				'title'     => __( 'Login Me Now', 'content-restriction' ),
				'icon'      => 'LoginMeNow',
				'details'   => "Hide specific content or display personalized messaging based on the user's login method.",
				'plugin'    => 'login-me-now/login-me-now.php',
				'key'       => 'login_me_now',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/login-me-now/',
			],
			[
				'title'     => __( 'Easy Digital Downloads', 'content-restriction' ),
				'icon'      => 'EasyDigitalDownloads',
				'details'   => 'Display dynamic content based on store-specific rules, including cart rules, customer history, and product rules. You can show upsells, product recommendations, hide specific content, or display personalized messaging.',
				'plugin'    => 'easy-digital-downloads/easy-digital-downloads.php',
				'key'       => 'easy_digital_downloads',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/easy-digital-downloads/',
			],
			[
				'title'     => __( 'Block Editor', 'content-restriction' ),
				'icon'      => 'BlockEditor',
				'details'   => 'Apply custom visibility rules for blocks, creating a more dynamic content experience.',
				'plugin'    => '#',
				'key'       => 'block_editor',
				'badges'    => ['upcoming'],
				'status'    => false,
				'installed' => false,
			],
			[
				'title'     => __( 'Elementor', 'content-restriction' ),
				'icon'      => 'Elementor',
				'details'   => 'Tailor visibility settings for Elementor widgets, sections, and pages based on user roles.',
				'plugin'    => 'elementor/elementor.php',
				'key'       => 'elementor',
				'badges'    => ['upcoming'],
				'status'    => false,
				'installed' => false,
			],
			[
				'title'     => __( 'BuddyPress', 'content-restriction' ),
				'icon'      => 'BuddyPress',
				'details'   => 'Control access to BuddyPress social features, including profiles and groups.',
				'plugin'    => 'buddypress/bp-loader.php',
				'key'       => 'buddypress',
				'badges'    => ['upcoming'],
				'status'    => false,
				'installed' => false,
			],
			[
				'title'     => __( 'Tutor LMS', 'content-restriction' ),
				'icon'      => 'TutorLMS',
				'details'   => 'Customize the visibility of courses, lessons, and quizzes for tailored learning paths.',
				'plugin'    => 'tutor/tutor.php',
				'key'       => 'tutor_lms',
				'badges'    => ['upcoming'],
				'status'    => false,
				'installed' => false,
			],
			[
				'title'     => __( 'WooCommerce Subscriptions', 'content-restriction' ),
				'icon'      => 'WooCommerce',
				'details'   => 'Create customizable membership levels, restrict access to content based on membership status, and handle recurring subscriptions effortlessly.',
				'plugin'    => 'woocommerce/woocommerce.php',
				'key'       => 'woocommerce_subscriptions',
				'badges'    => [],
				'status'    => false,
				'installed' => false,
				'link'      => 'https://contentrestriction.com/integration/woocommerce/',
			],
		];
	}

	private static function get_icon( string $module ) {
		return CONTENT_RESTRICTION_IMAGES . "{$module}.svg?" . CONTENT_RESTRICTION_VERSION;
	}
}