<?php
/**
 * @package ContentRestriction
 * @since   1.0.0
 * @version 1.0.0
 */

namespace ContentRestriction\Database;

class Rules {

	public static function migrate() {
		global $wpdb;

		$charsetCollate = $wpdb->get_charset_collate();

		$table = $wpdb->prefix . 'content_restriction_rules';

		$indexPrefix = $wpdb->prefix . 'cr_index_';

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) !== $table ) {
			$sql = "CREATE TABLE $table (
                `id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `title` VARCHAR(260) NOT NULL,
                `who_can_see` LONGTEXT NOT NULL,
                `what_content` LONGTEXT NOT NULL,
                `restrict_view` LONGTEXT NOT NULL,
                `status` BOOL NOT NULL,
                `priority` INT NOT NULL DEFAULT 1,
                `modified` TIMESTAMP NULL,
                `created_at` TIMESTAMP NULL,
                 INDEX `{$indexPrefix}id` (`id` ASC)
            ) $charsetCollate;";

			dbDelta( $sql );
		}
	}
}