<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Initialize
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerInitialize' ) )
{

	class dfbmControllerInitialize
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $notice;

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
			$this->notice = [];

			/**
			 * Let the magic happens
			 *
			 * @since 1.0.0
			 */
			$this->initialize();

		} // end constructor

		/**
		 * Check requirements
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			$this->checkPHP();

		} // end initialize

		/**
		 * PHP Version Check
		 *
		 * @since 1.0.0
		 */
		public function checkPHP()
		{

			if ( version_compare( PHP_VERSION, '5.6' ) < 0 ) :

				$this->notice[] = esc_html__( 'As described in the product description, the PHP version must be at least 5.6 for this plugin to work.', DFBM()->domain() );

				$this->deactivatePlugin();

			endif;

			add_action( 'after_setup_theme', [ $this, 'checkRequired' ], 20 );

		} // end checkPHP

		/**
		 * Checking Requirements
		 *
		 * @since 1.0.0
		 */
		public function checkRequired()
		{

			if ( ! DFBM()->theme() )
				$this->notice[] = esc_html__( 'The Divi Builder must be active for this plugin to work.', DFBM()->domain() );

			if ( ! empty( $this->notice ) ) :

				array_unshift( $this->notice, DFBM()->name() . esc_html__( ' Error(s): ', DFBM()->domain() ) );

				$this->notice[] = esc_html__( 'The plugin has been disabled. Please fix the error(s) and try again.', DFBM()->domain() );

				$this->adminNotice();

				$this->deactivatePlugin();

			else :

				add_action( 'init', [ $this, 'setClasses' ] );

			endif;

		} // end checkRequired

		/**
		 * Add admin notice
		 *
		 * @since 1.0.0
		 */
		private function adminNotice()
		{

			add_action( 'admin_notices', function()
			{

				echo '<div class="error"><p>' . implode( ' ', $this->notice ) . '</p></div>';

			}); // end add_action
		} // end adminNotice

		/**
		 * Deactivate the plugin
		 *
		 * @since 1.0.0
		 */
		private function deactivatePlugin()
		{

			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			deactivate_plugins( plugin_basename( DFBM()->file() ) );

		} // end deactivatePlugin

		/**
		 * Check which classes must be loaded
		 *
		 * @since 1.0.0
		 */
		public function setClasses()
		{

			new dfbmControllerTranslation;

			if ( is_admin() ) :

				$rq = $_REQUEST;

				$this->checkUpdate();

				new dfbmControllerAjax;

				new dfbmControllerAdmin;

				new dfbmControllerColumns;

				new dfbmControllerDefaults;

				new dfbmControllerModules;

				if ( ( isset( $rq['action'] )  && 'save_epanel' == $rq['action'] )
				     || ( isset( $rq['page'] ) && in_array( $rq['page'], [ 'et_divi_options', 'et_extra_options' ] ) ) )
					new dfbmControllerSettings;

				if ( ! ( new dfbmModelGet )->option( DFBM()->prefix() . '_layouts_added' ) )
					new dfbmControllerLayouts;
?>
<?php		else :

				if ( apply_filters( 'dfbm_use_archive_templates', true ) ) :

					global $shortname;

					$checkQuery = false;

					if ( 'on' == ( $opt = et_get_option( $shortname . '_dfbm_archive_search', false ) ) )
						$checkQuery = true;

					DFBM()->setLayout( $opt, 'archSearch' );

					if ( 'on' == ( $opt = et_get_option( $shortname . '_dfbm_archive_author', false ) ) )
						$checkQuery = true;

					DFBM()->setLayout( $opt, 'archAuthor' );

					if ( 'on' == ( $opt = et_get_option( $shortname . '_dfbm_archive_archive', false ) ) )
						$checkQuery = true;

					DFBM()->setLayout( $opt, 'archArchive' );

					if ( 'on' == ( $opt = et_get_option( $shortname . '_dfbm_archive_woocommerce', false ) ) )
						$checkQuery = true;

					DFBM()->setLayout( $opt, 'archWoo' );

					if ( $checkQuery )
						new dfbmControllerQuery;

				endif;

				add_action( 'et_builder_modules_load', [ $this, 'setFrontend' ] );

			endif;
		} // end setClasses

		/**
		 * Set Frontend
		 *
		 * @since 1.0.0
		 */
		public function setFrontend()
		{

			new dfbmControllerModules;

			new dfbmControllerEnqueue;

		} // end setFrontend

		/**
		 * Check for updates
		 *
		 * @since 1.0.0
		 */
		public function checkUpdate()
		{

			try
			{

				new dfbmUpdateInitialize();

			} // end try

			catch ( Exception $e )
			{

				$this->notice[] = esc_html__( 'During the update attempt the following error occurred: ', DFBM()->domain() ) . $e->getMessage();

				$this->adminNotice();

			} // end catch
		} // end checkUpdate
	} // end class
} // end if
