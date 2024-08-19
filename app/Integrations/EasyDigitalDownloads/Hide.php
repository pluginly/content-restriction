<?php
/**
 * @package ContentRestrictionPro
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestrictionPro\Integrations\EasyDigitalDownloads;

class Hide extends \ContentRestriction\Common\IntegrationHide {
	public array $then_types = ['edd_all_downloads', 'edd_specific_downloads', 'edd_downloads_with_categories'];
	public string $post_type = 'download';

	public function single_view_hide() {
		if ( is_front_page() || is_archive() || is_home() ) {
			return;
		}

		if ( \ContentRestriction\Utils\Post::type( $this->post_id ) !== $this->post_type ) {
			return;
		}

		switch ( $this->what_content_type ) {

			case 'edd_all_downloads':
				$this->redirect_to_home();
				break;

			case 'edd_downloads_with_categories':
				if ( has_term( $this->options['categories'], 'download_category', $this->post_id ) ) {
					$this->redirect_to_home();
				}
				break;
		}
	}

	public function hide( $query, $post_type, $what_content_type, $options ) {

		if ( $this->post_type !== $post_type ) {
			return;
		}

		$this->options   = $options;
		$this->what_content_type = $what_content_type;

		if ( ! in_array( $this->what_content_type, $this->then_types ) ) {
			return;
		}

		switch ( $this->what_content_type ) {
			case 'edd_all_downloads':
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'download_category',
							'field'    => 'term_id',
							'terms'    => [100000000000000000],
							'operator' => 'IN',
						],
					]
				);
				break;

			case 'edd_specific_downloads':
				$ids = $options['downloads'] ?? [];
				$query->set( 'post__not_in', $ids );
				break;

			case 'edd_downloads_with_categories':
				$ids = $options['categories'] ?? [];
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'download_category',
							'field'    => 'term_id',
							'terms'    => $ids,
							'operator' => 'NOT IN',
						],
					],
				);
				break;
		}
	}
}