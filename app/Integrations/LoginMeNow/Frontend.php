<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\LoginMeNow;

class Frontend extends \ContentRestriction\Common\IntegrationBase {
	public function boot(): void {
		add_filter( 'content_restriction_module_group_list', [$this, 'add_group'] );
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'who_can_see'] );
	}

	public function add_group( array $groups ): array {
		$groups['login-me-now'] = [
			'title'   => __( 'Login Me Now', 'content-restriction' ),
			'icon'    => $this->get_icon( 'LoginMeNow' ),
			'details' => '#',
		];

		return $groups;
	}

	public function who_can_see( array $modules ): array {
		$modules[] = [
			'name'  => __( 'Facebook Verified', 'content-restriction' ),
			'key'   => 'login_me_now_facebook_verified',
			'group' => 'login-me-now',
			'meta'  => ['list', 'subscribed', 'fluent crm', 'fluentCRM', 'subscriber', 'fluent crm', 'mailing list', 'marketing'],
			'icon'  => $this->get_icon( 'LoginMeNow' ),
			'desc'  => __( 'Facebook verified user should have access to the content.', 'content-restriction' ),
		];

		$modules[] = [
			'name'  => __( 'Google Verified', 'content-restriction' ),
			'key'   => 'login_me_now_google_verified',
			'group' => 'login-me-now',
			'meta'  => ['list', 'subscribed', 'fluent crm', 'fluentCRM', 'subscriber', 'fluent crm', 'mailing list', 'marketing'],
			'icon'  => $this->get_icon( 'LoginMeNow' ),
			'desc'  => __( 'Google verified user should have access to the content.', 'content-restriction' ),
			'type'  => 'section',
		];

		return $modules;
	}
}