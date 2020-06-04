<?php
/**
* set up post types and other functions
*/

    require_once(ABSPATH . 'wp-admin/includes/class-walker-category-checklist.php');
    class Miner_Walker_Category_Radioset extends Walker_Category_Checklist {
        public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
            $parent_output = '';
            parent::start_el($parent_output, $category, $depth, $args, $id);
            $output .= str_replace('checkbox', 'radio', $parent_output);
        }
    }


/**
 * Register the "vendor" custom post type
 */
function vendor_setup_post_type() {
    $labels = array(
        'name'                  => _x( 'Vendors', 'post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Vendor', 'post type singular name', 'textdomain' )
    ); 
    $args = array(
        'labels' => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
//         'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'taxonomies' ),
    );
    register_post_type( 'vendor', $args ); 

} 
add_action( 'init', 'vendor_setup_post_type' );

function register_vendor_taxonomies() {
    $labels = array(
        'name'                  => _x( 'Vendor Cities', 'taxonomy general name', 'textdomain' ),
        'singular_name'         => _x( 'Vendor City', 'taxonomy singular name', 'textdomain' )
    );
    register_taxonomy('vendor_city', 'vendor', array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        //'meta_box_cb' => 'dropdown',
    ));
    $labels = array(
        'name'                  => _x( 'Vendor Products', 'taxonomy general name', 'textdomain' ),
        'singular_name'         => _x( 'Vendor Product', 'taxonomy singular name', 'textdomain' )
    );
    register_taxonomy('vendor_product', 'vendor', array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        //'meta_box_cb' => 'dropdown',
    ));

}
add_action( 'init', 'register_vendor_taxonomies' );

add_filter(
    'wp_terms_checklist_args'
    , function($args) {
        if (isset($args['taxonomy']) && $args['taxonomy'] == "vendor_product") {
            $args['walker'] = new \Miner_Walker_Category_Radioset;
            $args['checked_ontop'] = false;
        }
        return $args;
    }
);