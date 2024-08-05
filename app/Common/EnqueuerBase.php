<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

use ContentRestriction\Utils\Config;

abstract class EnqueuerBase {
	use Hookable;

	public function __construct() {
		$this->action( 'wp_enqueue_scripts', 'wp_register_scripts', 12 );
		$this->action( 'wp_enqueue_scripts', 'wp_enqueue_scripts', 15 );
		$this->action( 'admin_enqueue_scripts', 'admin_enqueue_scripts' );
		$this->action( 'admin_enqueue_scripts', 'admin_register_scripts' );
	}

	public function admin_register_scripts(): void {

	}

	public function admin_enqueue_scripts(): void {

	}

	public function wp_register_scripts(): void {

	}

	public function wp_enqueue_scripts(): void {

	}

	public function register_style( string $handle, string $src, array $deps ): void {
		wp_register_style( $handle, $src, $deps, Config::get( 'version' ) );
	}

	public function enqueue_style( string $handle ): void {
		wp_enqueue_style( $handle );
	}

	public function register_script( string $handle, string $src, array $deps, array $args = [] ): void {
		wp_register_script( $handle, $src, $deps, Config::get( 'version' ), $args );
	}

	public function enqueue_script( string $handle ): void {
		wp_enqueue_script( $handle );
	}
}