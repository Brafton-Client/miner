<?php
/**
* set up post types and other functions
*/


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
        'hierarchical'       => false,
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
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ));
    $labels = array(
        'name'                  => _x( 'Vendor Products', 'taxonomy general name', 'textdomain' ),
        'singular_name'         => _x( 'Vendor Product', 'taxonomy singular name', 'textdomain' )
    );
    register_taxonomy('vendor_product', 'vendor', array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ));

}
add_action( 'init', 'register_vendor_taxonomies' );

/* MakeTemplates Available from this plugin*/

function vendors_add_page_template ($templates) {
    $templates['vendors-template.php'] = 'Vendors Template';
    return $templates;
}
add_filter ('theme_page_templates', 'vendors_add_page_template');

function vendors_redirect_page_template ($template) {
    $post = get_post(); 
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ('vendor-template.php' == basename ($page_template )) 
        $template = WP_PLUGIN_DIR . '/plugins/miner-vendors/templates/vendor-template.php';
    return $template;
    }
add_filter ('page_template', 'vendors_redirect_page_template');