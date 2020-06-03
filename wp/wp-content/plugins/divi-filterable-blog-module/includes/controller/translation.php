<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Translation
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerTranslation' ) )
{

	class dfbmControllerTranslation
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
			$this->initialize();

		} // end constructor

		/**
		 * Load the textdomains
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			$locale = apply_filters( 'dfbm_translation_locale', get_locale(), DFBM()->domain() );

			load_textdomain( DFBM()->domain(), WP_LANG_DIR . '/plugins/' . DFBM()->domain() . '-' . $locale . '.mo' );

			load_plugin_textdomain( DFBM()->domain(), false, DFBM()->relAts() . 'lang/' );

		} // end initialize
	} // end class
} // end if
