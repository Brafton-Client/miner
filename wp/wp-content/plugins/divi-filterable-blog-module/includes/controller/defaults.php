<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Defaults
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerDefaults' ) )
{

	class dfbmControllerDefaults
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $dfbm;

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
		 * Add default values for the module fonts eg
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			add_filter( 'et_set_default_values', [ $this, 'setDefaults' ] );


		} // end initialize

		/**
		 * Set Defaults
		 *
		 * @since 1.0.0
		 */
		public function setDefaults( $defaults )
		{

			$fS = '100%';
			$lS = '0px';
			$lH = '1.7em';
			$bW = '1px';
			$pf = '16px';
			$mf = '12px';
			$hs = '1.4em';

			$this->dfbm = array(

				'et_pb_dfbm_blog-post_header_font_size'      			  => $hs,
				'et_pb_dfbm_blog-post_header_letter_spacing' 			  => $lS,
				'et_pb_dfbm_blog-post_header_line_height'    			  => $lH,

				'et_pb_dfbm_blog-post_meta_font_size'        			  => $mf,
				'et_pb_dfbm_blog-post_meta_letter_spacing'   			  => $lS,
				'et_pb_dfbm_blog-post_meta_line_height'      			  => $lH,

				'et_pb_dfbm_blog-post_meta_link_font_size'        		  => $mf,
				'et_pb_dfbm_blog-post_meta_link_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-post_meta_link_line_height'      		  => $lH,

				'et_pb_dfbm_blog-post_content_font_size'        		  => $fS,
				'et_pb_dfbm_blog-post_content_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-post_content_line_height'      		  => $lH,

				'et_pb_dfbm_blog-post_body_font_size'        			  => $fS,
				'et_pb_dfbm_blog-post_body_letter_spacing'   			  => $lS,
				'et_pb_dfbm_blog-post_body_line_height'      			  => $lH,

				'et_pb_dfbm_blog-pagination_text_font_size'        		  => $pf,
				'et_pb_dfbm_blog-pagination_text_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-pagination_text_line_height'      		  => $pf,

				'et_pb_dfbm_blog-pagination_text_current_font_size'       => $pf,
				'et_pb_dfbm_blog-pagination_text_current_letter_spacing'  => $lS,
				'et_pb_dfbm_blog-pagination_text_current_line_height'     => $pf,

				'et_pb_dfbm_blog-price_text_font_size'       			  => $fS,
				'et_pb_dfbm_blog-price_text_letter_spacing'  			  => $lS,
				'et_pb_dfbm_blog-price_text_line_height'     			  => $lH,

				'et_pb_dfbm_blog-onsale_text_font_size'      			  => $fS,
				'et_pb_dfbm_blog-onsale_text_letter_spacing' 			  => $lS,
				'et_pb_dfbm_blog-onsale_text_line_height'    			  => $lH,


				'et_pb_dfbm_blog-post_header_fb_font_size'      		  => $hs,
				'et_pb_dfbm_blog-post_header_fb_letter_spacing' 		  => $lS,
				'et_pb_dfbm_blog-post_header_fb_line_height'    		  => $lH,

				'et_pb_dfbm_blog-post_meta_fb_font_size'        		  => $mf,
				'et_pb_dfbm_blog-post_meta_fb_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-post_meta_fb_line_height'      		  => $lH,

				'et_pb_dfbm_blog-post_meta_link_fb_font_size'             => $mf,
				'et_pb_dfbm_blog-post_meta_link_fb_letter_spacing'        => $lS,
				'et_pb_dfbm_blog-post_meta_link_fb_line_height'           => $lH,

				'et_pb_dfbm_blog-post_content_fb_font_size'        		  => $fS,
				'et_pb_dfbm_blog-post_content_fb_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-post_content_fb_line_height'      		  => $lH,

				'et_pb_dfbm_blog-post_body_fb_font_size'        		  => $fS,
				'et_pb_dfbm_blog-post_body_fb_letter_spacing'   		  => $lS,
				'et_pb_dfbm_blog-post_body_fb_line_height'      		  => $lH,

				'et_pb_dfbm_blog-price_text_fb_font_size'       		  => $fS,
				'et_pb_dfbm_blog-price_text_fb_letter_spacing'  		  => $lS,
				'et_pb_dfbm_blog-price_text_fb_line_height'     		  => $lH,

				'et_pb_dfbm_blog-onsale_text_fb_font_size'      		  => $fS,
				'et_pb_dfbm_blog-onsale_text_fb_letter_spacing' 		  => $lS,
				'et_pb_dfbm_blog-onsale_text_fb_line_height'    		  => $lH,

				'et_pb_dfbm_blog-border_width'               			  => $bW,
				'et_pb_dfbm_blog_light-border_width'               		  => $bW,

				'et_pb_dfbm_blog-read_button_feat_font_size'              => $pf,
				'et_pb_dfbm_blog-read_button_feat_border_radius'          => $lS,
				'et_pb_dfbm_blog-read_button_feat_border_radius_hover'    => $lS,
				'et_pb_dfbm_blog-read_button_feat_border_width'           => $bW,

				'et_pb_dfbm_blog-read_button_filt_font_size'              => $pf,
				'et_pb_dfbm_blog-read_button_filt_border_radius'          => $lS,
				'et_pb_dfbm_blog-read_button_filt_border_radius_hover'    => $lS,
				'et_pb_dfbm_blog-read_button_filt_border_width'           => $bW,

				'et_pb_dfbm_blog-add_button_border_radius'                => $lS,
				'et_pb_dfbm_blog-add_button_border_radius_hover'          => $lS,
				'et_pb_dfbm_blog_light-add_button_border_radius'          => $lS,
				'et_pb_dfbm_blog_light-add_button_border_radius_hover'    => $lS,

			); // end $this->dfbm

			foreach ( $this->dfbm as $key => $val ) :

				$defaults[$key] = [ 'default' => $val ];

			endforeach;

			return $defaults;

		} // end setDefaults
	} // end class
} // end if
