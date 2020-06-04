<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Version
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerVersion' ) )
{

	class dfbmControllerVersion
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $version;

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
			$this->version = ( new dfbmModelGet )->option( 'dfbm_version' );

		} // end constructor

		/**
		 * Set version number
		 *
		 * @since 1.0.0
		 */
		public function setVersion( $version )
		{

			( new dfbmModelSet )->option( 'dfbm_version', $version );

		} // end setVersion

		/**
		 * Get version number
		 *
		 * @since 1.0.0
		 */
		public function getVersion()
		{

			return $this->version;

		} // end getVersion
	} // end class
} // end if
