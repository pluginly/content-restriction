<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\Directorist;

class Hide extends \ContentRestriction\Common\IntegrationHide {
	public array $then_types = ['directorist_all_listings', 'directorist_specific_listings', 'directorist_listings_with_categories', 'directorist_listings_with_locations'];
	public string $post_type = 'at_biz_dir';

	public function single_view_hide() {
		if ( is_front_page() || is_archive() || is_home() ) {
			return;
		}

		if ( \ContentRestriction\Utils\Post::type( $this->post_id ) !== $this->post_type ) {
			return;
		}

		switch ( $this->what_content_type ) {

			case 'directorist_all_listings':
				$this->redirect_to_home();
				break;

			case 'directorist_listings_with_categories':
				if ( has_term( $this->options['categories'], 'at_biz_dir-category', $this->post_id ) ) {
					$this->redirect_to_home();
				}
				break;

			case 'directorist_listings_with_locations':
				if ( has_term( $this->options['locations'], 'at_biz_dir-location', $this->post_id ) ) {
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

			case 'directorist_all_listings':
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'at_biz_dir-category',
							'field'    => 'term_id',
							'terms'    => [100000000000000000],
							'operator' => 'IN',
						],
					]
				);
				break;

			case 'directorist_specific_listings':
				$ids = $options['listings'] ?? [];
				$query->set( 'post__not_in', $ids );
				break;

			case 'directorist_listings_with_categories':
				$ids = $options['categories'] ?? [];
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'at_biz_dir-category',
							'field'    => 'term_id',
							'terms'    => $ids,
							'operator' => 'NOT IN',
						],
					]
				);
				break;

			case 'directorist_listings_with_locations':
				$ids = $options['locations'] ?? [];
				$query->set(
					'tax_query',
					[
						'relation' => 'OR',
						[
							'taxonomy' => 'at_biz_dir-location',
							'field'    => 'term_id',
							'terms'    => $ids,
							'operator' => 'NOT IN',
						],
					]
				);
				break;
		}
	}
}