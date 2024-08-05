<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Config {
	private static array $file_data = [];
	public static function get( string $key ): string {
		if ( ! self::$file_data ) {
			self::file();
		}

		return self::$file_data[$key] ?? self::default( $key );
	}

	private static function file(): void {
		$path = __DIR__ . '/../../';
		$prod = $path . '/config.php';
		$dev  = $path . "/config.dev.php";

		if ( ! \file_exists( $prod ) ) {
			return;
		}

		self::$file_data = ( require_once $prod );
		if ( \file_exists( $dev ) ) {
			self::$file_data = ( require_once $dev );
		}
	}

	private static function default( string $key ): string {
		$arr = ['project_key' => 'dynamic_project', 'key_prefix' => '_', 'key_suffix' => '_'];

		return $arr[$key] ?? '';
	}
}