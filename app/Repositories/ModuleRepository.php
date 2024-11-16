<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.4.0
 */

namespace ContentRestriction\Repositories;

class ModuleRepository {
	private array $restrictions;

	public function __construct() {
		$this->restrictions = $this->fetch_restrictions();
	}

	/**
	 * Checks if any restrictions are defined.
	 *
	 * @return bool True if restrictions are present; false otherwise.
	 */
	public function has_restrictions(): bool {
		return ! empty( $this->restrictions );
	}

	/**
	 * Retrieves all restriction rules.
	 *
	 * @return array List of restriction rules.
	 */
	private function fetch_restrictions(): array {
		return $this->restrictions ?? ( new RuleRepository() )->get_all();
	}

	/**
	 * Loads and initializes applicable restriction modules based on active rules.
	 */
	public function load(): void {
		// Exit if running in admin mode to prevent frontend restrictions from affecting admin
		if ( is_admin() ) {
			return;
		}

		// Get available restriction modules once for efficiency
		$modules = $this->get_modules();

		// Iterate through each restriction rule
		foreach ( $this->restrictions as $rule ) {
			// Skip rule if it's inactive or invalid
			if ( empty( $rule['status'] ) || ! $this->is_valid_rule( $rule['rule'] ) ) {
				continue;
			}

			// Resolve modules for "who can see," "what content," and "restrict view"
			$who_can_see   = $this->resolve_rule_module( $rule['rule']['who-can-see'] );
			$what_content  = $this->resolve_rule_module( $rule['rule']['what-content'] );
			$restrict_view = $this->resolve_rule_module( $rule['rule']['restrict-view'] );

			// Check that all required modules exist in the loaded modules array
			if ( isset( $modules[$who_can_see], $modules[$what_content], $modules[$restrict_view] ) ) {

				// Initialize and boot the restriction view module with resolved modules
				$restriction_module = new $modules[$restrict_view](
					$modules[$who_can_see],
					$modules[$what_content],
					$rule
				);

				$restriction_module->boot();
			}
		}
	}

	/**
	 * Retrieves all module class mappings with an option for additional modules via hooks.
	 *
	 * @return array List of available module classes.
	 */
	private function get_modules(): array {
		return apply_filters(
			'content_restriction_load_modules',
			[
				// Restriction Types
				'blur'                  => \ContentRestriction\Modules\Blur\Blur::class,
				'hide'                  => \ContentRestriction\Modules\Hide\Hide::class,
				'login_back'            => \ContentRestriction\Modules\LoginBack\LoginBack::class,
				'replace'               => \ContentRestriction\Modules\Replace\Replace::class,
				'redirection'           => \ContentRestriction\Modules\Redirection\Redirection::class,

				// Content Types
				'all_pages'             => \ContentRestriction\Modules\Pages\AllPages::class,
				'specific_pages'        => \ContentRestriction\Modules\Pages\SpecificPages::class,
				'frontpage'             => \ContentRestriction\Modules\Pages\Frontpage::class,

				// Post Types
				'all_posts'             => \ContentRestriction\Modules\Posts\AllPosts::class,
				'specific_posts'        => \ContentRestriction\Modules\Posts\SpecificPosts::class,
				'posts_with_categories' => \ContentRestriction\Modules\Posts\PostsWithCategories::class,
				'posts_with_tags'       => \ContentRestriction\Modules\Posts\PostsWithTags::class,

				'shortcode'             => \ContentRestriction\Modules\Shortcode\Shortcode::class,

				// User Types
				'selected_roles'        => \ContentRestriction\Modules\WordPressUsers\SelectedRoles::class,
				'selected_users'        => \ContentRestriction\Modules\WordPressUsers\SelectedUsers::class,
				'user_logged_in'        => \ContentRestriction\Modules\WordPressUsers\UserLoggedIn::class,
				'user_not_logged_in'    => \ContentRestriction\Modules\WordPressUsers\UserNotLoggedIn::class,
			]
		);
	}

	/**
	 * Verifies the rule's structure to ensure required modules are set.
	 *
	 * @param array $rule Rule data array.
	 * @return bool True if the rule is valid; false otherwise.
	 */
	private function is_valid_rule( array $rule ): bool {
		return isset(
			$rule['who-can-see'],
			$rule['what-content'],
			$rule['restrict-view']
		);
	}

	/**
	 * Retrieves the primary key of a rule module, handling array structures if needed.
	 *
	 * @param mixed $module Rule module data, potentially an array.
	 * @return string|null Primary key of the module or null if undefined.
	 */
	private function resolve_rule_module( $module ): ?string {
		return is_array( $module ) ? array_key_first( $module ) : $module;
	}
}