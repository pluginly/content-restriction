<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

abstract class IntegrationHide {
	public array $options;
	public string $then_type;
	public array $then_types;
	public string $post_type;
	public int $post_id;

	public function __construct() {
		$this->post_id = get_the_ID();
		add_action( 'content_restriction_module_hide', [$this, 'hide'], 10, 4 );
		add_action( 'content_restriction_template_redirect', [$this, 'single_view_hide'] );
	}

	private function redirect_to_home() {
		wp_redirect( home_url() );
		exit;
	}
}