<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller View
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerView' ) )
{

	class dfbmControllerView
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $template;

		// private $layout;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct( $template )
		{

			/**
			 * Set properties
			 *
			 * @since 1.0.0
			 */
			$this->template = $template;

			// $this->layout = $layout;

			/**
			 * Initialize
			 *
			 * @since 1.0.0
			 */
			$this->initialize();

		} // end constructor

		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			if ( ! empty( DFBM()->getLayout() ) ) :

				add_filter( 'template_include', function( $template )
				{

					return apply_filters( 'dfbm_archive_template_include', DFBM()->views() . $this->template . '.php', $template );

				});
			endif;
		} // end initialize
	} // end class
} // end if
