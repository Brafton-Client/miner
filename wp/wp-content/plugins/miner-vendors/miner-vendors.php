<?php
/**
 * Plugin Name: Miner Vendors
 * Description: Miner Vendors Plugin
 * Version: 1.0
 * Author: James Allan
 */
include 'util/functions.php';

add_shortcode( 'render_vendors', 'vendor_shortcode' );
  
function vendor_shortcode() {
    ob_start();
    include('templates/vendor-template.php');
    return ob_get_clean();
}

function vendor_scripts(){
    wp_enqueue_style('vendors',plugin_dir_url(__FILE__).'css/vendors.css',array(), null);
}

add_action('wp_enqueue_scripts', 'vendor_scripts');