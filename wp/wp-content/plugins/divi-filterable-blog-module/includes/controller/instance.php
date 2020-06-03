<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Instance
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerInstance' ) )
{

	class dfbmControllerInstance
	{

		use dfbmTraitConstants;

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private static $layout;

		private static $instance;

		private static $maxQuery;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			/**
			 * Initialize properties
			 *
			 * @since 1.0.0
			 */
			$this->initConstants();

			/**
			 * Singleton pattern object
			 *
			 * @since	1.0.9.7
			 */
			if ( ! function_exists( 'DFBM' ) )
			{

				function DFBM(){ return dfbmControllerInstance::instance(); }

				/**
				 * Call the main controller
				 *
				 * @since 1.0.9.7
				 */
				new dfbmControllerInitialize;

			} // end if
		} // end constructor

		/**
		 * Global instance
		 *
		 * @since	1.0.0
		 */
		public static function instance()
		{

			if ( is_null( self::$instance ) ) :

				self::$instance = new self();

				self::$layout   = new stdClass;

				self::$maxQuery = new stdClass;

			endif;

			return self::$instance;

		} // end instance

		/**
		 * Get maxQuery
		 *
		 * @since	1.0.0
		 */
		public function getQuery()
		{

			return self::$maxQuery;

		} // end maxQuery

		/**
		 * Set maxQuery
		 *
		 * @since	1.0.0
		 */
		public function setQuery( $value )
		{

			self::$maxQuery = $value;

		} // end maxQuery

		/**
		 * Get Layout
		 *
		 * @since	1.0.0
		 */
		public function getLayout()
		{

			return self::$layout;

		} // end Layout

		/**
		 * Set Layout
		 *
		 * @since	1.0.0
		 */
		public function setLayout( $value, $key = false )
		{

			if ( $key )
				self::$layout->$key = $value;

			else
				self::$layout = $value;

		} // end Layout
	} // end class
} // end if
