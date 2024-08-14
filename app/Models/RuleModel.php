<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Models;

use ContentRestriction\Utils\Time;

class RuleModel {
	private $wpdb;
	private $table;

	public function __construct() {
		global $wpdb;
		$this->wpdb  = $wpdb;
		$this->table = $wpdb->prefix . 'content_restriction_rules';
	}

	public function create( \ContentRestriction\DTO\RuleCreateDTO $dto ) {
		error_log( print_r( $dto, true ) );
		$this->wpdb->query(
			$this->wpdb->prepare(
				"INSERT INTO {$this->table} (uid, title, who_can_see, what_content, restrict_view, status, priority, modified, created_at)
                VALUES (%s, %s, %s, %s, %s, %d, %d, %s, %s)",
				$dto->get_uid(),
				$dto->get_title(),
				$dto->get_who_can_see(),
				$dto->get_what_content(),
				$dto->get_restrict_view(),
				$dto->is_status(),
				$dto->get_priority(),
				Time::mysql(),
				Time::mysql()
			)
		);
	}

	public function update( \ContentRestriction\DTO\RuleUpdateDTO $dto ) {
		$this->wpdb->query(
			$this->wpdb->prepare(
				"UPDATE {$this->table}
				 SET title = %s,
					 who_can_see = %s,
					 what_content = %s,
					 restrict_view = %s,
					 status = %d,
					 priority = %d,
					 modified = %s
				 WHERE uid = %s",
				$dto->get_title(),
				$dto->get_who_can_see(),
				$dto->get_what_content(),
				$dto->get_restrict_view(),
				$dto->is_status(),
				$dto->get_priority(),
				Time::mysql(),
				$dto->get_uid()
			)
		);
	}

	public function get_all() {
		$query   = "SELECT * FROM {$this->table}";
		$results = $this->wpdb->get_results( $query, ARRAY_A );

		return $results;
	}

	// public function read( \ContentRestriction\DTO\RuleReadDTO $dto ) {
	// 	$fields = $dto->get_fields();
	// 	$where  = $dto->get_where();

	// 	$start_date = $this->get_start_date();
	// 	$end_date   = Time::create_date( 'tomorrow' );

	// 	$sql = $this->wpdb->prepare(
	// 		"SELECT {$fields}
	// 		FROM {$this->table}
	// 		WHERE $where (created_at BETWEEN %s AND %s)
	// 		ORDER BY id DESC
	// 		LIMIT %d",
	// 		$start_date,
	// 		$end_date,
	// 		$dto->get_limit()
	// 	);

	// 	$results = $this->wpdb->get_results( $sql );

	// 	return $results;
	// }

}