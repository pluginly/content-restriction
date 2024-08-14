<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\DTO;

class RuleUpdateDTO {
	public string $id;
	public string $title;
	public string $who_can_see;
	public string $what_content;
	public string $restrict_view;
	public bool $status;
	public int $priority;
	public string $modified;
	public string $created_at;

	public function set_id( string $id ) {
		$this->id = $id;

		return $this;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_title( string $title ) {
		$this->title = $title;

		return $this;
	}

	public function get_title() {
		return $this->title;
	}

	public function set_who_can_see( string $who_can_see ) {
		$this->who_can_see = $who_can_see;

		return $this;
	}

	public function get_who_can_see() {
		return $this->who_can_see;
	}

	public function set_what_content( string $what_content ) {
		$this->what_content = $what_content;

		return $this;
	}

	public function get_what_content() {
		return $this->what_content;
	}

	public function set_restrict_view( string $restrict_view ) {
		$this->restrict_view = $restrict_view;

		return $this;
	}

	public function get_restrict_view() {
		return $this->restrict_view;
	}

	public function set_status( bool $status ) {
		$this->status = $status;

		return $this;
	}

	public function is_status() {
		return $this->status;
	}

	public function set_priority( int $priority ) {
		$this->priority = $priority;

		return $this;
	}

	public function get_priority() {
		return $this->priority;
	}

	public function set_modified( string $modified ) {
		$this->modified = $modified;

		return $this;
	}

	public function get_modified() {
		return $this->modified;
	}

	public function set_created_at( string $created_at ) {
		$this->created_at = $created_at;

		return $this;
	}

	public function get_created_at() {
		return $this->created_at;
	}
}