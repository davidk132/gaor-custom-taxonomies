<?php
/*
* Plugin Name: GAOR Media Taxonomy
* Description: Create custom taxonomies for media files
* Version: 1.0
* Author: David Kissinger
* Author URI: http://www.davidkissinger.com
* License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die( 'This is not the code you are looking for.' );
}

function activate_gaor_media_tax() {
  // Activation stuff here
  flush_rewrite_rules();
}

function deactivate_gaor_media_tax() {
  // Deactivation stuff here
  flush_rewrite_rules();
}

function uninstall_gaor_media_tax() {
  // Uninstall stuff here
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'activate_gaor_media_tax' );
register_deactivation_hook( __FILE__, 'deactivate_gaor_media_tax' );
register_uninstall_hook( __FILE__, 'uninstall_gaor_media_tax' );


if ( ! function_exists( 'gaor_register_media_tax' ) ) {
  // Register Custom Taxonomy
  function gaor_register_media_tax() {
  	$labels = array(
  		'name'                       => _x( 'Media', 'Taxonomy General Name', 'gaor' ),
  		'singular_name'              => _x( 'Media', 'Taxonomy Singular Name', 'gaor' ),
  		'menu_name'                  => __( 'Media Categories', 'gaor' ),
  		'all_items'                  => __( 'All Media Categories', 'gaor' ),
  		'parent_item'                => __( 'Parent Media Category', 'gaor' ),
  		'parent_item_colon'          => __( 'Parent Media Category:', 'gaor' ),
  		'new_item_name'              => __( 'New Media Category', 'gaor' ),
  		'add_new_item'               => __( 'Add New Media Category', 'gaor' ),
  		'edit_item'                  => __( 'Edit Media Category', 'gaor' ),
  		'update_item'                => __( 'Update Media Category', 'gaor' ),
  		'view_item'                  => __( 'View Media Category', 'gaor' ),
  		'separate_items_with_commas' => __( 'Separate Media Categories with commas', 'gaor' ),
  		'add_or_remove_items'        => __( 'Add or remove Media Categories', 'gaor' ),
  		'choose_from_most_used'      => __( 'Choose from the most used', 'gaor' ),
  		'popular_items'              => __( 'Popular Media Categories', 'gaor' ),
  		'search_items'               => __( 'Search Media Categories', 'gaor' ),
  		'not_found'                  => __( 'Media Category Not Found', 'gaor' ),
  		'no_terms'                   => __( 'No items', 'gaor' ),
  		'items_list'                 => __( 'Items list', 'gaor' ),
  		'items_list_navigation'      => __( 'Items list navigation', 'gaor' ),
  	);
  	$args = array(
  		'labels'                     => $labels,
  		'hierarchical'               => true,
  		'public'                     => true,
  		'show_ui'                    => true,
  		'show_admin_column'          => true,
  		'show_in_nav_menus'          => true,
  		'show_tagcloud'              => true,
  		'show_in_rest'               => true,
  	);
  	register_taxonomy( 'media', array( 'attachment' ), $args );
  }
}
add_action( 'init', 'gaor_register_media_tax', 0 );

if ( ! function_exists( 'gaor_edit_media_tax_query' ) ) {
  // add 'inherit' to query to access attachments
  function gaor_edit_media_tax_query( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {
		    //var_dump($query->get( 'post_type' ) );
		    //die( 'WP QUERY' );
  		if( is_tax( 'media' ) ) {
  			$query->set( 'post_status', 'inherit' );
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
  		}
  	}
  }
}
add_action( 'pre_get_posts', 'gaor_edit_media_tax_query' );
