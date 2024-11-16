<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Replace;

use ContentRestriction\Utils\Analytics;

class Replace extends \ContentRestriction\Common\RestrictViewBase {

	public function __construct( $who_can_see, $what_content, array $rule ) {
		$this->type         = 'restrict-view';
		$this->module       = 'replace';
		$this->rule         = $rule;
		$this->who_can_see  = $who_can_see;
		$this->what_content = $what_content;
		$this->options      = $rule['rule'][$this->type][$this->module] ?? [];
		$this->protection   = new Protection( $what_content, $this->options, $rule );
	}

	/**
	 * Initializes content restriction checks and applies modifications as needed.
	 */
	public function boot(): void {
		// Exit early if the current user has access to the restricted content
		$who_can_see = new $this->who_can_see( $this->rule );
		if ( $who_can_see->has_access() ) {
			return;
		}

		// Log that the user encountered restricted content
		Analytics::add( [
			'user_id' => get_current_user_id(),
			'context' => 'locked',
			'id'      => $this->rule['id'],
		] );

		/**
		 * Allow developers to intervene before applying content replacement,
		 * using the 'content_restriction_replace_before' filter. If any
		 * callback returns false, stop further processing.
		 *
		 * @param bool  $continue Whether to proceed with content replacement.
		 * @param self  $this     Current instance of the restriction handler.
		 */
		if ( ! apply_filters( 'content_restriction_replace_before', true, $this ) ) {
			return;
		}

		// Attach filters to modify restricted content areas as specified by the rule
		add_filter( 'content_restriction_the_title', [$this, 'modify_content'], 10 );
		add_filter( 'content_restriction_the_excerpt', [$this, 'modify_content'], 1 );
		add_filter( 'content_restriction_the_content', [$this, 'modify_content'], 10 );
	}

	public function modify_content( $content ): string {
		$this->protection->set_post_id( get_the_ID() ?: 0 );

		$type = '';

		switch ( current_filter() ) {
			case 'content_restriction_the_title':
				$type = 'title';
				break;
			case 'content_restriction_the_excerpt':
				$type = 'excerpt';
				break;
			case 'content_restriction_the_content':
				$type = 'content';
				break;
		}

		$override = (string) isset( $this->options[$type] ) ? $this->options[$type] : '';

		return ! empty( $override ) ? $this->protection->add( $content, $override ) : $content;
	}
}