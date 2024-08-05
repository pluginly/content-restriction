<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */
namespace ContentRestriction\Utils;

class Cron {
	public static function add_event( string $hook, string $recurrence = 'daily', $timestamp = null ) {
		if ( ! wp_next_scheduled( $hook ) ) {
			wp_schedule_event( $timestamp ?? Time::now(), $recurrence, $hook );
		}
	}

	public static function add_schedule( string $name, int $interval, string $display = '' ) {
		add_filter( 'cron_schedules', function () use ( $name, $interval, $display ) {
			$schedules[$name] = ['interval' => $interval, 'display' => $display ?? $name];

			return $schedules;
		} );
	}

	public function scheduled( string $hook, callable $callback ) {
		add_action( $hook, $callback );
	}
}
