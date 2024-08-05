<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Repositories;

class ModuleRepository {
	private array $restrictions;

	public function __construct() {
		$this->restrictions = $this->get_restrictions();
	}

	public function has_restrictions() {
		if ( empty( $this->restrictions ) ) {
			return false;
		}

		return true;
	}

	private function get_restrictions(): array {
		if ( isset( $this->restrictions ) ) {
			return $this->restrictions;
		}

		return ( new RuleRepository() )->get_all();
	}

	/**
	 * Based on the restrictions,
	 * Load respective modules
	 */
	public function load() {
		if ( is_admin() ) {
			return;
		}

		foreach ( $this->restrictions as $key => $r ) {
			if ( ! isset( $r['isPublished'] ) || ! $r['isPublished'] ) {
				continue;
			}

			if (
				! isset( $r['rule']['who-can-see'] ) ||
				! isset( $r['rule']['what-content'] ) ||
				! isset( $r['rule']['restrict-view'] ) ) {
				continue;
			}

			$if   = is_array( $r['rule']['who-can-see'] ) ? array_key_first( $r['rule']['who-can-see'] ) : $r['rule']['who-can-see'];
			$then = is_array( $r['rule']['what-content'] ) ? array_key_first( $r['rule']['what-content'] ) : $r['rule']['what-content'];
			$else = is_array( $r['rule']['restrict-view'] ) ? array_key_first( $r['rule']['restrict-view'] ) : $r['rule']['restrict-view'];

			$modules = $this->get();
			$_if     = $modules[$if] ?? '';
			$_then   = $modules[$then] ?? '';
			$_else   = $modules[$else] ?? '';

			if ( $_if && $_then && $_else ) {
				( new $_else( $_if, $_then, $r ) )->boot();
			}
		}
	}

	/**
	 * To add more modules,
	 * use the @hook `content_restriction_load_modules`
	 */
	private function get() {
		return apply_filters(
			'content_restriction_load_modules',
			[
				'blur'                  => \ContentRestriction\Modules\Blur\Blur::class,
				'hide'                  => \ContentRestriction\Modules\Hide\Hide::class,
				'login_back'            => \ContentRestriction\Modules\LoginBack\LoginBack::class,
				'replace'               => \ContentRestriction\Modules\Replace\Replace::class,
				'redirection'           => \ContentRestriction\Modules\Redirection\Redirection::class,

				'all_pages'             => \ContentRestriction\Modules\Pages\AllPages::class,
				'specific_pages'        => \ContentRestriction\Modules\Pages\SpecificPages::class,
				'frontpage'             => \ContentRestriction\Modules\Pages\Frontpage::class,

				'all_posts'             => \ContentRestriction\Modules\Posts\AllPosts::class,
				'specific_posts'        => \ContentRestriction\Modules\Posts\SpecificPosts::class,
				'posts_with_categories' => \ContentRestriction\Modules\Posts\PostsWithCategories::class,
				'posts_with_tags'       => \ContentRestriction\Modules\Posts\PostsWithTags::class,

				'selected_roles'        => \ContentRestriction\Modules\WordPressUsers\SelectedRoles::class,
				'selected_users'        => \ContentRestriction\Modules\WordPressUsers\SelectedUsers::class,
				'user_logged_in'        => \ContentRestriction\Modules\WordPressUsers\UserLoggedIn::class,
				'user_not_logged_in'    => \ContentRestriction\Modules\WordPressUsers\UserNotLoggedIn::class,
			]
		);
	}
}