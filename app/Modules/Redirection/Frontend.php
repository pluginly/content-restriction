<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Modules\Redirection;

use ContentRestriction\Common\FrontendBase;

class Frontend extends FrontendBase {

	public function boot() {
		add_filter( 'content_restriction_restrict_view_module_list', [$this, 'list'] );
	}

	public function list( array $modules ): array {
		$modules[] = [
			'name'    => __( 'Redirect', 'content-restriction' ),
			'key'     => 'redirection',
			'icon'    => $this->get_icon( 'Redirection' ),
			'desc'    => __( 'Redirect to any URL.', 'content-restriction' ),
			'type'    => 'section',
			'group'   => 'wordpress',
			'options' => [
				'url' => [
					'title' => __( 'Redirection to', 'content-restriction' ),
					'desc'  => __( 'Title is a plugin that allows you to blur content on your site.', 'content-restriction' ),
					'type'  => 'url',
				],
			],
		];

		return $modules;
	}
}