<?php
/**
 * Plugin Name: Miner Vendors
 * Description: Miner Vendors Plugin
 * Version: 1.0
 * Author: James Allan
 */
include 'util/functions.php';

add_shortcode( 'render_vendors', 'vendor_shortcode' );
define("MINER_PLUGIN_URL", plugin_dir_url(__FILE__));
function vendor_shortcode() {
    ob_start();
    include('templates/vendor-template.php');
    return ob_get_clean();
}

function vendor_scripts(){
    wp_enqueue_style('vendors',MINER_PLUGIN_URL.'css/vendors.css',array(), null);
    wp_enqueue_script('vendor-scripts', MINER_PLUGIN_URL.'js/vendor-display.js',array('jquery'), null);

    wp_localize_script( 'vendor-scripts', 'miner_ajax',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('wp_enqueue_scripts', 'vendor_scripts');

function get_vendors($data){

    $city = $_POST['city'];

    $vendor_query = new WP_Query(
        array(
            'post_type' =>'vendor',
            'posts_per_page' => -1, 
            'tax_query' => array(
                array( 
                    'taxonomy'  => "vendor_city",
                    'field'     => 'slug',
                    'terms'     => $city
                )
            )
       )
   );
   $all_vendors = array();

   if ( $vendor_query->have_posts() ) {

    // Load posts loop.
        while ( $vendor_query->have_posts() ) {
            $vendor_query->the_post();
            $products = get_the_terms(get_the_ID(), 'vendor_product');
            $vendor_image = get_the_post_thumbnail_url();
            foreach($products as $product){
                if(!isset($all_vendors[$product->term_id])){
                    $all_vendors[$product->term_id] = array(); 
                }
                $all_vendors[$product->term_id][] = array( 
                    'vendor_image'  => $vendor_image
                );
            }
        }
    }
   echo json_encode($all_vendors);
    wp_die();
    return;
}

add_action("wp_ajax_get_vendors", "get_vendors");
add_action("wp_ajax_get_vendors", "get_vendors");