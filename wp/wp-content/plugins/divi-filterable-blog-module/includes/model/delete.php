<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Model Delete
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmModelDelete' ) )
{

	class dfbmModelDelete
	{

		/**
		 * Delete layout
		 *
		 * @since 1.0.0
		 */
		public function post( $id )
		{

			return wp_delete_post( (int) $id, true );

		} // end post

		/**
		 * Delete transient
		 *
		 * @since 1.0.0
		 */
		public function transient( $transient )
		{

			return delete_transient( esc_attr( $transient ) );

		} // end transient

		/**
		 * Delete option
		 *
		 * @since 1.0.10
		 */
		public function option( $option )
		{

			return delete_option( esc_attr( $option ) );

		} // end transient

	} // end class
} // end if
