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
		$this->wpdb->query(
			$this->wpdb->prepare(
				"INSERT INTO {$this->table} (title, who_can_see, what_content, restrict_view, status, priority, modified, created_at)
                VALUES (%s, %s, %s, %s, %d, %d, %s, %s)",
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

		return $this->wpdb->insert_id;
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
				 WHERE id = %s",
				$dto->get_title(),
				$dto->get_who_can_see(),
				$dto->get_what_content(),
				$dto->get_restrict_view(),
				$dto->is_status(),
				$dto->get_priority(),
				Time::mysql(),
				$dto->get_id()
			)
		);
	}

	public function get_all() {
		$query   = "SELECT * FROM {$this->table}";
		$results = $this->wpdb->get_results( $query, ARRAY_A );

		return $results;
	}

	public function delete( $id ) {
		$this->wpdb->query(
			$this->wpdb->prepare(
				"DELETE FROM {$this->table} WHERE id = %d",
				$id
			)
		);
	}

	public function get( $id ) {
		$query = $this->wpdb->prepare(
			"SELECT * FROM {$this->table} WHERE id = %d",
			$id
		);

		$result = $this->wpdb->get_row( $query, ARRAY_A );

		return $result;
	}
}