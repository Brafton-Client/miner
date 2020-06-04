<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Settings
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerSettings' ) )
{

	class dfbmControllerSettings
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $options;

		private $shortname;

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
		 * Add the settings to the settings panel
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			add_action( 'admin_init', [ $this, 'addSettings' ] );

			add_action( 'et_epanel_changing_options', [ $this, 'addSettings' ] );

		} // end initialize

		/**
		 * Set the global setting-options
		 *
		 * @since 1.0.0
		 */
		private function setOptions( $settings )
		{

			global $options;

			$options = $settings;

		} // end setOptions

		/**
		 * Adjust options array
		 *
		 * @since 1.0.0
		 */
		public function addSettings()
		{

			global $shortname, $options;

			$pos   = 0;

			$found = false;

			foreach ( $options as $key ) :

			   if ( isset( $key['id'] ) && $shortname . '_smooth_scroll' == $key['id'] ) :

			   		$found = true;

					break;

				endif;

			   $pos++;

			endforeach;

			if ( $found && $pos > 0 ) :

				$array1 = array_slice( $options, 0, $pos + 1 );
				$array2 = array_slice( $options, $pos + 1 );

				$settings =
				[

					[

						'name' => esc_html__( 'Filterable Blogs Search', DFBM()->domain() ),
						'id' => $shortname . '_dfbm_archive_search',
						'type' => 'checkbox',
						'std' => 'false',
						'desc' => esc_html__( 'Enable "Divi - Filerable Blogs Module" for your search-archives.', DFBM()->domain() )

					],

					[

						'name' => esc_html__( 'Filterable Blogs Author', DFBM()->domain() ),
						'id' => $shortname . '_dfbm_archive_author',
						'type' => 'checkbox2',
						'std' => 'false',
						'desc' => esc_html__( 'Enable "Divi - Filerable Blogs Module" for your author-archives.', DFBM()->domain() )

					],

					[

						'name' => esc_html__( 'Filterable Blogs Archives', DFBM()->domain() ),
						'id' => $shortname . '_dfbm_archive_archive',
						'type' => 'checkbox',
						'std' => 'false',
						'desc' => esc_html__( 'Enable "Divi - Filerable Blogs Module" for your category- and tag-archives.', DFBM()->domain() )

					],

				];

				if ( class_exists( 'WooCommerce' ) ) :

					$settings[] =
					[

						'name' => esc_html__( 'Filterable Blogs WooCommerce', DFBM()->domain() ),
						'id' => $shortname . '_dfbm_archive_woocommerce',
						'type' => 'checkbox2',
						'std' => 'false',
						'desc' => esc_html__( 'Enable "Divi - Filerable Blogs Module" for your WooCommerce shop-archives.', DFBM()->domain() )

					];

				endif;

				$settings[] =
				[

					'name' => esc_html__( 'Filterable Blogs Light Layouts', DFBM()->domain() ),
					'id' => $shortname . '_dfbm_archive_light',
					'type' => 'checkbox',
					'std' => 'false',
					'desc' => esc_html__( 'Enable the "Divi - Filterable Blog Module Light" layouts for your search, author, category, tag and WooCommerce archives.', DFBM()->domain() )

				];

				$settings[] =
				[

					'name' => esc_html__( 'Filterable Blogs Uninstall', DFBM()->domain() ),
					'id' => $shortname . '_dfbm_delete_on_uninstall',
					'type' => 'checkbox',
					'std' => 'false',
					'desc' => esc_html__( 'Delete all "Divi - Filterable Blog Module" datas on uninstall. This operation can not be undone. Please note that you must manually delete the module shortcodes added to your posts. You should do this before uninstalling the plugin. You can use the shortcode-finder, that is linked below, to find the posts where the shortcodes were added: ', DFBM()->domain() ) . '<a href="https://gist.github.com/d07e5fa6a455c03db1b944bec985a98c" target="_blank">Shortcode Finder</a>',

				];
			endif;

			$this->setOptions( array_merge( $array1, $settings, $array2 ) );

		} // end addSettings
	} // end class
} // end if
