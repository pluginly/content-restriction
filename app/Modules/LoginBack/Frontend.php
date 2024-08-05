<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\LoginBack;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'       => __( 'Login & Back', 'content-restriction' ),
			'key'        => 'login_back',
			'icon'       => $this->get_icon( 'LoginBack' ),
			'desc'       => __( 'Redirect back to the current post or page after the user logged in.', 'content-restriction' ),
			// 'conditions' => apply_filters(
			// 	'content_restriction_module_login_and_back_conditions',
			// 	[
			// 		'who_can_see' => [
			// 			'user_not_logged_in',
			// 		],
			// 		'compare'     => 'has_any',
			// 	],
			// ),
		];

		return $modules;
	}
}