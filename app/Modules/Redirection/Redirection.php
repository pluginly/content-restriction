<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Redirection;

class Redirection extends \ContentRestriction\Common\RestrictViewBase {

	public function __construct( $who_can_see, $what_content, array $rule ) {
		$this->type         = 'restrict-view';
		$this->module       = 'redirection';
		$this->rule            = $rule;
		$this->who_can_see  = $who_can_see;
		$this->what_content = $what_content;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->protection   = new Protection( $what_content, $this->options, $this->rule );
	}

	public function boot(): void {
		$if = ( new $this->who_can_see( $this->rule ) );
		if ( $if->has_access() ) {
			return;
		}

		\ContentRestriction\Utils\Analytics::add( [
			'user_id' => get_current_user_id(),
			'context' => 'locked',
			'id'      => $this->rule['id'],
		] );

		add_action( 'content_restriction_template_redirect', [$this, 'redirect'] );
	}

	public function redirect( $post_id ) {
		if ( is_archive() || is_home() ) {
			return;
		}

		$this->protection->set_post_id( $post_id );

		if ( ! $this->protection->is_needed() ) {
			return;
		}

		$url = $this->options['url'] ?? '';
		if ( $url ) {
			wp_redirect( $url );
			exit;
		}
	}
}