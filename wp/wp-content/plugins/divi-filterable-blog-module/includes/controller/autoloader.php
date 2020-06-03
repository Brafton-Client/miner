<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Autoloader
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerAutoloader' ) )
{

	class dfbmControllerAutoloader
	{

		/**
		 * Define Properties
		 *
		 * @since	1.0.0
		 */
		private $file;

		private $prefix;

		private $suffix;

		private $folder;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct( $file, $prefix, $folder = false )
		{

			/**
			 * Set properties
			 *
			 * @since 1.0.0
			 */
			$this->file   = $file;

			$this->prefix = $prefix;

			$this->folder = $folder ? $folder . '/' : '';

			$this->suffix = '.' . pathinfo( __FILE__, PATHINFO_EXTENSION );

			/**
			 * Initialize
			 *
			 * @since 1.0.0
			 */
			$this->initialize();

		} // end constructor

		/**
		 * Initialize
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			spl_autoload_register( [ $this, 'getFile' ], true );

		} // end initialize

		/**
		 * Get path and file from classname
		 *
		 * @since 1.0.0
		 */
		private function getFile( $class )
		{

			if ( ! class_exists( $class ) ) :

				$temp = preg_split( '/(?=[A-Z])/', $class );

				if ( $this->prefix == array_shift( $temp ) ) :

					$child = '';

					if ( 4 == count( $temp ) && 'Modules' == next( $temp ) )
						$child = ucfirst( array_pop( $temp ) );

					$path = $this->folder . strtolower( implode( $temp, '/' ) ) . $child . $this->suffix;

					$file = trailingslashit( dirname( $this->file ) ) . $path;

					if ( is_file( $file ) )
						require_once( $file );

				endif;
			endif;
		} // end getFile
	} // end class
} // end if
