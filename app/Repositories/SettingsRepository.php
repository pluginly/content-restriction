<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Repositories;

use ContentRestriction\Utils\Options;

class SettingsRepository {
	private static array $settings;
	private static string $key = 'settings';
	public static function all(): array {
		if ( ! isset( self::$settings ) ) {
			self::$settings = Options::get( self::$key, [] );
		}

		return self::$settings;
	}

	public static function get( string $key ) {
		return self::all()[$key] ?? '';
	}

	public static function update_batch( array $array ): bool {
		$settings = self::all();

		foreach ( $array as $key => $data ) {
			if ( ! self::validate_type( $key, $data ) ) {
				continue;
			}

			$settings[$key] ??= '';
			$settings[$key] = $data;
		}

		return Options::set( self::$key, $settings );
	}

	private static function validate_type( string $key, $value ): bool {
		$type = self::get_type( $key );

		if ( 'string' === $type ) {
			return is_string( $value );
		}

		if ( 'array' === $type ) {
			return is_array( $value );
		}

		if ( 'bool' === $type ) {
			return is_bool( $value );
		}

		if ( 'integer' === $type ) {
			return is_integer( $value );
		}

		return false;
	}

	private static function get_type( string $key ): string {
		$fields = self::get_fields();

		foreach ( $fields as $section => $field ) {
			if ( isset( $field[$key]['type'] ) ) {
				return $field[$key]['type'];
			}
		}

		return '';
	}

	public static function get_fields() {
		return apply_filters(
			'content_restriction_fields', [
				'general' => self::general_fields(),
				'license' => self::license_fields(),
				'tools'   => self::tools_fields(),
			]
		);
	}

	private static function license_fields() {
		return [
			'license_key' => [
				'type' => 'string',
				'html' => [
					'type'        => 'text',
					'placeholder' => __( 'Please entire your valid license key', 'content-restriction' ),
					'label'       => __( 'License Key', 'content-restriction' ),
				],
			],
		];
	}

	private static function general_fields() {
		return [
			'general_key'   => [
				'type'  => 'string',
				'label' => __( 'General Setting Key', 'content-restriction' ),
			],
			'general_key_2' => [
				'type'  => 'string',
				'label' => __( 'General Setting Key 2', 'content-restriction' ),
			],
			'general_key_3' => [
				'type'  => 'string',
				'label' => __( 'General Setting Key 3', 'content-restriction' ),
			],
			'general_key_4' => [
				'type'  => 'string',
				'label' => __( 'General Setting Key 4', 'content-restriction' ),
			],
		];
	}

	private static function tools_fields() {
		return [
			'export_rules' => [
				'type' => 'string',
				'html' => [
					'type'        => 'file',
					'placeholder' => __( 'Export', 'content-restriction' ),
					'label'       => __( 'Export Rules', 'content-restriction' ),
				],
			],
			'import_rules' => [
				'type' => 'string',
				'html' => [
					'type'        => 'file',
					'placeholder' => __( 'Import', 'content-restriction' ),
					'label'       => __( 'Import Rules', 'content-restriction' ),
				],
			],
		];
	}
}