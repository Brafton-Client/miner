<?php
function my_theme_enqueue_styles() { 
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	if(is_home()){
		wp_enqueue_script('map', get_stylesheet_directory_uri()."/js/resource.js", array('jquery'), null,true);
	}
	if(is_page(array(850,409,145))) :
	 	wp_enqueue_style( 'map', get_stylesheet_directory_uri().'/css/map.css', array(), null);
		wp_enqueue_script('states', get_stylesheet_directory_uri()."/js/statedata.js", array(), null,true);
		wp_enqueue_script('map', get_stylesheet_directory_uri()."/js/map.js", array(), null,true);
	endif;
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

register_taxonomy( 'content-type', 
		array('post'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Content Type', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Content Type', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Content Types', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Content Types', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Content Type', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Content Type:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Content Type', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Content Type', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Content Type', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Content Type Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'content-type' ),
		)
    );
    register_taxonomy( 'industry', 
		array('post'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Industry', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Industry', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Industries', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Industries', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Industry', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Industry:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Industry', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Industry', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Industry', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Industry Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'industry' ),
		)
	);