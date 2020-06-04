<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Model Get
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmModelGet' ) )
{

	class dfbmModelGet
	{

		/**
		 * Get option
		 *
		 * @since 1.0.0
		 */
		public function option( $option )
		{

			return get_option( esc_attr( $option ) );

		} // end option

		/**
		 * Get transient
		 *
		 * @since 1.0.0
		 */
		public function transient( $transient )
		{

			return get_transient( esc_attr( $transient ) );

		} // end transient

		/**
		 * Get post by title
		 *
		 * @since 1.0.0
		 */
		public function postByTitle( $title, $pt )
		{

			return get_page_by_title( esc_attr( $title ), false, esc_attr( $pt ) );

		} // end postByTitle

		/**
		 * Get layout
		 *
		 * @since 1.0.0
		 */
		public function layout( $title )
		{

			global $shortname;

			$light  = 'on' == et_get_option( $shortname . '_dfbm_archive_light', false ) ? '-Light' : '';

			$title  = strtoupper( DFBM()->prefix() ) . '-' . ucfirst( esc_attr( $title ) . $light );

			$layout = $this->postByTitle( $title, ET_BUILDER_LAYOUT_POST_TYPE );

			if ( false !== strpos( $layout->post_content, '[et_pb_dfbm_blog' ) )
				return $layout;

			return false;

		} // end layout

		/**
		 * Get post meta
		 *
		 * @since 1.0.0
		 */
		public function meta( $id, $key, $value = true )
		{

			return get_post_meta( (int) $id, esc_attr( $key ), $value );

		} // end meta
	} // end class
} // end if
