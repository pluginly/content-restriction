<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

use ContentRestriction\Utils\Config;
use Templatiq\Utils\Response;
use WP_Error;
use WP_REST_Request;
use WP_REST_Server;

abstract class RouteBase {
	protected WP_REST_Request $request;
	protected string $namespace = 'content-restriction';

	public function __construct() {
		add_action( 'rest_api_init', [$this, 'register_routes'] );
	}

	abstract function register_routes(): void;

	public function permission_check( WP_REST_Request $request ) {
		$this->request = $request;

		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}

		if ( 'development' === Config::get( 'environment' ) ) {
			return true;
		}

		return $this->permission_error( '', $request->get_route() );
	}

	protected function permission_error( string $message, $endpoint = '' ) {
		if ( empty( $message ) ) {
			$message = __( 'Sorry, you need to login/re-login again.', 'content-restriction' );
		}

		$_additional_data = [
			'status' => rest_authorization_required_code(),
		];

		if ( ! empty( $endpoint ) ) {
			$_additional_data['endpoint'] = $endpoint;
		}

		return new WP_Error( 'invalid_token', $message, $_additional_data );
	}

	public function get( $endpoint, $callback, $args = [] ) {
		return $this->register_endpoint( $endpoint, $callback, $args, WP_REST_Server::READABLE );
	}

	public function post( $endpoint, $callback, $args = [] ) {
		return $this->register_endpoint( $endpoint, $callback, $args );
	}

	public function register_endpoint( $endpoint, $callback, $args = [], $methods = WP_REST_Server::CREATABLE ) {
		return register_rest_route(
			$this->namespace,
			$endpoint,
			[
				'methods'             => $methods,
				'callback'            => function ( WP_REST_Request $wp_rest_request ) use ( $callback ) {
					$controller = new $callback[0];

					return $controller->{$callback[1]}( $wp_rest_request );
				},
				'permission_callback' => [$this, 'permission_check'],
				'args'                => $args,
			]
		);
	}

	public function response( $response, $endpoint, $status = 500, $additional_data = [] ) {
		if ( $response instanceof WP_Error ) {
			return Response::error(
				$response->get_error_code(),
				$response->get_error_message(),
				$endpoint,
				$status,
				$additional_data
			);
		}

		return Response::success( $response );
	}

	public function get_param( string $param, $default = '', string $sanitizer = 'sanitize_text_field' ) {
		$_value = $this->request->get_param( $param );
		if ( ! empty( $_value ) ) {
			if ( is_callable( $sanitizer ) && ! is_array( $_value ) ) {
				return call_user_func_array( $sanitizer, [$_value] );
			} elseif ( is_array( $_value ) && is_callable( $sanitizer ) ) {
				return array_map( $sanitizer, $_value );
			}

			return $_value;
		}

		return $default;
	}
}