<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Admin\Controllers;

class ModuleController {

	public function who_can_see(): array {
		return apply_filters( 'content_restriction_who_can_see_module_list', [] );
	}

	public function what_content(): array {
		return apply_filters( 'content_restriction_what_content_module_list', [] );
	}

	public function else_view(): array {
		return apply_filters( 'content_restriction_restrict_view_module_list', [] );
	}

	public function groups(): array {
		return apply_filters( 'content_restriction_module_group_list', [] );
	}
}