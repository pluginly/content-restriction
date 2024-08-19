<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EDDAllAccessPass;

class AllAccessPass extends \ContentRestriction\Common\WhoCanSeeBase {

	public function __construct( array $rule ) {
		$this->type         = 'who-can-see';
		$this->current_user = wp_get_current_user();
		$this->user_id      = $this->current_user->ID;
	}

	public function give_access(): bool {
		$customer = new \EDD_Customer( $this->current_user->ID, true );
		if ( 0 === $customer->id ) {
			return false;
		}

		$customer_all_access_passes = edd_all_access_get_customer_passes( $customer );

		if ( empty( $customer_all_access_passes ) || ! is_array( $customer_all_access_passes ) ) {
			return false;
		}

		return true;
	}
}