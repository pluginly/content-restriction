<?php
/**
 * @package ContentRestriction
 * @since   1.4.0
 * @version 1.4.0
 */

namespace ContentRestriction\Modules\Shortcode;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_what_content_module_list', [$this, 'list'] );

		/**
		 * Overriding the condition check for shortcode module.
		 */
		add_filter( 'content_restriction_module_condition_check_before', [$this, 'before_condition_check'], 10, 2 );

	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'  => __( 'Shortcode', 'content-restriction' ),
			'key'   => 'shortcode',
			'icon'  => $this->get_icon( 'WordPress' ),
			'desc'  => __( 'All the shortcode area will be accessible when the set rule is applied.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		return $modules;
	}

	public function before_condition_check( array $module, \WP_REST_Request $request ): array {

		$param_value = $request->get_param( 'what_content' );

		if ( 'shortcode' === $param_value ) {

			if ( isset( $module['key'] ) ) {

				if ( 'replace' === $module['key'] ) {
					$module['options']['shortcode_content'] = $module['options']['content'];

					unset( $module['options']['title'] );
					unset( $module['options']['excerpt'] );
					unset( $module['options']['content'] );
					unset( $module['conditions'] );

				} elseif ( 'blur' === $module['key'] ) {
					error_log( 'blur : ' . print_r( $module, true ) );
					unset( $module['options']['apply_to'] );
				} elseif ( 'randomize' === $module['key'] ) {
					error_log( 'randomize : ' . print_r( $module, true ) );
				} elseif ( 'login_back' === $module['key'] ) {
					error_log( 'login_back : ' . print_r( $module, true ) );
				} elseif ( 'redirection' === $module['key'] ) {
					error_log( 'redirection : ' . print_r( $module, true ) );

				}

			}
		}

		return $module;
	}
}