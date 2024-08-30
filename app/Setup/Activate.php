<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Setup;

class Activate {
	public function __construct( $file_name ) {
		$this->auto_deactivate( $file_name );
		add_option( '_content_restriction_redirect_to_dashboard', true );
		add_option( '_content_restriction_activation_time', time() );

		DBMigrator::run();
	}

	public function auto_deactivate( $file_name ): void {
		if ( Compatibility::php() ) {
			return;
		}

		deactivate_plugins( basename( $file_name ) );

		$error = sprintf( '<h1>%s</h1>', esc_html__( 'An Error Occurred', 'content-restriction' ) );
		$error .= sprintf( '<h2>%s %s</h2>', esc_html__( 'Your installed PHP Version is: ', 'content-restriction' ), PHP_VERSION );
		$error .= esc_html__( '<p>The <strong>All in One Content Restriction</strong> plugin requires PHP version <strong>', 'content-restriction' ) . Config::get( 'min_php' ) . __( '</strong> or greater', 'content-restriction' );
		$error .= esc_html__( '<p>The version of your PHP is ', 'content-restriction' ) . '<a href="http://php.net/supported-versions.php" target="_blank"><strong>' . __( 'unsupported and old', 'content-restriction' ) . '</strong></a>.';
		$error .= esc_html__( 'You should update your PHP software or contact your host regarding this matter.</p>', 'content-restriction' );
		wp_die(
			wp_kses_post( $error ),
			esc_html__( 'Plugin Activation Error', 'content-restriction' ),
			[
				'response'  => 200,
				'back_link' => true,
			]
		);
	}
}