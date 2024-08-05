<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.1.0
 */
namespace ContentRestriction\Utils;

class Random {
	public static function number( int $len = 16 ): int {
		return \wp_rand( 1000000000000000, 9999999999999999 );
	}

	public static function key( int $len = 40 ): string {
		$characters = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTWYXZ";
		$key        = '';
		for ( $i = 0; $i < $len; $i++ ) {
			$key .= $characters[\wp_rand( 0, $len )];
		}

		return $key;
	}

	public static function string( int $len = 40 ): string {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$key        = '';
		for ( $i = 0; $i < $len; $i++ ) {
			$key .= $characters[\wp_rand( 0, $len )] ?? ' ';
		}

		return $key;
	}

	public static function randomize( $content ) {
		$return  = '';
		$pattern = '/\s+(\w+)\s*=\s*"[^"]*"/';

		preg_match_all( $pattern, $content, $attributeMatches );
		$attributeMatches         = $attributeMatches[0] ?? [];
		$contentWithoutAttributes = preg_replace( $pattern, ' ATTRIBUTE_PLACEHOLDER', $content );
		$chars                    = preg_split( '/ /', $contentWithoutAttributes, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );

		foreach ( $chars as $key => $value ) {
			/**
			 * Replace with original attr
			 */
			foreach ( $attributeMatches as $key => $attributeMatch ) {
				if ( strpos( $value, 'ATTRIBUTE_PLACEHOLDER' ) !== false ) {
					$return .= ' ' . str_replace( 'ATTRIBUTE_PLACEHOLDER', $attributeMatch, $value ) . ' ';
					unset( $attributeMatches[$key] );
					continue 2;
				}
			}

			/**
			 * Skip whether it's a HTML tag
			 */
			if ( strpos( $value, '<' ) !== false || strpos( $value, '/>' ) !== false ) {
				$return .= $value . ' ';
				continue;
			}

			/**
			 * Skip whether it's not more than 4 chars
			 */
			$len = strlen( $value );
			if ( $len < 4 ) {
				$return .= $value . ' ';
				continue;
			}

			/**
			 * Only randomize when above conditions are not met
			 */
			$return .= self::length_words( $len ) . ' ';
		}

		return trim( $return );
	}

	public static function length_words( int $length ) {
		$strings = [
			'4'  => 'looks wow!',
			'5'  => 'apple',
			'6'  => 'banana',
			'7'  => 'cherry',
			'8'  => 'dolphins',
			'9'  => 'elephants',
			'10' => 'butterflies',
			'11' => 'alligators',
			'12' => 'chocolates',
			'13' => 'strawberries',
			'14' => 'hippopotamus',
			'15' => 'characteristic',
			'16' => 'responsibility',
		];

		return $strings[$length] ?? 'unwanted';
	}
}