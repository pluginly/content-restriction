<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\LoginBack;

class LoginBack extends \ContentRestriction\Common\RestrictViewBase {

	public $current_url;

	public function __construct( $who_can_see, $what_content, array $rule ) {
		$this->type         = 'restrict-view';
		$this->module       = 'login_back';
		$this->rule            = $rule;
		$this->who_can_see  = $who_can_see;
		$this->what_content = $what_content;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->protection   = new Protection( $what_content, $this->options, $this->rule );
	}

	public function boot(): void {
		if ( is_user_logged_in() ) {
			return;
		}

		\ContentRestriction\Utils\Analytics::add( [
			'user_id' => 0,
			'context' => 'locked',
			'id'      => $this->rule['id'],
		] );

		add_action( 'content_restriction_template_redirect', [$this, 'redirect'] );
		add_action( 'content_restriction_register_url', [$this, 'register_url'] );

		$this->current_url = $this->current_url();
	}

	public function redirect( $post_id ) {
		if ( is_archive() || is_home() ) {
			return;
		}

		$this->protection->set_post_id( get_the_ID() );

		if ( ! $this->protection->is_needed() ) {
			return;
		}

		$url = wp_login_url( $this->current_url() );
		if ( $url ) {
			wp_redirect( $url );
			exit;
		}
	}

	private function current_url() {
		$protocol = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) || 443 === $_SERVER['SERVER_PORT'] ? 'https://' : 'http://';

		return $protocol . sanitize_text_field( $_SERVER['HTTP_HOST'] ) . sanitize_text_field( $_SERVER["REQUEST_URI"] );
	}

	public function register_url( $str ) {
		return site_url( "wp-login.php?action=register&redirect_to={$this->current_url}", 'login' );
	}
}