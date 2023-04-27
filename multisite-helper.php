<?php
/**
 * Plugin Name: Multisite Helper
 * Plugin URI: https://github.com/scotnewbury/multisite-helper
 * Description: Provides quality of life improvments for administrators of multisite envrionments
 * Version: 1.0.0
 * Author: Scot Newbury
 * Author URI: https://scotnewbury.com
 * License: GPL3
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
    die;
}

/*
 * This function sorts the listing of blogs on the network that the user has access to alphabetically
*/

function sort_my_multisite_blog_listing ( $blogs ) {
    uasort( $blogs, function( $a, $b ) { 
        return strcasecmp( $a->blogname, $b->blogname );
    });
    return $blogs;
};
add_filter ( 'get_blogs_of_user', 'sort_my_multisite_blog_listing' );

/* This function adds a menu option under Sites to all you to go directly to the 
 * Add New Site page directly without the need to list all the site in the netowrk
 */

function add_new_site_to_multisite() {
    global $wp_admin_bar;
    $wp_admin_bar->add_node( array (
        'parent' => 'network-admin-s',
        'id' => 'add-new-site',
        'title' => _( 'Add New Site' ),
        'href' => network_admin_url( 'site-new.php' ),
    ));
}
add_action ( 'wp_before_admin_bar_render', 'add_new_site_to_multisite' );
