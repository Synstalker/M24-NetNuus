<?php
/**
 * Retrieve the slug of a category from its ID.
 *
 * @since 1.0.1
 *
 * @param int $cat_id Category ID
 * @return string Category slug, or an empty string if category doesn't exist.
 */

function get_cat_slug( $cat_id ) {
	$cat_id = (int) $cat_id;
	$category = get_term( $cat_id, 'category' );
	if ( ! $category || is_wp_error( $category ) )
		return '';
	return $category->slug;
}

/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @since 3.0.0
 *
 * @uses locate_template()
 *
 * @param string $slug The slug name for the generic template.
 * @param string $name The name of the specialised template.
 */
function include_template_part( $slug, $name = null, $_data = null ) {
	/**
	 * Fires before the specified template part file is loaded.
	 *
	 * The dynamic portion of the hook name, $slug, refers to the slug name
	 * for the generic template part.
	 *
	 * @since 3.0.0
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialized template.
	 */
	do_action( "include_template_part_{$slug}", $slug, $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "{$slug}-{$name}.php";

	$templates[] = "{$slug}.php";

	$template = locate_template($templates, false, false);

	if ( !empty( $_data ) && is_array( $_data ) )
		extract( $_data, EXTR_SKIP );
	include $template;
}

/**
 * On INIT it will check if the table has been created via the tag.
 * @param $table_name
 * @param $type
 */
function create_metadata_table($table_name, $type)
{
	global $wpdb;
	if ( !empty ($wpdb->charset) )
	{
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	}
	if ( !empty ($wpdb->collate) )
	{
		$charset_collate .= " COLLATE {$wpdb->collate}";
	}

	$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$table_name} (
	meta_id bigint(20) NOT NULL AUTO_INCREMENT,
	{$type}_id bigint(20) NOT NULL default 0,

	meta_key varchar(255) DEFAULT NULL,
	meta_value longtext DEFAULT NULL,

	UNIQUE KEY meta_id (meta_id)
	) {$charset_collate}";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

add_action('init', 'setup_termmeta_table');
function setup_termmeta_table(){
	global $wpdb;

	// Let's check our table, not ideal, but hey
	$table_name = 'termmeta';
	if ( empty($wpdb->$table_name) && get_option('termmeta_table_created') == false)
	{
		create_metadata_table("termmeta", 'term');
		update_option('termmeta_table_created', true);
	}

	// Set the Term Meta Table Name
	$wpdb->$table_name = "{$wpdb->prefix}{$table_name}";
}

/**
 * Retrieve term parents with separator.
 *
 * @param string $taxonomy  Taxonomy Name
 * @param int    $id        term ID.
 * @param bool   $link      Optional, default is false. Whether to format with link.
 * @param string $separator Optional, default is '/'. How to separate categories.
 * @param bool   $nicename  Optional, default is false. Whether to use nice name for display.
 * @param array  $visited   Optional. Already linked to categories to prevent duplicates.
 *
 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
 */
function get_term_parents($taxonomy, $id, $link = false, $separator = '/', $nicename = false, $visited = array())
{
	$chain = '';
	$parent = get_term($id, $taxonomy);
	if ( is_wp_error($parent) )
	{
		return $parent;
	}

	if ( $nicename )
	{
		$name = $parent->slug;
	}
	else
	{
		$name = $parent->name;
	}

	if ( $parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited) )
	{
		$visited[] = $parent->parent;
		$chain .= get_term_parents($taxonomy, $parent->parent, $link, $separator, $nicename, $visited);
	}

	if ( $link )
	{
		$chain .= '<a href="' . esc_url(get_term_link($parent->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $parent->name)) . '">' . $name . '</a>' . $separator;
	}
	else
	{
		$chain .= $name . $separator;
	}

	return $chain;
}

/**
 * Check if a post is a custom post type.
 *
 * @param  mixed $post Post object or ID
 *
 * @return boolean
 */
function is_custom_post_type( $post = NULL )
{
	$all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

	// there are no custom post types
	if ( empty ( $all_custom_post_types ) )
		return FALSE;

	$custom_types      = array_keys( $all_custom_post_types );
	$current_post_type = get_post_type( $post );

	// could not detect current type
	if ( ! $current_post_type )
		return FALSE;

	return in_array( $current_post_type, $custom_types );
}

/** Get attachment ID by url */
function get_attachment_id_from_src($image_src)
{
	global $wpdb;

	$components = parse_url($image_src);
	$id = $wpdb->get_var("SELECT {$wpdb->posts}.ID
	FROM {$wpdb->posts} WHERE {$wpdb->posts}.guid LIKE '%{$components['path']}%'");

	return ($id > 0) ? $id : false;
}

if ( !(function_exists('wp_get_attachment_by_post_name')) )
{
	function wp_get_attachment_by_post_name($post_name)
	{
//		$args = array(
//			'post_per_page' => 1,
//			'post_type'     => 'attachment',
//			'name'          => trim($post_name),
//		);
//		$get_posts = new Wp_Query($args);
		$get_posts = get_posts('name='.$post_name);

		if ( isset($get_posts->posts[0]) )
		{
			return $get_posts->posts[0];
		}
		else
		{
			return false;
		}
	}
}