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

function sort_my_multisite_blog_listing ( $blogs ) {
    uasort( $blogs, function( $a, $b ) { 
        return strcasecmp( $a->blogname, $b->blogname );
    });
    return $blogs;
};
// add_filter ( 'get_blogs_of_user', 'sort_my_multisite_blog_listing' );
