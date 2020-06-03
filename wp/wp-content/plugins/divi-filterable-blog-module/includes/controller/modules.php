<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Modules
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerModules' ) )
{

	class dfbmControllerModules
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $slugs;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			/**
			 * Set properties
			 *
			 * @since 1.0.0
			 */
			$this->slugs = [];

			/**
			 * Initialize
			 *
			 * @since 1.0.0
			 */
			$this->initialize();

		} // end constructor

		/**
		 * Initialize DFBM Modules
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			if ( is_admin() )
				return add_action( 'et_builder_modules_load', [ $this, 'modules' ] );

			$this->modules();

		} // end initialize

		/**
		 * Instantiate Modules
		 *
		 * @since 1.0.0
		 */
		public function modules()
		{

			$slugs = [ 'blog', 'lightblog' ];

			foreach ( $slugs as $slug ) :

				$class = 'dfbmControllerModules' . ucfirst( $slug );

				new $class;

				$this->slugs[] = 'et_pb_' . DFBM()->prefix() . '_' . $slug;

			endforeach;

			DFBM()->setLayout( $this->slugs, 'slugs' );

		} // end modules
	} // end class
} // end if
