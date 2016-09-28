<?php
 /*
Plugin Name: MPW Team or Staff
Plugin URI:  
Description: display your staff or team members
Version:     0.1-alpha
Author:      MPW Marketing
Author URI:  
Text Domain: mpw
 */
// Register Custom Post Type
function our_team_post_type() {

	$labels = array(
		'name'                  => _x( 'Staff Members', 'Post Type General Name', 'mpw_team_post_type' ),
		'singular_name'         => _x( 'Staff Member', 'Post Type Singular Name', 'mpw_team_post_type' ),
		'menu_name'             => __( 'Staff', 'mpw_team_post_type' ),
		'name_admin_bar'        => __( 'Staff Member', 'mpw_team_post_type' ),
		'archives'              => __( 'Staff Archives', 'mpw_team_post_type' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mpw_team_post_type' ),
		'all_items'             => __( 'All Items', 'mpw_team_post_type' ),
		'add_new_item'          => __( 'Add New Staff Member', 'mpw_team_post_type' ),
		'add_new'               => __( 'Add New', 'mpw_team_post_type' ),
		'new_item'              => __( 'New Item', 'mpw_team_post_type' ),
		'edit_item'             => __( 'Edit Item', 'mpw_team_post_type' ),
		'update_item'           => __( 'Update Item', 'mpw_team_post_type' ),
		'view_item'             => __( 'View Item', 'mpw_team_post_type' ),
		'search_items'          => __( 'Search Item', 'mpw_team_post_type' ),
		'not_found'             => __( 'Not found', 'mpw_team_post_type' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'mpw_team_post_type' ),
		'featured_image'        => __( 'Featured Image', 'mpw_team_post_type' ),
		'set_featured_image'    => __( 'Set featured image', 'mpw_team_post_type' ),
		'remove_featured_image' => __( 'Remove featured image', 'mpw_team_post_type' ),
		'use_featured_image'    => __( 'Use as featured image', 'mpw_team_post_type' ),
		'insert_into_item'      => __( 'Insert into item', 'mpw_team_post_type' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mpw_team_post_type' ),
		'items_list'            => __( 'Items list', 'mpw_team_post_type' ),
		'items_list_navigation' => __( 'Items list navigation', 'mpw_team_post_type' ),
		'filter_items_list'     => __( 'Filter items list', 'mpw_team_post_type' ),
	);
	$rewrite = array(
		'slug'                  => 'staff',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Staff Member', 'mpw_team_post_type' ),
		'description'           => __( 'Staff or Team Members', 'mpw_team_post_type' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'our_team', $args );

}
add_action( 'init', 'our_team_post_type', 0 );


function mpw_team_scripts() {
  	wp_register_script(
  		'mpw-team',
  		plugins_url( '/js/mpw-team.js', __FILE__),
  		array( 'jquery' ), '.1', true
  	);
  	wp_enqueue_style( 'mpw-staff-css', plugins_url( '/css/mpw-staff.css', __FILE__) );
  }
  add_action( 'wp_enqueue_scripts', 'mpw_team_scripts' );
function team_list_display ( $atts , $content = null ) {
	//wp_enqueue_script( 'mpw-team');
	$args = array(
	'post_type' => 'our_team',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'menu_order',
);
$the_query = new WP_Query( $args );
// The Loop
if ( $the_query->have_posts() ) {
	$cont .= '<div id="staff-container" class="pure-g">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		global $post;
		$data_id = $post->ID;
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			$thumb_url = get_the_post_thumbnail_url();
		} 
		$team_title = get_the_title();	
		$position = get_field( "staff_postion", $data_id );
		$email_address = get_field( "staff_email_address", $data_id );	

		$cont .= '<div class="staff-member pure-u-1-1 pure-u-sm-1-4">';
		$cont .= '<div class="staff-member-img-container"><img class="staff-member-img" src="'.$thumb_url.'" /></div>';
		$cont .= '<div class="staff-contact"><i class="fa fa-envelope" aria-hidden="true"></i></div>';
		$cont .= '<div class="staff-info"><h2 class="staff-member-name">'.$team_title.'</h2><span class="job-title">'.$position.'</span></div>';
		$cont .= '</div>';
	}
	$cont .= '</div>';

} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();


return do_shortcode( $cont );

}

add_shortcode( 'team-list', 'team_list_display' );

?>