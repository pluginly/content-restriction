<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Integrations\FluentCRM;

use ContentRestriction\Common\IntegrationBase;

class Frontend extends IntegrationBase {
	public function boot(): void {
		add_filter( 'content_restriction_module_group_list', [$this, 'add_group'] );
		add_filter( 'content_restriction_who_can_see_module_list', [$this, 'who_can_see'] );
	}

	public function add_group( array $groups ): array {
		$groups['fluent-crm'] = [
			'title'   => __( 'FluentCRM', 'content-restriction' ),
			'icon'    => $this->get_icon( 'FluentCRM' ),
			'details' => '#',
		];

		return $groups;
	}

	public function who_can_see( array $modules ): array {
		$modules[] = [
			'name'    => __( 'Subscriber', 'content-restriction' ),
			'key'     => 'fluent_crm_subscriber',
			'group'   => 'fluent-crm',
			'meta'    => ['list', 'subscribed', 'fluent crm', 'fluentCRM', 'subscriber', 'fluent crm', 'mailing list', 'marketing'],
			'icon'    => $this->get_icon( 'FluentCRM' ),
			'desc'    => __( 'All FluentCRM is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'status' => [
					'title'   => __( 'Subscriber Status', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->get_statuses(),
				],
			],
		];

		$modules[] = [
			'name'    => __( 'Specific Lists', 'content-restriction' ),
			'key'     => 'fluent_crm_specific_lists',
			'group'   => 'fluent-crm',
			'meta'    => ['list', 'subscribed', 'fluent crm', 'fluentCRM', 'subscriber', 'fluent crm', 'mailing list', 'marketing'],
			'icon'    => $this->get_icon( 'FluentCRM' ),
			'desc'    => __( 'All WooCommerce Products is a plugin that allows you to manage posts in WordPress.', 'content-restriction' ),
			'type'    => 'section',
			'options' => [
				'lists'  => [
					'title'   => __( 'Select Lists', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->get_lists(),
				],
				'status' => [
					'title'   => __( 'Select Status', 'content-restriction' ),
					'type'    => 'multi-select',
					'options' => $this->get_statuses(),
				],
			],
		];

		return $modules;
	}

	public function get_statuses() {
		$statuses = fluentcrm_subscriber_statuses();

		$_statuses = [];
		foreach ( $statuses as $status ) {
			$_statuses[$status] = ucfirst( $status );
		}

		return $_statuses;
	}

	public function get_lists() {
		$lists = \FluentCrm\App\Models\Lists::get();

		$_lists = [];
		foreach ( $lists as $list ) {
			$_lists[$list->id] = $list->title;
		}

		return $_lists;
	}
}