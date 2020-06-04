<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die( 'Don\'t try to load this file directly!' );

require_once( plugin_dir_path( __FILE__ ) . 'divi-filterable-blog-module.php' );

function deInstall( $shortname )
{

	global $wpdb;

    foreach ( ( new dfbmControllerLayouts )->getLayouts() as $key => $value )
    {

        $id = ( new dfbmModelGet )->postByTitle( $key, ET_BUILDER_LAYOUT_POST_TYPE )->ID;

        if ( $id )
            wp_delete_post( $id, true );

    } // end foreach

	if ( is_a( $wpdb, 'wpdb' ) )
	{

		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options  WHERE option_name  LIKE %s", 'dfbm_%' ) );
        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE meta_key     LIKE %s", '_dfbm_%' ) );

	} // end if

    et_delete_option( $shortname . '_dfbm_archive_light' );
    et_delete_option( $shortname . '_dfbm_archive_search' );
    et_delete_option( $shortname . '_dfbm_archive_author' );
    et_delete_option( $shortname . '_dfbm_archive_archive' );
    et_delete_option( $shortname . '_dfbm_archive_woocommerce' );
    et_delete_option( $shortname . '_dfbm_delete_on_uninstall' );

} // end deInstall

function initialize()
{

    global $shortname;

    if ( 'on' == ( $opt = et_get_option( $shortname . '_dfbm_delete_on_uninstall', false ) ) )
    {

        if ( ! is_multisite() )
        {

            deInstall( $shortname );

        } // end if

        else
        {

            global $wpdb;

            $blogs   = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
            $current = get_current_blog_id();

            foreach ( $blogs as $blog )
            {

                switch_to_blog( $blog );

                deInstall( $shortname );

            } // end foreach

            switch_to_blog( $current );

        } // end else
    } // end if
} // end initialize

initialize();
