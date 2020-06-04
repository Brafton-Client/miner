<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Columns
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerColumns' ) )
{

	class dfbmControllerColumns
	{

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			/**
			 * Initialize
			 *
			 * @since 1.0.0
			 */
			if ( apply_filters( 'dfbm_id_to_column', true ) )
				$this->initialize();

		} // end constructor

		/**
		 * Add ID column, render content and add style
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			add_action( 'admin_head-edit.php',        [ $this, 'styleColumn' ] );

			add_action( 'manage_posts_columns',       [ $this, 'addColumn' ], 5 );

			add_action( 'manage_posts_custom_column', [ $this, 'renderColumn' ], 5, 2 );


		} // end initialize

		/**
		 * Add style for the column
		 *
		 * @since 1.0.0
		 */
		public function styleColumn()
		{

			if ( isset( $_REQUEST['post_type'] ) && 'post' == $_REQUEST['post_type'] )
				echo '<style type="text/css">#dfbm-post-id{width:65px;}</style>';

		} // end styleColumn

		/**
		 * Add column
		 *
		 * @since 1.0.0
		 */
		public function addColumn( $columns )
		{

			$part1 = array_slice( $columns , 0, 2 );
			$part2 = array_slice( $columns , 2 );

			$id['dfbm-post-id'] = 'ID';

			return array_merge( $part1, $id, $part2 );

		} // end addColumn

		/**
		 * Render column
		 *
		 * @since 1.0.0
		 */
		public function renderColumn( $column, $id )
		{

			if( 'dfbm-post-id' == $column )
				echo $id;

		} // end renderColumn
	} // end class
} // end if
