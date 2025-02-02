<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Hide;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'  => __( 'Hide', 'content-restriction' ),
			'key'   => 'hide',
			'icon'  => $this->get_icon( 'Hide' ),
			'desc'  => __( 'Hide entirely.', 'content-restriction' ),
			'group' => 'wordpress',
		];

		return $modules;
	}
}