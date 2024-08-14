<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Controllers;

use ContentRestriction\Repositories\RuleRepository;
use ContentRestriction\Utils\Response;
use WP_REST_Request;

class RuleController {
	public function create( WP_REST_Request $request ) {
		$data = (array) $request->get_param( 'data' );

		$errors = [];
		if ( empty( $data ) ) {
			$errors['empty_data'] = __( 'Empty data is provided.', 'content-restriction' );
		}

		if ( ! isset( $data['rule'] ) ) {
			$errors['rule_data_missing'] = __( 'Rule data is missing.', 'content-restriction' );
		}

		if ( ! isset( $data['title'] ) ) {
			$errors['title_missing'] = __( 'Rule title is missing.', 'content-restriction' );
		}

		if ( ! empty( $errors ) ) {
			return Response::error(
				'rule_data_invalid',
				$errors,
				'rules/create',
				422
			);
		}

		return Response::success(
			( new RuleRepository() )->create( $data )
		);
	}

	public function read( WP_REST_Request $request ) {
		$id = (string) $request->get_param( 'id' );

		if ( empty( $id ) ) {
			return Response::error(
				'invalid_id',
				__( 'Invalid Rule ID is provided.', 'content-restriction' ),
				'rules/read',
				404
			);
		}

		return Response::success(
			( new RuleRepository() )->read(
				$id
			)
		);
	}

	public function update( WP_REST_Request $request ) {
		$id = (string) $request->get_param( 'id' );
		$data    = (array) $request->get_param( 'data' );

		$errors = [];

		if ( empty( $id ) ) {
			$errors['id'] = __( 'Invalid Rule ID is provided.', 'content-restriction' );
		}

		if ( empty( $data ) ) {
			$errors['data'] = __( 'Invalid data is provided.', 'content-restriction' );
		}

		if ( ! isset( $data['rule'] ) ) {
			$errors['rule_data_missing'] = __( 'Rule data is missing.', 'content-restriction' );
		}

		if ( ! isset( $data['title'] ) ) {
			$errors['title_missing'] = __( 'Rule title is missing.', 'content-restriction' );
		}

		if ( ! empty( $errors ) ) {
			return Response::error(
				'rule_update_required_fields_missing',
				$errors,
				'rules/update',
				422
			);
		}

		return Response::success(
			( new RuleRepository() )->update(
				$id, $data
			)
		);
	}

	public function delete( WP_REST_Request $request ) {
		$id = (string) $request->get_param( 'id' );

		if ( empty( $id ) ) {
			return Response::error(
				'invalid_id',
				__( 'Invalid Rule ID is provided.', 'content-restriction' ),
				'rules/delete',
				422
			);
		}

		return Response::success(
			( new RuleRepository() )->delete(
				$id
			)
		);
	}

	public function list() {
		return Response::success(
			( new RuleRepository() )->get_all()
		);
	}
}