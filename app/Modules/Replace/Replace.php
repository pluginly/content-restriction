<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Replace;

class Replace extends \ContentRestriction\Common\RestrictViewBase {

	public function __construct( $who_can_see, $then, array $r ) {
		$this->type        = 'restrict-view';
		$this->module      = 'replace';
		$this->r           = $r;
		$this->who_can_see = $who_can_see;
		$this->then        = $then;
		$this->options     = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->protection  = new Protection( $then, $this->options, $this->r );
	}

	public function boot(): void {
		$if = ( new $this->who_can_see( $this->r ) );
		if ( $if->has_access() ) {
			return;
		}

		\ContentRestriction\Utils\Analytics::add( [
			'user_id' => get_current_user_id(),
			'context' => 'locked',
			'rule_id' => $this->r['id'],
		] );

		add_filter( 'content_restriction_the_title', [$this, 'the_title'], 10 );
		add_filter( 'content_restriction_the_excerpt', [$this, 'the_excerpt'], 1 );
		add_filter( 'content_restriction_the_content', [$this, 'the_content'] );
	}

	public function the_title( $title ) {
		$this->protection->set_post_id( get_the_ID() );

		$override = $this->apply_to( 'title' );
		if ( ! empty( $override ) ) {
			$title = $this->protection->add( $title, $override );
		}

		return $title;
	}

	public function the_excerpt( $excerpt ) {
		$override = $this->apply_to( 'excerpt' );
		if ( $override ) {
			$excerpt = $this->protection->add( $excerpt, $override );
		}

		return $excerpt;
	}

	public function the_content( $content ) {
		$override = $this->apply_to( 'content' );
		if ( $override ) {
			$content = $this->protection->add( $content, $override );
		}

		return $content;
	}

	private function apply_to( string $t ) {
		if ( isset( $this->options[$t] ) ) {
			return $this->options[$t];
		}

		return '';
	}
}