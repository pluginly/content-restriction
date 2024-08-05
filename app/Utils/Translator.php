<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Translator {
	public static function base64_encode( string ...$items ): string {
		$single = "";
		foreach ( $items as $item ) {
			$single .= $item . " ";
		}

		return \trim( \base64_encode( $single ) );
	}

	public static function base64_decode( string $data ): array {
		$decodedData = \base64_decode( $data );
		$items       = \explode( " ", $decodedData );

		return $items;
	}

	public static function md5( string ...$items ): string {
		$single = "";
		foreach ( $items as $item ) {
			$single .= $item . " ";
		}

		return md5( $single );
	}
}