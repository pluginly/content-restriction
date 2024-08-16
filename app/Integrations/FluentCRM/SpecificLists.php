<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\FluentCRM;

class SpecificLists extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $rule ) {
		$this->type         = 'who-can-see';
		$this->module       = 'fluent_crm_specific_lists';
		$this->rule            = $rule;
		$this->options      = $this->rule['rule'][$this->type][$this->module] ?? [];
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		if ( empty( $this->options['status'] ) || empty( $this->options['lists'] ) ) {
			return false;
		}

		$subscriber = FluentCrmApi( 'contacts' )->getContactByUserId( $this->current_user->ID );
		if ( ! $subscriber ) {
			return false;
		}

		$status = in_array( $subscriber->status, $this->options['status'] );
		$lists  = $subscriber->lists()->get();
		if ( ! $status || ! $lists ) {
			return false;
		}

		foreach ( $lists as $list ) {
			if ( in_array( $list->id, $this->options['lists'] ) ) {
				return true;
			}
		}

		return false;
	}
}