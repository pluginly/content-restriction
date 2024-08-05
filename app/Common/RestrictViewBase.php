<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Common;

abstract class RestrictViewBase extends ModuleBase {
	public array $r;
	public array $restrictions;
	public string $type;
	public string $module;
	public int $post_id;
	public array $options;
	public $protection;
	public $who_can_see;
	public $then;

	abstract public function boot(): void;

}
