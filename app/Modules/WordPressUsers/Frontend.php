<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\WordPressUsers;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'    => __( 'User Role', 'content-restriction' ),
			'key'     => 'selected_roles',
			'icon'    => $this->get_icon( 'WordPress' ),
			'url'     => 'https://wordpress.org/plugins/wordpress-users/',
			'desc'    => __( 'Select who should have access to the content.', 'content-restriction' ),
			'type'    => 'section',
			'group'   => 'wordpress',
			'options' => [
				'roles' => [
					'title'   => __( 'Select Roles', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->role_list(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'User Name', 'content-restriction' ),
			'key'     => 'selected_users',
			'icon'    => $this->get_icon( 'WordPress' ),
			'url'     => 'https://wordpress.org/plugins/wordpress-users/',
			'desc'    => __( 'Select who should have access to the content.', 'content-restriction' ),
			'type'    => 'section',
			'group'   => 'wordpress',
			'options' => [
				'users' => [
					'title'   => __( 'Select Users', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->user_list(),
				],
			],
		];

		$modules[] = [
			'name'  => __( 'Logged In User', 'content-restriction' ),
			'key'   => 'user_logged_in',
			'icon'  => $this->get_icon( 'WordPress' ),
			'desc'  => __( 'Only logged in user should have access to the content.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		$modules[] = [
			'name'  => __( 'Logged Out User', 'content-restriction' ),
			'key'   => 'user_not_logged_in',
			'icon'  => $this->get_icon( 'WordPress' ),
			'desc'  => __( 'Only logged out user should have access to the content.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		return $modules;
	}

	public function role_list() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles();
		}

		$role_names = $wp_roles->get_names();

		return $role_names;
	}

	public function user_list(): array {
		$users   = get_users( ['fields' => ['id', 'user_login']] );
		$options = [];

		foreach ( $users as $user ) {
			$options[$user->ID] = $user->user_login;
		}

		return $options;
	}
}