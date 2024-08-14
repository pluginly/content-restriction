<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Repositories;

use ContentRestriction\DTO\RuleCreateDTO;
use ContentRestriction\Models\RuleModel;
use ContentRestriction\Utils\Options;
use ContentRestriction\Utils\Random;
use ContentRestriction\Utils\Time;

class RuleRepository {
	private string $option;
	private array $rules;

	public function __construct() {
		$this->option = 'rules';
		$this->rules  = $this->get_all();
	}

	public function create( array $data ): string {
		$key = Random::key( 16 );
		error_log( print_r( $data, true ) );
		$dto = ( new RuleCreateDTO )
			->set_uid( $key )
			->set_title( sanitize_text_field( $data['title'] ) )
			->set_status( (bool) $data['isPublished'] )
			->set_who_can_see( maybe_serialize( $data['rule']['who-can-see'] ) )
			->set_what_content( maybe_serialize( $data['rule']['what-content'] ) )
			->set_restrict_view( maybe_serialize( $data['rule']['restrict-view'] ) )
			->set_priority( 1 );

		try {
			( new RuleModel() )->create( $dto );

			return $key;
		} catch ( \Throwable $th ) {
			return 0;
		}
	}

	public function read( string $id ): array {
		foreach ( $this->rules as $key => $value ) {
			if ( $value['id'] === $id ) {
				return $this->rules[$key];
			}
		}

		return [];
	}

	public function update( string $id, array $data ): bool {
		foreach ( $this->rules as $key => $rule ) {
			if ( $rule['id'] === $id ) {
				$data['id']       = $id;
				$data['modified'] = Time::now();

				$this->rules[$key] = $data;

				$json = wp_json_encode( array_values( $this->rules ) );

				Options::set( $this->option, $json );

				return true;
			}
		}

		return false;
	}

	public function delete( string $id ): bool {
		foreach ( $this->rules as $key => $r ) {
			if ( $r['id'] === $id ) {
				unset( $this->rules[$key] );

				$json = wp_json_encode( array_values( $this->rules ) );

				Options::set( $this->option, $json );

				return true;
			}
		}

		return false;
	}

	public function set( string $key, array $data ): bool {
		$data['id']       = $key;
		$data['modified'] = Time::now();

		$this->rules[] = $data;

		$json = wp_json_encode( $this->rules );

		return Options::set( $this->option, $json );
	}

	public function get_all(): array {
		$rules = ( new RuleModel )->get_all();

		$rules = array_map(
			function ( $rule ) {
				$rule['rule']['who-can-see']   = maybe_unserialize( $rule['who_can_see'] );
				$rule['rule']['what-content']  = maybe_unserialize( $rule['what_content'] );
				$rule['rule']['restrict-view'] = maybe_unserialize( $rule['restrict_view'] );

				unset( $rule['who_can_see'] );
				unset( $rule['what_content'] );
				unset( $rule['restrict_view'] );

				return $rule;
			},
			$rules
		);

		return ! empty( $rules ) ? $rules : [];
	}

	public function get_all_(): array {
		if ( isset( $this->rules ) ) {
			return $this->rules;
		}

		$json = Options::get( $this->option );
		$arr  = json_decode( stripslashes( stripslashes( $json ) ), true );

		return ! empty( $arr ) ? array_values( $arr ) : [];
	}
}