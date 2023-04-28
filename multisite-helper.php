<?php
/**
 * Plugin Name: Multisite Helper
 * Plugin URI: https://github.com/scotnewbury/multisite-helper
 * Description: Provides quality of life improvments for administrators of multisite envrionments
 * Version: 1.1.0
 * Author: Scot Newbury
 * Author URI: https://scotnewbury.com
 * License: GPL3
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Multisite_Helper {
    public function __construct() {
        add_filter ( 'get_blogs_of_user', array( $this, 'sort_my_multisite_blog_listing' ) );
        add_action ( 'wp_before_admin_bar_render', array( $this, 'add_new_site_to_multisite' ) );
        add_filter ( 'wpmu_blogs_columns', array ( $this, 'multisite_blogs_columns' ) );
    }

    /*
     * This function sorts the listing of blogs on the network that the user has access to alphabetically
    */

    public function sort_my_multisite_blog_listing ( $blogs ) {
        uasort( $blogs, function( $a, $b ) { 
            return strcasecmp( $a->blogname, $b->blogname );
        });
        return $blogs;
    }

    /* This function adds a menu option under Sites to allow you to go directly to the 
    * Add New Site page without the need to list all the sites in the netowrk
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

    /**
     * This function adds new columns to the site index page in the administration screens.
     * 
     * It currently adds the following columns:
     * Blog ID - The ID used to identify the blog in the multisite environment
     * 
     *
     * @param   array  $sites_columns   The array of columns before additions
     *
     * @return  array                    The array after the additional columns are added
     */
    function multisite_blogs_columns($sites_columns)
    {

        $columns_before = array_slice( $sites_columns, 0, 2 );
        $columns_after = array_slice( $sites_columns, 2 );

        $sites_columns = 
            $columns_before + 
            array( 
                'blog_id' => __( 'Blog ID' ),
            ) + 
            $columns_after;
        return $sites_columns;
    }

}

$multisite_helper = new Multisite_Helper();

