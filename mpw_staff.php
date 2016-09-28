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
  }
  add_action( 'wp_enqueue_scripts', 'mpw_team_scripts' );
function team_list_display ( $atts , $content = null ) {
	wp_enqueue_script( 'mpw-team');
	$args = array(
	'post_type' => 'our_team',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'menu_order',
);
$the_query = new WP_Query( $args );
// The Loop
if ( $the_query->have_posts() ) {
	$cont .= '<style>.team-member {
  text-align: center;
  position: relative;
  padding: 0;
}
.team-list .entry-title {
  font-size: 22px;
  position: absolute;
  bottom: 0px;
  width: 100%;
  background: rgba(199, 199, 199, 0.5);
}
img.team-member-img {
  width: 100%;
}
.team-member-img-hover {
	display: none;
}
.team-member.active .team-member-img {
	display: none;
}
.team-member.active .team-member-img.team-member-img-hover {
	display: inline;
}
.team-member:hover .team-member-img {
	display: none;
}
.team-member a:focus {
  color: transparent;
}
.team-member:hover .team-member-img.team-member-img-hover {
	display: inline;
}
.team-member-name {
  display: none;
}
.team-member:hover .team-member-name {
  display: block;
}

.job-title {
  margin-bottom: 20px;
  display: block;
  font-style: italic;
}
.team-member-img-container {
	position: relative;
	min-height: 200px;
}
.team-description {
  position: relative;
}
.team-member-content {
    margin-bottom: 15px;
}
.contact-link {
	display: none;
}
@media screen and (max-width:600px) {
	.team-description {
		display: none;
	}
}
</style><div id="team-area" class="row"><div class="col-xs-12 col-sm-7 team-list"><div class="row">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		global $post;
		$data_id = $post->ID;
		$hover_image_id = get_post_meta($post->ID, 'team_hover_image', true);
		$short_name = get_post_meta($post->ID, 'short_name', true);
		$hover_image_url = wp_get_attachment_url($hover_image_id);
		$thumb_id = get_post_meta($post->ID, 'team_main_image', true);
		if ($thumb_id == '') {$thumb_id = get_post_thumbnail_id();}
		$thumb_url = wp_get_attachment_url($thumb_id);
		$team_title = get_the_title();
		$comp_title = str_replace(" ","",$team_title);	
		$position = get_post_meta($post->ID, 'position', true);	
		if ($hover_image_url == ''){$hover_image_url = $thumb_url;}
		$name_array = explode(" ", $team_title);
		$first_name = $name_array[0];
		if ($short_name == ''){	$short_name = $first_name; }
		$team_content = do_shortcode(get_the_content($data_id));
		$cont .= '<div class="team-member col-xs-12 col-sm-4"><div class="team-member-img-container"><a data-id="'.$data_id.'" id="'.$comp_title.'-link" class="team-member-link" title="'.$comp_title.'" href="'.get_the_permalink().'"><img class="team-member-img" src="'.$thumb_url.'" /><img class="team-member-img team-member-img-hover" src="'.$hover_image_url.'" /></a><h2 class="team-member-name entry-title">'.$team_title.'</h2></div><div class="team-member-info" id="'.$comp_title.'-info" style="display:none;"><span class="job-title">'.$position.'</span><div class="team-member-description">'.$team_content.'</div>
		<div class="team-member-contact"><a href="#" data-featherlight="#mylightbox" data-shortname="' . $short_name . '" class="contact-link">Contact ' . $short_name . '</a></div></div></div>';
	}
	$cont .= '</div></div>
	<div class="team-description-col col-xs-12 col-sm-5">
	<div class="team-description">
		<div class="ajax-loading-img"><img class= "loading-icon" src="'.get_stylesheet_directory_uri() . '/images/ajax-loader.gif" /></div>
<article id="post-ID" class="post-class">
	<header class="entry-header">
		<h2 class="entry-title"></h2>
<span class="job-title"></span>
	</header>
<div class="row">
<main id="main-service" class="team-member-main col-xs-12" role="main"><div class="team-member-content">' . $content . '
</div><a href="#" data-featherlight="#mylightbox" class="contact-link"></a></main><!--end main service-->
	</div><!--end row-->
</article><!--end post-article-->
</div><!--end team description box-->
</div><!--end team description col -->
<div class="contact-holder" style="display:none;"><div id="mylightbox" style="background-color:#F4F4F4; padding:20px;">[contact-form-7 id="1639" title="team member contact"]</div></div>
</div><!--end full team area -->';

} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();


return do_shortcode( $cont );

}

add_shortcode( 'team-list', 'team_list_display' );

?>