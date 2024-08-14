<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\FluentCRM;

class Subscriber extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $r ) {
		$this->type         = 'who-can-see';
		$this->module       = 'fluent_crm_subscriber';
		$this->r            = $r;
		$this->options      = $this->r['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		if ( empty( $this->options['status'] ) ) {
			return false;
		}

		$subscriber = FluentCrmApi( 'contacts' )->getContactByUserId( $this->current_user->ID );
		if ( ! $subscriber ) {
			return false;
		}

		return in_array( $subscriber->status, $this->options['status'] );
	}
}