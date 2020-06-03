<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Admin
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerAdmin' ) )
{

	class dfbmControllerAdmin
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
		 * Initialize
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );

		} // end initialize

		/**
		 * Version check
		 *
		 * @since 1.0.0
		 */
		protected function versionCheck()
		{

			$version = new dfbmControllerVersion;

			if ( DFBM()->version() != $version->getVersion() ) :

				$version->setVersion( DFBM()->version() );

				return true;

			endif;

			return false;

		} // end versionCheck

		/**
		 * Enqueue styles and scripts
		 *
		 * @since 1.0.0
		 */
		public function enqueue()
		{

			global $typenow, $pagenow;

			if ( 'edit.php' != $pagenow && in_array( $typenow, et_builder_get_builder_post_types() ) ) :

				global $post;

				if ( $post ) :

					$slug = DFBM()->prefix() . '-admin';

					wp_enqueue_style( $slug, DFBM()->assUrl() .'css/' .  $slug . DFBM()->suffix() . '.css', [], DFBM()->version() );

					wp_enqueue_script( $slug, DFBM()->assUrl() . 'js/' . $slug . DFBM()->suffix() . '.js', [ 'jquery' ], DFBM()->version(), true );

					$localize =
					[

						'id'      => $post->ID,
						'prfix'   => DFBM()->prefix(),
						'slugs'   => DFBM()->getLayout()->slugs,
						'new'     => $this->versionCheck() ? true : false,
						'nonce'   => wp_create_nonce( 'dfbm-nonce-value' ),
						'error'   => esc_html__( 'Cache Error. Please reload the page.', DFBM()->domain() ),
						'noSave'  => esc_html__( 'While saving the options an error occured. Please save the layout, then open and close the \'' . DFBM()->name() . '\' again.', DFBM()->domain() ),

					];

					wp_localize_script( $slug, 'dfbmPHP', $localize );

					add_action( 'admin_footer', function()
					{

						$style = 'display:block;margin-bottom:30px;font-size:14px;font-style:italic;color:#A0A9B2;';

						$desc1 = esc_html__( 'Here you can make basic settings for the fonts of the module, which you can refine in the following settings.', DFBM()->domain() );

						$desc2 = esc_html__( 'Here you can make basic settings especially for the fonts of the filterable-post-area, which you can refine in the following settings.', DFBM()->domain() );

						$desc3 = esc_html__( 'In this font set ( until - Post Content Text - ) you can set the fonts for the featured- and filterable-posts. If you want to set different colors for both areas ( independent fonts button above enabled ), you can make the settings for the featured-posts here.', DFBM()->domain() );

						$desc4 = esc_html__( 'In this font set ( until - Post Content Filterable Posts Text - ) you can overwrite the font settings above for the filterable-posts.', DFBM()->domain() );

						echo <<<STYLE
							<style>[data-option_name="post_body_font"]::before{content:'{$desc1}';{$style}}[data-option_name="post_body_fb_font"]::before{content:'{$desc2}';{$style}}[data-option_name="post_header_font"]::before{content:'{$desc3}';{$style}}[data-option_name="post_header_fb_font"]::before{content:'{$desc4}';{$style}}</style>
STYLE;

					}); // end add_action
				endif;
			endif;

			if ( ET_BUILDER_LAYOUT_POST_TYPE == $typenow )
			{

				$slug = DFBM()->prefix() . '-layout';

				wp_enqueue_script( $slug, DFBM()->assUrl() . 'js/' . $slug . DFBM()->suffix() . '.js', [ 'jquery' ], DFBM()->version(), true );

			} // end if
		} // end enqueue
	} // end class
} // end if
