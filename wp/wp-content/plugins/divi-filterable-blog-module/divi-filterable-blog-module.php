<?php
/*
Plugin Name: Divi - Filterable Blog Module
Plugin URI: https://indikator-design.com/bring-your-divi-blog-to-the-next-level/
Description: A Filterable Blog Module for Divi, based on ajax techniques.
Version: 1.0.10

Author: Bruno Bouyajdad | Indikator Design
Author URI: https://indikator-design.com
Author Email: contact@indikator-design.com
Text Domain: divi-filterable-blog-module
Domain Path: /assets/lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2018 Bruno Bouyajdad ( https://indikator-design.com, contact@indikator-design.com )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Initialize
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmPluginInitialize' ) )
{

	class dfbmPluginInitialize
	{

		/**
		 * Define plugin version
		 *
		 * @since	1.0.0
		 */
		const VERSION = '1.0.10';

		/**
		 * Define this file
		 *
		 * @since	1.0.0
		 */
		const FILE    = __FILE__;

		/**
		 * Define Textdomain
		 *
		 * @since	1.0.0
		 */
		const DOMAIN  = 'divi-filterable-blog-module';

		/**
		 * Define plugin prefix
		 *
		 * @since	1.0.0
		 */
		const PREFIX  = 'dfbm';

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			/**
			 * Include autoloader
			 *
			 * @since	1.0.0
			 */
			require_once( 'includes/controller/autoloader.php' );

			new dfbmControllerAutoloader( self::FILE, self::PREFIX, 'includes' );

			/**
			 * Instantiate the plugin
			 *
			 * @since	1.0.0
			 */
			add_action( 'plugins_loaded', function(){ new dfbmControllerInstance; }, 11 );

		} // end constructor
	} // end class
} // end if

new dfbmPluginInitialize;
