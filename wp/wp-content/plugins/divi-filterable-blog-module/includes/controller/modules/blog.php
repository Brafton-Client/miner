<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

if ( ! class_exists( 'ET_Builder_Module' ) ) return;

/**
 * Divi - Filterable Blog Module - Controller Modules Blog
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerModulesBlog' ) )
{

	class dfbmControllerModulesBlog extends ET_Builder_Module
	{

		/**
		 * Define Props
		 *
		 * @since 1.0.0
		 */
		private $cpts;

		/**
		 * Initialize the module
		 *
		 * @since 1.0.0
		 */
		public function init()
		{

			/**
			 * Set properties
			 *
			 * @since 1.0.0
			 */
			$this->name = esc_html__( DFBM()->name(), DFBM()->domain() );

			$this->slug = 'et_pb_dfbm_blog';

			// $this->fb_support = true;

			$this->main_css_element = '%%order_class%%';

			$this->cpts = dfbmControllerBlogposts::getPosttypes();

			$this->tax  = dfbmControllerBlogposts::taxFields( $this->cpts );

			$fields =
			[

				'dfbm_fullwidth',
				'content_below_image',
				'article_distance',
				'column_max',
				'item_animation',
				'show_posts_featured',
				'posts_featured',
				'featured_overlay_color',
				'layout_before_posts',
				'show_category_filter',
				'category_filter_style',
				'posts_number',
				'show_order_options',
				'order_options_order',
				'order_options_orderby',
				'meta_date',
				'show_thumbnail',
				'thumb_same_height',
				'define_thumb_height',
				'hide_content',
				'content_absolute',
				'content_absolute_event',
				'show_content',
				'show_limit_words',
				'limit_words_count',
				'show_header',
				'header_tag',
				'read_more',
				'read_more_text',
				'show_author',
				'show_date',
				'custom_posttypes',
				'show_star_rating',
				'star_rating_color',
				'star_rating_color_bg',
				'star_rating_color_fb',
				'star_rating_color_bg_fb',
				'show_product_price',
				'show_add_to_cart',
				'add_to_cart_color',
				'show_categories',
				'show_limit_categories',
				'limit_category_count',
				'show_comments',
				'show_pagination',
				'add_more_button',
				'add_more_text',
				'add_more_fullwidth',
				'offset_number',
				'bg_layout',
				'admin_label',
				'module_id',
				'module_class',
				'post_content_background_color',
				'use_inner_shadow',
				'use_dropshadow',
				'use_overlay',
				'overlay_icon_color',
				'hover_overlay_color',
				'hover_icon',
				'use_overlay_featured',
				'use_dfbm_lightbox',
				'lightbox_background',
				'setup_image_pos',
				'lightbox_header',
				'lightbox_close',
				'lightbox_width',
				'videos_in_feed',
				'scroll_animate_offset',
				'scroll_offset_height',
				'scroll_offset_height_mob',
				'different_fonts',
				'cdn_origin',

			];

			$this->whitelisted_fields = array_merge( $fields, $this->tax );

			$this->fields_defaults =
			[

				'dfbm_fullwidth'        	=> [ 'on' ],
				'content_below_image'		=> [ 'off' ],
				'article_distance'   		=> [ 5 ],
				'column_max'		 		=> [ 3 ],
				'item_animation'			=> [ 'screwed' ],
				'show_posts_featured'   	=> [ 'off' ],
				'show_category_filter'  	=> [ 'off' ],
				'category_filter_style' 	=> [ 'nav' ],
				'posts_number'       		=> [ 6 ],
				'show_order_options'		=> [ 'off' ],
				'order_options_order'		=> [ 'DESC' ],
				'order_options_orderby'		=> [ 'date' ],
				'meta_date'          		=> [ 'M j, Y', 'add_default_setting' ],
				'hide_content'		 		=> [ 'off' ],
				'content_absolute'			=> [ 'off' ],
				'content_absolute_event'	=> [ 'on' ],
				'show_thumbnail'     		=> [ 'on' ],
				'thumb_same_height'			=> [ 'off' ],
				'define_thumb_height'		=> [ 235 ],
				'show_content'       		=> [ 'off' ],
				'read_more'          		=> [ 'on' ],
				'show_author'        		=> [ 'on' ],
				'show_date'          		=> [ 'on' ],
				'show_star_rating'	 		=> [ 'on' ],
				'show_product_price' 		=> [ 'on' ],
				'show_add_to_cart'	 		=> [ 'on' ],
				'show_categories'    		=> [ 'on' ],
				'show_limit_categories'		=> [ 'off' ],
				'limit_category_count'		=> [ 3 ],
				'show_limit_words'	 		=> [ 'off' ],
				'limit_words_count'  		=> [ 30 ],
				'show_header'		 		=> [ 'on' ],
				'header_tag'		 		=> [ 'h2' ],
				'show_comments'      		=> [ 'on' ],
				'show_pagination'    		=> [ 'on' ],
				'add_more_button'    		=> [ 'off' ],
				'add_more_fullwidth' 		=> [ 'off' ],
				'offset_number'      		=> [ 0, 'only_default_setting' ],
				'bg_layout'  		 		=> [ 'light' ],
				'use_inner_shadow'	 		=> [ 'on' ],
				'use_dropshadow'     		=> [ 'off' ],
				'use_overlay'        		=> [ 'off' ],
				'use_overlay_featured'		=> [ 'off' ],
				'use_dfbm_lightbox'			=> [ 'off' ],
				'setup_image_pos'    		=> [ 'center' ],
				'lightbox_header'			=> [ '' ],
				'lightbox_close'			=> [ 'Close' ],
				'lightbox_width'			=> [ 80 ],
				'videos_in_feed'			=> [ 'off' ],
				'scroll_animate_offset'		=> [ 'off' ],
				'scroll_offset_height'		=> [ 80 ],
				'scroll_offset_height_mob' 	=> [ 0 ],
				'different_fonts'			=> [ 'off' ],

			];

			$this->options_toggles = array(
				'general'  => array(
					'toggles' => array(
						'layout'           => esc_html__( 'Layout', DFBM()->domain() ),
						'background'       => esc_html__( 'Background', DFBM()->domain() ),
						'featured_posts'   => esc_html__( 'Featured Posts', DFBM()->domain() ),
						'category_nav'     => esc_html__( 'Category Navigation', DFBM()->domain() ),
						'post_options'     => esc_html__( 'Post Options', DFBM()->domain() ),
						'content_elements' => esc_html__( 'Content Elements', DFBM()->domain() ),
						'pagination'       => esc_html__( 'Pagination / Add-More-Button', DFBM()->domain() ),
						'overlay'          => esc_html__( 'Overlay Settings', DFBM()->domain() ),
						'lightbox'         => esc_html__( 'Lightbox Settings', DFBM()->domain() ),
						'script'           => esc_html__( 'Script Settings', DFBM()->domain() ),
						'scroll'           => esc_html__( 'Scroll Animation', DFBM()->domain() ),
					),
				),
				'advanced' => array(
					'toggles' => array(
						'shadow'       => esc_html__( 'Shadow Settings', DFBM()->domain() ),
						'image' => array(
							'title' => esc_html__( 'Image', DFBM()->domain() ),
							'priority' => 51,
						),
						'text'         => array(
							'title'    => esc_html__( 'Text', DFBM()->domain() ),
							'priority' => 49,
						),
					),
				),
			);

			$this->advanced_options = array(
				'fonts' => array(
					'post_body'   => array(
						'label'    => esc_html__( 'Body', DFBM()->domain() ),
						'css'      => array(
							'color'        => "{$this->main_css_element}, {$this->main_css_element} .post-content *",
							'line_height'  => "{$this->main_css_element} p",
						),
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_header' => array(
						'label'    => esc_html__( 'Header', DFBM()->domain() ),
						'css'      => array(
							'main' => "{$this->main_css_element} .entry-title",
							'important' => 'all',
						),
						'font_size' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_meta' => array(
						'label'    => esc_html__( 'Meta', DFBM()->domain() ),
						'css'      => array(
							'main' => "{$this->main_css_element} .post-meta",
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_meta_link' => array(
						'label'    => esc_html__( 'Meta Link', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element}.et_pb_bg_layout_light .et_pb_post .post-meta a,
								{$this->main_css_element}.et_pb_bg_layout_dark .et_pb_post .post-meta a
							",
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_content' => array(
						'label'    => esc_html__( 'Post Content', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element}.et_pb_bg_layout_light .post-content,
								{$this->main_css_element}.et_pb_bg_layout_dark .post-content
							",
						),
						'important' => 'all',
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'pagination_text' => array(
						'label'    => esc_html__( 'Pagination', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element} .dfbm_blog_pagination a,
								{$this->main_css_element} .dfbm_blog_pagination span
							",
							'important' => 'all',
						),
						'depends_show_if'   => 'on',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '100',
								'step' => '1',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '100',
								'step' => '1',
							),
						),
					),
					'pagination_text_current' => array(
						'label'    => esc_html__( 'Pagination Current', DFBM()->domain() ),
						'css'      => array(
							'main' => "{$this->main_css_element} .dfbm_blog_pagination .current",
							'important' => 'all',
						),
						'depends_show_if'   => 'on',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '1',
								'max'  => '100',
								'step' => '1',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '1',
								'max'  => '100',
								'step' => '1',
							),
						),
					),
					'post_body_fb'   => array(
						'label'    => esc_html__( 'Body Filterable Posts', DFBM()->domain() ),
						'css'      => array(
							'color'        => "
											{$this->main_css_element} .filterable-blogposts,
											{$this->main_css_element} .filterable-blogposts .post-content *",
							'line_height'  => "{$this->main_css_element} .filterable-blogposts  p",
						),
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_header_fb' => array(
						'label'    => esc_html__( 'Header Filterable Posts', DFBM()->domain() ),
						'css'      => array(
							'main' => "{$this->main_css_element} .filterable-blogposts .entry-title",
							'important' => 'all',
						),
						'font_size' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_meta_fb' => array(
						'label'    => esc_html__( 'Meta Filterable Posts', DFBM()->domain() ),
						'css'      => array(
							'main' => "{$this->main_css_element} .filterable-blogposts .post-meta",
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_meta_link_fb' => array(
						'label'    => esc_html__( 'Meta Link Filterable Posts', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element}.et_pb_bg_layout_light .filterable-blogposts .et_pb_post .post-meta a,
								{$this->main_css_element}.et_pb_bg_layout_dark .filterable-blogposts .et_pb_post .post-meta a
							",
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'post_content_fb' => array(
						'label'    => esc_html__( 'Post Content Filterable Posts', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element}.et_pb_bg_layout_light .filterable-blogposts .post-content,
								{$this->main_css_element}.et_pb_bg_layout_dark .filterable-blogposts .post-content
								",
						),
						'important' => 'all',
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
				),
				'background' => array(
					'css' => array(
						'main' => "{$this->main_css_element}",
					),
					'settings'  => array(
						'color' => 'alpha',
					),
				),
				'border' => array(
					'settings' => array(
						'color' => 'alpha',
					),
					'css'      => array(
						'main' => "{$this->main_css_element}",
						'important' => 'plugin_only',
					),
				),
				'custom_margin_padding' => array(
					'css' => array(
						'main' => "{$this->main_css_element}",
						'important' => 'all',
					),
				),
				'max_width' => array(),
				'filters' => array(
					'child_filters_target' => array(
						'tab_slug' => 'advanced',
						'toggle_slug' => 'image',
					),
				),
				'image' => array(
					'css' => array(
						'main' => array(
							'%%order_class%% .et_pb_slides',
							'%%order_class%% .et_pb_video_overlay',
							'%%order_class%% .et_pb_image_container',
						),
					),
				),
				'text'      => array(
					'css' => array(
						'text_shadow' => '%%order_class%%',
					),
				),
				'button' => array(
					'read_button_feat' => array(
						'label' => esc_html__( 'Featured Posts - Read More Button', DFBM()->domain() ),
						'css' => array(
							'main' => "{$this->main_css_element} .et_pb_featured_posts .et_pb_button.read-more",
						),
					),
					'read_button_filt' => array(
						'label' => esc_html__( 'Filterable Posts - Read More Button', DFBM()->domain() ),
						'css' => array(
							'main' => "{$this->main_css_element} .filterable-blogposts .et_pb_button.read-more",
						),
					),
					'add_button' => array(
						'label' => esc_html__( 'Add More Button', DFBM()->domain() ),
						'css' => array(
							'main' => "{$this->main_css_element} .et_pb_button.add-more-button",
						),
					),
				),
			);

			if ( class_exists( 'WooCommerce' ) ) :

				$wooFonts =
				[

					'price_text' => array(
						'label'    => esc_html__( 'Price', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element} .price,
								{$this->main_css_element} .price > .woocommerce-Price-amount,
								{$this->main_css_element} .price > .woocommerce-Price-amount .woocommerce-Price-currencySymbol,
								{$this->main_css_element} del,
								{$this->main_css_element} del .woocommerce-Price-amount,
								{$this->main_css_element} del .woocommerce-Price-amount .woocommerce-Price-currencySymbol
							",
							'important' => 'all',
						),
						'depends_show_if'   => 'product',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'onsale_text' => array(
						'label'    => esc_html__( 'Onsale', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element} ins,
								{$this->main_css_element} ins .woocommerce-Price-amount,
								{$this->main_css_element} ins .woocommerce-Price-amount .woocommerce-Price-currencySymbol
							",
							'important' => 'all',
						),
						'depends_show_if'   => 'product',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'price_text_fb' => array(
						'label'    => esc_html__( 'Price Filterable Blogs', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element} .filterable-blogposts .price,
								{$this->main_css_element} .filterable-blogposts .price > .woocommerce-Price-amount,
								{$this->main_css_element} .filterable-blogposts .price > .woocommerce-Price-amount .woocommerce-Price-currencySymbol,
								{$this->main_css_element} .filterable-blogposts del,
								{$this->main_css_element} .filterable-blogposts del .woocommerce-Price-amount,
								{$this->main_css_element} .filterable-blogposts del .woocommerce-Price-amount .woocommerce-Price-currencySymbol
							",
							'important' => 'all',
						),
						'depends_show_if'   => 'product',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
					'onsale_text_fb' => array(
						'label'    => esc_html__( 'Onsale Filterable Blogs', DFBM()->domain() ),
						'css'      => array(
							'main' => "
								{$this->main_css_element} .filterable-blogposts ins,
								{$this->main_css_element} .filterable-blogposts ins .woocommerce-Price-amount,
								{$this->main_css_element} .filterable-blogposts ins .woocommerce-Price-amount .woocommerce-Price-currencySymbol
							",
							'important' => 'all',
						),
						'depends_show_if'   => 'product',
						'font_size' => array(
							'range_settings' => array(
								'min'  => '10',
								'max'  => '400',
								'step' => '10',
							),
						),
						'line_height' => array(
							'range_settings' => array(
								'min'  => '0',
								'max'  => '10',
								'step' => '0.1',
							),
						),
					),
				];

				$this->advanced_options['fonts'] = array_merge( $this->advanced_options['fonts'], $wooFonts );

			endif;

			$this->custom_css_options = [

				'feat_blogs_container' =>
				[

					'label'    => esc_html__( 'Featured Posts - Container', DFBM()->domain() ),
					'selector' => '.et_pb_featured_posts',

				],
				'feat_blogs_inner_article' =>
				[

					'label'    => esc_html__( 'Featured Posts - Inner Article (Box Shadow)', DFBM()->domain() ),
					'selector' => '.et_pb_featured_posts .article-inner',

				],
				'feat_blogs_content_container' =>
				[

					'label'    => esc_html__( 'Featured Posts - Overlay Content Container', DFBM()->domain() ),
					'selector' => '
						.et_pb_featured_posts .et_pb_content_container,
						.et_pb_featured_posts .content-overlay .et_pb_content_container',

				],
				'feat_blogs_content_container_hover' =>
				[

					'label'    => esc_html__( 'Featured Posts - Overlay Content Container:Hover', DFBM()->domain() ),
					'selector' => '
						.et_pb_featured_posts article:hover .et_pb_content_container,
						.et_pb_featured_posts .content-overlay article:hover .et_pb_content_container',

				],
				'feat_blogs_title' =>
				[

					'label'    => esc_html__( 'Featured Posts - Header', DFBM()->domain() ),
					'selector' => '.et_pb_featured_posts .et_pb_post .entry-title',

				],
				'feat_blogs_content_header_before' =>
				[

					'label'    => esc_html__( 'Featured Posts - Overlay Header Click Icon', DFBM()->domain() ),
					'selector' => '
						.et_pb_featured_posts .et_pb_content_container.click::before,
						.et_pb_featured_posts .et_pb_content_container.clicked::before',

				],
				'feat_blogs_post_meta' =>
				[

					'label'    => esc_html__( 'Featured Posts - Meta', DFBM()->domain() ),
					'selector' => '.et_pb_featured_posts .et_pb_post .post-meta',

				],
				'feat_blogs_post_meta_a' =>
				[

					'label'    => esc_html__( 'Featured Posts - Meta Link', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_bg_layout_light .et_pb_featured_posts .et_pb_post .post-meta a,
						{$this->main_css_element} .et_pb_bg_layout_dark .et_pb_featured_posts .et_pb_post .post-meta a",

				],
				'feat_featured_image' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Featured Image / Gallery', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_featured_posts .et_pb_image_container,
						{$this->main_css_element} .et_pb_featured_posts .et_pb_slider",

				],
				'filter_container' =>
				[

					'label'    => esc_html__( 'Category Filter - Container', DFBM()->domain() ),
					'selector' => '.et_pb_blog_filters.clearfix',

				],
				'filter_active_display' =>
				[

					'label'    => esc_html__( 'Category Filter - Active Category Display', DFBM()->domain() ),
					'selector' => '.et_pb_blog_filters .dfbm-active-cat',

				],
				'filter_link_nav' =>
				[

					'label'    => esc_html__( 'Category Filter - Link Navigation Bar', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_blog_filters.nav a,
						{$this->main_css_element} .et_pb_blog_filters.text a .dfbm-sub-menu.first a",

				],
				'filter_link_nav_active' =>
				[

					'label'    => esc_html__( 'Category Filter - Link Navigation Bar Active & Hover', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_blog_filters.nav a.active,
						{$this->main_css_element} .et_pb_blog_filters.nav a:hover,
						{$this->main_css_element} .et_pb_blog_filters.text a .dfbm-sub-menu.first a:hover",

				],
				'filter_link_text' =>
				[

					'label'    => esc_html__( 'Category Filter - Link Text Bar', DFBM()->domain() ),
					'selector' => '.et_pb_blog_filters.text a',

				],
				'filter_link_text_active' =>
				[

					'label'    => esc_html__( 'Category Filter - Link Text Bar Active & Hover', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_blog_filters.text a.active,
						{$this->main_css_element} .et_pb_blog_filters.text a:hover",

				],
				'filter_link_text_separator' =>
				[

					'label'    => esc_html__( 'Category Filter - Link Text Bar Separator', DFBM()->domain() ),
					'selector' => '.et_pb_blog_filter.seperator',

				],
				'filt_blogs_container' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Container', DFBM()->domain() ),
					'selector' => '.filterable-blogposts',

				],
				'filt_blogs_inner_article' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Inner Article (Box Shadow)', DFBM()->domain() ),
					'selector' => '.filterable-blogposts .article-inner',

				],
				'filt_blogs_content_container' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Overlay Content Container', DFBM()->domain() ),
					'selector' => '
						.filterable-blogposts .et_pb_content_container,
						.filterable-blogposts .content-overlay .et_pb_content_container',

				],
				'filt_blogs_content_container_hover' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Overlay Content Container:Hover', DFBM()->domain() ),
					'selector' => '
						.filterable-blogposts article:hover .et_pb_content_container,
						.filterable-blogposts .content-overlay article:hover .et_pb_content_container',

				],
				'filt_blogs_title' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Header', DFBM()->domain() ),
					'selector' => '.filterable-blogposts .et_pb_post .entry-title',

				],
				'filt_blogs_content_header_before' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Overlay Header Click Icon', DFBM()->domain() ),
					'selector' => '
						.filterable-blogposts .et_pb_content_container.click::before,
						.filterable-blogposts .et_pb_content_container.clicked::before',

				],
				'filt_blogs_post_meta' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Meta', DFBM()->domain() ),
					'selector' => '.filterable-blogposts .et_pb_post .post-meta',

				],
				'filt_blogs_post_meta_a' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Meta Link', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .et_pb_bg_layout_light .filterable-blogposts .et_pb_post .post-meta a,
						{$this->main_css_element} .et_pb_bg_layout_dark .filterable-blogposts .et_pb_post .post-meta a",

				],
				'filt_featured_image' =>
				[

					'label'    => esc_html__( 'Filterable Posts - Featured Image / Gallery', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .filterable-blogposts .et_pb_image_container,
						{$this->main_css_element} .filterable-blogposts .et_pb_slider",

				],
				'read_more' =>
				[

					'label'    => esc_html__( 'Read More Button', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.read-more",

				],
				'read_more_after' =>
				[

					'label'    => esc_html__( 'Read More Button::After', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.read-more::after",

				],
				'read_more_hover' =>
				[

					'label'    => esc_html__( 'Read More Button:Hover', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.read-more:hover",

				],
				'read_more_hover_after' =>
				[

					'label'    => esc_html__( 'Read More Button:Hover::After', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.read-more:hover::after",

				],
				'add_more_container' =>
				[

					'label'    => esc_html__( 'Add More Container', DFBM()->domain() ),
					'selector' => '.add-more-section',

				],
				'add_more' =>
				[

					'label'    => esc_html__( 'Add More Button', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.add-more-button",

				],
				'add_more_after' =>
				[

					'label'    => esc_html__( 'Add More Button::After', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.add-more-button::after",

				],
				'add_more_hover' =>
				[

					'label'    => esc_html__( 'Add More Button:Hover', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.add-more-button:hover",

				],
				'add_more_hover_after' =>
				[

					'label'    => esc_html__( 'Add More Button:Hover::After', DFBM()->domain() ),
					'selector' => "body.et_pb_button_helper_class {$this->main_css_element} .et_pb_button.add-more-button:hover::after",

				],
				'pagination_container' =>
				[

					'label'    => esc_html__( 'Pagination Container', DFBM()->domain() ),
					'selector' => '.dfbm_blog_pagination',

				],
				'lightbox_header' =>
				[

					'label'    => esc_html__( 'Lightbox Header', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-header",

				],
				'lightbox_close' =>
				[

					'label'    => esc_html__( 'Lightbox Close Link', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-close,
						.dfbm-lb-close::after",

				],
				'lightbox_close_hover' =>
				[

					'label'    => esc_html__( 'Lightbox Close Link:Hover', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-close:hover,
						.dfbm-lb-close:hover::after",

				],
				'lightbox_title' =>
				[

					'label'    => esc_html__( 'Lightbox Title', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-link .dfbm-lb-title",

				],
				'lightbox_title_hover' =>
				[

					'label'    => esc_html__( 'Lightbox Title:Hover', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-link .dfbm-lb-title:hover",

				],
				'lightbox_read_more' =>
				[

					'label'    => esc_html__( 'Lightbox Read More', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-read-more .dfbm-lb-title",

				],
				'lightbox_read_more_hover' =>
				[

					'label'    => esc_html__( 'Lightbox Read More:Hover', DFBM()->domain() ),
					'selector' => "
						{$this->main_css_element} .lb-pseudo,
						.dfbm-lb-read-more .dfbm-lb-title:hover",

				],
			];

		} // end init

		function get_fields()
		{

			foreach ( $this->cpts as $cpt ) :

				$cat = dfbmControllerBlogposts::getTaxonomySlug( $cpt, 'cat' );

				$tag = dfbmControllerBlogposts::getTaxonomySlug( $cpt, 'tag' );

				if ( ! $cat || ! $tag )
					continue;

				$options[ $cpt ] = esc_html__( ucfirst( $cpt ), DFBM()->domain() );

				$second['custom_posttypes'] =
				[

					'label'             => esc_html__( 'Posttype', DFBM()->domain() ),
					'type'              => 'select',
					'option_category'   => 'configuration',
					'options'         	=> $options,
					'affects'           => array_merge(
										   [

										   	  'show_star_rating',
										   	  'star_rating_color',
										   	  'star_rating_color_bg',
										   	  'star_rating_color_fb',
										   	  'star_rating_color_bg_fb',
										   	  'show_product_price',
										   	  'show_add_to_cart',
										   	  'add_to_cart_color',

											  'price_text_font',
											  'price_text_text_color',
											  'price_text_line_height',
											  'price_text_font_size',
											  'price_text_all_caps',
											  'price_text_letter_spacing',

											  'onsale_text_font',
											  'onsale_text_text_color',
											  'onsale_text_line_height',
											  'onsale_text_font_size',
											  'onsale_text_all_caps',
											  'onsale_text_letter_spacing',

											  'price_text_fb_font',
											  'price_text_fb_text_color',
											  'price_text_fb_line_height',
											  'price_text_fb_font_size',
											  'price_text_fb_all_caps',
											  'price_text_fb_letter_spacing',

											  'onsale_text_fb_font',
											  'onsale_text_fb_text_color',
											  'onsale_text_fb_line_height',
											  'onsale_text_fb_font_size',
											  'onsale_text_fb_all_caps',
											  'onsale_text_fb_letter_spacing',

										   ], $this->tax ),
					'description'       => esc_html__( 'Select the posttype that you would like to use', DFBM()->domain() ),
					'tab_slug'          => 'general',
					'toggle_slug'       => 'post_options',
					'computed_affects'  => [ '__posts', ],

				];

				$second['include_' . $cpt . '_categories'] =
				[

					'label'            => esc_html__( 'Include ' . ucfirst( $cpt ) . ' Categories', DFBM()->domain() ),
					'renderer'         => dfbmControllerBlogposts::getCategories( [], $cat, 'include_' . $cpt, $cpt ),
					'option_category'  => 'basic_option',
					'description'      => esc_html__( 'Select the categories you would like to include in the feed. If none is selected, all available categories are automatically included.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => $cpt,

				];

				$second['exclude_' . $cpt . '_categories'] =
				[

					'label'            => esc_html__( 'Exclude ' . ucfirst( $cpt ) . ' Categories', DFBM()->domain() ),
					'renderer'         => dfbmControllerBlogposts::getCategories( [], $cat, 'exclude_' . $cpt, $cpt ),
					'option_category'  => 'basic_option',
					'description'      => esc_html__( 'Select the categories you don\'t want to include in the feed.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => $cpt,

				];

				$second['include_' . $cpt . '_tags'] =
				[

					'label'            => esc_html__( 'Include ' . ucfirst( $cpt ) . ' Tags', DFBM()->domain() ),
					'renderer'         => dfbmControllerBlogposts::getTags( [], $tag, 'include_' . $cpt, $cpt ),
					'option_category'  => 'basic_option',
					'description'      => esc_html__( 'Select the tags you would like to include in the feed. If none is selected, all available tags are automatically included.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => $cpt,

				];

				$second['exclude_' . $cpt . '_tags'] =
				[

					'label'            => esc_html__( 'Exclude ' . ucfirst( $cpt ) . ' Tags', DFBM()->domain() ),
					'renderer'         => dfbmControllerBlogposts::getTags( [], $tag, 'exclude_' . $cpt, $cpt ),
					'option_category'  => 'basic_option',
					'description'      => esc_html__( 'Select the tags you don\'t want to include in the feed.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => $cpt,

				];

			endforeach;

			$dependFB = $this->whitelisted_fields;

			$first =
			[

				'dfbm_fullwidth' => array(
					'label'           => esc_html__( 'Layout', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'on'  => esc_html__( 'Fullwidth', DFBM()->domain() ),
						'off' => esc_html__( 'Masonry', DFBM()->domain() ),
					),
					'affects' => array(
						'column_max',
						'content_below_image',
						'thumb_same_height',
					),
					'description'      => esc_html__( 'Toggle between the various blog layout types.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'layout',
					'computed_affects' => array(
						'__posts',
					),
				),
				'content_below_image' => array(
					'label'           => esc_html__( 'Content below the Image', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description'      => esc_html__( 'This will show the content below the featured image.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'layout',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'article_distance' => array(
					'label'           => esc_html__( 'Article Distance', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '5',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '30',
						'step' => '1',
					),
					'description'      => esc_html__( 'Define the space between the items in pixel for the featured- and the filterable posts.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'layout',
					'computed_affects' => array(
						'__posts',
					),
				),
				'column_max' => array(
					'label'           => esc_html__( 'Maximum Columns', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '3',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '5',
						'step' => '1',
					),
					'description'      => esc_html__( 'Define the maximum columns for your masonry-posts.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'layout',
					'depends_show_if'  => 'off',
					'computed_affects' => array(
						'__posts',
					),
				),
				'item_animation' => array(
					'label'           => esc_html__( 'Blog Post Animation', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'screwed' => esc_html__( 'Screwed-In', DFBM()->domain() ),
						'faded'   => esc_html__( 'Fade-In', DFBM()->domain() ),
					),
					'description'      => esc_html__( 'Toggle between the various blog post animation types.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'layout',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_posts_featured' => array(
					'label'           => esc_html__( 'Show Featured Posts', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will turn featured posts on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'featured_posts',
					'affects' => array(
						'posts_featured',
						'featured_overlay_color',
						'layout_before_posts',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'posts_featured'      => array(
					'label'           => esc_html__( 'Featured Posts', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Here you can paste the comma separated IDs of your featured posts (3 max). The posts are displayed in the order of the IDs.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'featured_posts',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'featured_overlay_color' => array(
					'label'              => esc_html__( 'Featured Posts Overlay Color', DFBM()->domain() ),
					'type'               => 'color-alpha',
					'custom_color'       => true,
					'description'        => esc_html__( 'Here you can define a custom color for the featured posts overlay.', DFBM()->domain() ),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'featured_posts',
					'depends_show_if' => 'on',
				),
				'layout_before_posts' => array(
					'label'           => esc_html__( 'Show Layout Before Filterable Posts', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Here you can paste a Layout-ID to display this layout between the fetaured- and the filterable posts.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'featured_posts',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_category_filter' => array(
					'label'            => esc_html__( 'Show Category Filter', DFBM()->domain() ),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options' => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will turn the category filter on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'category_nav',
					'affects' => array(
						'category_filter_style',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'category_filter_style' => array(
					'label'           => esc_html__( 'Category Filter Style', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'configuration',
					'options' => array(
						'nav'  => esc_html__( 'Navigation Bar', DFBM()->domain() ),
						'text' => esc_html__( 'Text with Seperators', DFBM()->domain() ),
					),
					'depends_show_if' => 'on',
					'description'     => esc_html__( 'Choose between a navigation bar and a text style with a seperator.', DFBM()->domain() ),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'category_nav',
					'computed_affects' => array(
						'__posts',
					),
				),
			];

			$third =
			[

				'posts_number' => array(
					'label'           => esc_html__( 'Posts Number', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '6',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '30',
						'step' => '1',
					),
					'description' => esc_html__( 'Define the number of blogs that should be displayed per page.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'post_options',
					'tab_slug' => 'general',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_order_options' => array(
					'label'           => esc_html__( 'Show Order Options', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options' => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will turn order options on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'post_options',
					'affects' => array(
						'order_options_order',
						'order_options_orderby',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'order_options_order' => array(
					'label'           => esc_html__( 'Order', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options' => array(
						'DESC'  => esc_html__( 'DESC', DFBM()->domain() ),
						'ASC' => esc_html__( 'ASC', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Toggle between DESC (from highest to lowest) and ASC (from lowest to highest).', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
				),
				'order_options_orderby' => array(
					'label'             => esc_html__( 'Orderby', DFBM()->domain() ),
					'type'              => 'select',
					'option_category'   => 'layout',
					'options' => array(
						'date'             => esc_html__( 'Date', DFBM()->domain() ),
						'title'            => esc_html__( 'Title', DFBM()->domain() ),
						'author'           => esc_html__( 'Author', DFBM()->domain() ),
						'comment_count'    => esc_html__( 'Comment Count', DFBM()->domain() ),
						'menu_order title' => esc_html__( 'Menu Order Title', DFBM()->domain() ),
						'modified'         => esc_html__( 'Modified', DFBM()->domain() ),
						'rand'             => esc_html__( 'Random', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Toggle between orderby parameters.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
				),
				'offset_number' => array(
					'label'           => esc_html__( 'Offset Number', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description' => esc_html__( 'Choose how many posts you would like to offset by.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'post_options',
					'computed_affects' => array(
						'__posts',
					),
				),
				'hide_content' => array(
					'label'           => esc_html__( 'Hide the Content', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options' => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will turn the content below the image on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'post_content_background_color' => array(
					'label'        => esc_html__( 'Content Background Color', DFBM()->domain() ),
					'type'         => 'color-alpha',
					'custom_color' => true,
					'description' => esc_html__( 'Here you can specify the background color of the content area.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
				),
				'content_absolute' => array(
					'label'           => esc_html__( 'Show Content as Overlay', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options' => array(
						'off' => esc_html__( 'Off', DFBM()->domain() ),
						'on'  => esc_html__( 'On', DFBM()->domain() ),
					),
					'description' => esc_html__( 'If enabled, the content from the filterable posts will be used as overlay (like it is used for the featured posts).', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'content_absolute_event' => array(
					'label'           => esc_html__( 'Content Overlay Event', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options' => array(
						'on'  => esc_html__( 'Click', DFBM()->domain() ),
						'off' => esc_html__( 'Hover', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can specify whether the content overlay appears with a click or by hover.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_thumbnail' => array(
					'label'           => esc_html__( 'Show Featured Image', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will turn featured images on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'thumb_same_height' => array(
					'label'           => esc_html__( 'Same Height for Images', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options' => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'This will adjust the image height to a pre-defined value.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'affects' => array(
						'define_thumb_height',
					),
					'depends_show_if'  => 'off',
					'computed_affects' => array(
						'__posts',
					),
				),
				'define_thumb_height' => array(
					'label'            => esc_html__( 'Image Height', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '235',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '500',
						'step' => '10',
					),
					'description' => esc_html__( 'Define the height for the images in pixel.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_header' => array(
					'label'           => esc_html__( 'Show Post Header', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn post header on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'affects' => array(
						'header_tag',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'header_tag' => array(
					'label'           => esc_html__( 'Post Header Tag', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'configuration',
					'options'         => array(
						'h2' => esc_html__( 'h2', DFBM()->domain() ),
						'h3' => esc_html__( 'h3', DFBM()->domain() ),
						'h4' => esc_html__( 'h4', DFBM()->domain() ),
					),
					'depends_show_if'  => 'on',
					'description' => esc_html__( 'Choose the tag to wrap your header.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_content' => array(
					'label'           => esc_html__( 'Content', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'configuration',
					'options'         => array(
						'excerpt' => esc_html__( 'Show Excerpt', DFBM()->domain() ),
						'content' => esc_html__( 'Show Content', DFBM()->domain() ),
						'none'    => esc_html__( 'None', DFBM()->domain() ),
					),
					'affects' => array(
						'show_limit_words',
					),
					'description' => esc_html__( 'Select whether the excerpt, the content, or neither should be displayed.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_limit_words' => array(
					'label'           => esc_html__( 'Content Limit', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'affects' => array(
						'limit_words_count',
					),
					'description' => esc_html__( 'Turn word count limit on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'depends_show_if_not' => 'none',
					'computed_affects' => array(
						'__posts',
					),
				),
				'limit_words_count' => array(
					'label'           => esc_html__( 'Content Word Count', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '30',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '100',
						'step' => '1',
					),
					'description' => esc_html__( 'Limit the count of words from the content or excerpt.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'depends_show_if' => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_comments' => array(
					'label'           => esc_html__( 'Show Comment Count', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn comment count on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_categories' => array(
					'label'           => esc_html__( 'Show Categories', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'affects' => array(
						'show_limit_categories',
					),
					'description' => esc_html__( 'Turn the category links on or off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_limit_categories' => array(
					'label'             => esc_html__( 'Limit Categories', DFBM()->domain() ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'affects' => array(
						'limit_category_count',
					),
					'description' => esc_html__( 'Turn category count limit on and off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'limit_category_count' => array(
					'label'            => esc_html__( 'Category Count', DFBM()->domain() ),
					'type'             => 'range',
					'option_category'  => 'layout',
					'default'          => '3',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '10',
						'step' => '1',
					),
					'description' => esc_html__( 'Limit the count of categories displayed in your posts.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_author' => array(
					'label'           => esc_html__( 'Show Author', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn on or off the author link.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_date' => array(
					'label'           => esc_html__( 'Show Date', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn the date on or off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'meta_date' => array(
					'label'           => esc_html__( 'Meta Date Format', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description' => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_star_rating' => array(
					'label'           => esc_html__( 'Show Rating Stars', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn product rating stars on or off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => 'product',
				),
				'star_rating_color' => array(
					'label'           => esc_html__( 'Star Rating Color', DFBM()->domain() ),
					'type'            => 'color-alpha',
					'custom_color'    => true,
					'description'     => esc_html__( 'Here you can define a custom color for the rating stars.', DFBM()->domain() ),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'content_elements',
					'depends_show_if' => 'product',
				),
				'star_rating_color_bg' => array(
					'label'            => esc_html__( 'Star Rating Color Background', DFBM()->domain() ),
					'type'             => 'color-alpha',
					'custom_color'     => true,
					'description'      => esc_html__( 'Here you can define a custom color for the rating stars background.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'depends_show_if'  => 'product',
				),
				'star_rating_color_fb' => array(
					'label'            => esc_html__( 'Filterable Blogs Star Rating Color', DFBM()->domain() ),
					'type'             => 'color-alpha',
					'custom_color'     => true,
					'description'      => esc_html__( 'Here you can define a custom color for the filterable blogs rating stars.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'depends_show_if'  => 'product',
				),
				'star_rating_color_bg_fb' => array(
					'label'           => esc_html__( 'Filterable Blogs Star Rating Color Background', DFBM()->domain() ),
					'type'            => 'color-alpha',
					'custom_color'    => true,
					'description'     => esc_html__( 'Here you can define a custom color for the filterable blogs rating stars background.', DFBM()->domain() ),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'content_elements',
					'depends_show_if' => 'product',
				),
				'show_product_price' => array(
					'label'           => esc_html__( 'Show Price', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description'      => esc_html__( 'Turn the price on or off.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => 'product',
				),
				'show_add_to_cart' => array(
					'label'           => esc_html__( 'Show Add to Cart Icon', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'description'      => esc_html__( 'Turn the add to card icon for simple products on or off.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => 'product',
				),
				'add_to_cart_color' => array(
					'label'           => esc_html__( 'Add to Cart Icon Color', DFBM()->domain() ),
					'type'            => 'color-alpha',
					'custom_color'    => true,
					'description'     => esc_html__( 'Here you can define a custom color for the add to card icon.', DFBM()->domain() ),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'content_elements',
					'depends_show_if' => 'product',
				),
				'read_more' => array(
					'label'           => esc_html__( 'Read More Button', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'On', DFBM()->domain() ),
						'off' => esc_html__( 'Off', DFBM()->domain() ),
					),
					'affects' => array(
						'read_more_text',
					),
					'description'      => esc_html__( 'Here you can define whether to show "read more" button or not.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'computed_affects' => array(
						'__posts',
					),
				),
				'read_more_text' => array(
					'label'           => esc_html__( 'Change the text "Read More"', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Here you can change the text "Read More" for the buttons of the individual post items and for the lightbox. Just leave the field blank if you want to use the standard text or change the text using the translation file.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'content_elements',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'show_pagination' => array(
					'label'           => esc_html__( 'Show Pagination / Add More', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
						'off' => esc_html__( 'No', DFBM()->domain() ),
					),
					'affects' => array(
						'add_more_button',
						'pagination_text_font',
						'pagination_text_text_color',
						'pagination_text_line_height',
						'pagination_text_font_size',
						'pagination_text_all_caps',
						'pagination_text_letter_spacing',
						'pagination_text_current_font',
						'pagination_text_current_text_color',
						'pagination_text_current_line_height',
						'pagination_text_current_font_size',
						'pagination_text_current_all_caps',
						'pagination_text_current_letter_spacing',
					),
					'description'      => esc_html__( 'Add pagination or an "add more" button.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'pagination',
					'computed_affects' => array(
						'__posts',
					),
				),
				'add_more_button' => array(
					'label'           => esc_html__( 'Pagination or Add more', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'off' => esc_html__( 'Show Pagination', DFBM()->domain() ),
						'on'  => esc_html__( 'Add More Button', DFBM()->domain() ),
					),
					'depends_show_if' => 'on',
					'affects'         => array(
						'add_more_text',
						'add_more_fullwidth',
					),
					'description'      => esc_html__( 'Toggle between pagination and an "add more" button.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'pagination',
					'computed_affects' => array(
						'__posts',
					),
				),
				'add_more_text' => array(
					'label'           => esc_html__( 'Change the text "Add More Posts"', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Here you can change the text "Add More Posts" for the "add more" button. Just leave the field blank if you want to use the standard text or change the text using the translation file.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'pagination',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'add_more_fullwidth' => array(
					'label'           => esc_html__( 'Fullwidth Add More Button', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'depends_show_if' => 'on',
					'description'      => esc_html__( 'Set "add more" button to fullwidth.', DFBM()->domain() ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'pagination',
					'computed_affects' => array(
						'__posts',
					),
				),
				'use_overlay' => array(
					'label'           => esc_html__( 'Featured Image Overlay', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options'         => array(
						'off' => esc_html__( 'Off', DFBM()->domain() ),
						'on'  => esc_html__( 'On', DFBM()->domain() ),
					),
					'affects' => array(
						'overlay_icon_color',
						'hover_overlay_color',
						'hover_icon',
						'use_overlay_featured',
					),
					'description' => esc_html__( 'If enabled, an overlay and icon will be displayed when a visitors hovers over the featured image of a post.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'overlay',
					'computed_affects' => array(
						'__posts',
					),
				),
				'overlay_icon_color' => array(
					'label'           => esc_html__( 'Overlay Icon Color', DFBM()->domain() ),
					'type'            => 'color',
					'custom_color'    => true,
					'depends_show_if' => 'on',
					'description' => esc_html__( 'Here you can define a custom color for the overlay icon.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'overlay',
				),
				'hover_overlay_color' => array(
					'label'           => esc_html__( 'Hover Overlay Color', DFBM()->domain() ),
					'type'            => 'color-alpha',
					'custom_color'    => true,
					'depends_show_if' => 'on',
					'description' => esc_html__( 'Here you can define a custom color for the overlay.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'overlay',
				),
				'hover_icon' => array(
					'label'               => esc_html__( 'Hover Icon Picker', DFBM()->domain() ),
					'type'                => 'text',
					'option_category'     => 'configuration',
					'class'               => array( 'et-pb-font-icon' ),
					'renderer'            => 'et_pb_get_font_icon_list',
					'renderer_with_field' => true,
					'depends_show_if'     => 'on',
					'description' => esc_html__( 'Here you can define a custom icon for the overlay.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'overlay',
					'computed_affects' => array(
						'__posts',
					),
				),
				'use_overlay_featured' => array(
					'label'           => esc_html__( 'Overlay Featured Posts', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options'         => array(
						'off' => esc_html__( 'Off', DFBM()->domain() ),
						'on'  => esc_html__( 'On', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can also activate the overlays for featured posts.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'overlay',
					'depends_show_if' => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'use_dfbm_lightbox' => array(
					'label'           => esc_html__( 'Use Lightbox', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Turn the lightbox on or off.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'affects'     => array(
						'lightbox_background',
						'lightbox_header',
						'lightbox_close',
						'lifghtbox_width',
						'setup_image_pos',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'lightbox_background' => array(
					'label'           => esc_html__( 'Lightbox Background Color', DFBM()->domain() ),
					'type'            => 'color-alpha',
					'custom_color'    => true,
					'description' => esc_html__( 'Here you can define a custom color for the lightbox background.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'depends_show_if' => 'on',
				),
				'lightbox_header' => array(
					'label'           => esc_html__( 'Lightbox Header Text', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description' => esc_html__( 'Here you can define the header-text for the lightbox.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if' => 'on',
				),
				'lightbox_close' => array(
					'label'           => esc_html__( 'Lightbox Close Text', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description' => esc_html__( 'Here you can define the text next to the close-icon for the lightbox. Default: Close.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if' => 'on',
				),
				'lightbox_width' => array(
					'label'           => esc_html__( 'Lightbox Content Width', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '80',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
					'description' => esc_html__( 'Here you can define the width of the lightbox content in percent (max 99%).', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'tab_slug' => 'general',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if' => 'on',
				),
				'setup_image_pos' => array(
					'label'           => esc_html__( 'Lightbox Image Position', DFBM()->domain() ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'center' => esc_html__( 'Center', DFBM()->domain() ),
						'top'    => esc_html__( 'Top', DFBM()->domain() ),
						'bottom' => esc_html__( 'Bottom', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can choose, how your images are positioned in the lightbox.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'lightbox',
					'depends_show_if'  => 'on',
					'computed_affects' => array(
						'__posts',
					),
				),
				'cdn_origin' => array(
					'label'           => esc_html__( 'CDN Origin', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description' => esc_html__( 'Here you must paste your CDN-Origin, if you use a CDN-Service for embedded videos and images ( eg. cdn.my-domain.com ). Without the protocoll and slashes.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'script',
					'computed_affects' => array(
						'__posts',
					),
				),
				'videos_in_feed' => array(
					'label'           => esc_html__( 'Video / Audio in Feed', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'If there are videos- or audio-posts in your defined feed, turn this on to ensure proper functionality. Otherwise, you will get a javascript error.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'script',
					'computed_affects' => array(
						'__posts',
					),
				),
				'scroll_animate_offset' => array(
					'label'             => esc_html__( 'Scroll Animation Offset', DFBM()->domain() ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'off' => esc_html__( 'No', DFBM()->domain() ),
						'on'  => esc_html__( 'Yes', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Enable scroll animation offset. The default value corresponds to your header height. But it can be usefull to redefine it for shrinked headers.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'scroll',
					'affects' => array(
						'scroll_offset_height',
						'scroll_offset_height_mob',
					),
					'computed_affects' => array(
						'__posts',
					),
				),
				'scroll_offset_height' => array(
					'label'           => esc_html__( 'Animation Offset Height', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '80',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '250',
						'step' => '1',
					),
					'description' => esc_html__( 'Here you can define the scroll animation offset height.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'scroll',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => 'on',
				),
				'scroll_offset_height_mob' => array(
					'label'           => esc_html__( 'Animation Offset Height Mobile', DFBM()->domain() ),
					'type'            => 'range',
					'option_category' => 'layout',
					'default'         => '0',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '250',
						'step' => '1',
					),
					'description' => esc_html__( 'Here you can define the scroll animation offset height for mobile Devices.', DFBM()->domain() ),
					'tab_slug'    => 'general',
					'toggle_slug' => 'scroll',
					'computed_affects' => array(
						'__posts',
					),
					'depends_show_if'  => 'on',
				),
				'use_inner_shadow' => array(
					'label'           => esc_html__( 'Use Standard Inner Shadow', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options' => array(
						'on'  => esc_html__( 'On', DFBM()->domain() ),
						'off' => esc_html__( 'Off', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can add a smooth inner 1px box shadow without blur. But you can also define it in the custom-css settings according to your needs.', DFBM()->domain() ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'shadow',
					'computed_affects' => array(
						'__posts',
					),
				),
				'use_dropshadow' => array(
					'label'           => esc_html__( 'Use Dropshadow', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options' => array(
						'off' => esc_html__( 'Off', DFBM()->domain() ),
						'on'  => esc_html__( 'On', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can add a smooth drop shadow to your posts.', DFBM()->domain() ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'shadow',
					'computed_affects' => array(
						'__posts',
					),
				),
				'bg_layout' => array(
					'label' => esc_html__( 'Text Color', DFBM()->domain() ),
					'type'  => 'select',
					'option_category' => 'color_option',
					'options' => array(
						'light' => esc_html__( 'Dark', DFBM()->domain() ),
						'dark'  => esc_html__( 'Light', DFBM()->domain() ),
					),
					'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', DFBM()->domain() ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'text',
					'computed_affects' => array(
						'__posts',
					),
				),
				'different_fonts' => array(
					'label'           => esc_html__( 'Independent Fonts', DFBM()->domain() ),
					'type'            => 'yes_no_button',
					'option_category' => 'layout',
					'options'         => array(
						'off' => esc_html__( 'Off', DFBM()->domain() ),
						'on'  => esc_html__( 'On', DFBM()->domain() ),
					),
					'affects' => array(

						'post_header_fb_font',
						'post_header_fb_text_color',
						'post_header_fb_line_height',
						'post_header_fb_font_size',
						'post_header_fb_all_caps',
						'post_header_fb_letter_spacing',

						'post_meta_fb_font',
						'post_meta_fb_text_color',
						'post_meta_fb_line_height',
						'post_meta_fb_font_size',
						'post_meta_fb_all_caps',
						'post_meta_fb_letter_spacing',

						'post_meta_link_fb_font',
						'post_meta_link_fb_text_color',
						'post_meta_link_fb_line_height',
						'post_meta_link_fb_font_size',
						'post_meta_link_fb_all_caps',
						'post_meta_link_fb_letter_spacing',

						'post_content_fb_font',
						'post_content_fb_text_color',
						'post_content_fb_line_height',
						'post_content_fb_font_size',
						'post_content_fb_all_caps',
						'post_content_fb_letter_spacing',

						'post_body_fb_font',
						'post_body_fb_text_color',
						'post_body_fb_line_height',
						'post_body_fb_font_size',
						'post_body_fb_all_caps',
						'post_body_fb_letter_spacing',

					),
					'description' => esc_html__( 'If you want to style the fonts from the featured post and the filterable posts independently, you can activate this setting. Please note, that the first font-set below will work for both. With the second font-set you can adjust (and override) the styles for the filerable posts.', DFBM()->domain() ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'text',
					'computed_affects' => array(
						'__posts',
					),
				),
				'disabled_on' => array(
					'label'           => esc_html__( 'Disable on', DFBM()->domain() ),
					'type'            => 'multiple_checkboxes',
					'options'         => array(
						'phone'   => esc_html__( 'Phone', DFBM()->domain() ),
						'tablet'  => esc_html__( 'Tablet', DFBM()->domain() ),
						'desktop' => esc_html__( 'Desktop', DFBM()->domain() ),
					),
					'additional_att'  => 'disable_on',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'This will disable the module on selected devices', DFBM()->domain() ),
					'tab_slug'        => 'custom_css',
					'toggle_slug'     => 'visibility',
				),
				'admin_label' => array(
					'label'       => esc_html__( 'Admin Label', DFBM()->domain() ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', DFBM()->domain() ),
					'toggle_slug' => 'admin_label',
				),
				'module_id' => array(
					'label'           => esc_html__( 'CSS ID', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'toggle_slug'     => 'classes',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class' => array(
					'label'           => esc_html__( 'CSS Class', DFBM()->domain() ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'toggle_slug'     => 'classes',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'__posts' => array(
					'type' => 'computed',
					'computed_callback' => [ 'dfbmControllerModulesBlog', 'get_blog_posts' ],
					'computed_depends_on' => $dependFB,
				),
			];

			return array_merge( $first, $second, $third );

		} // end get_fields

		/**
		 * Frontend
		 *
		 * @since 1.0.0
		 */
		public static function get_blog_posts( $args = [], $conditional_tags = [], $current_page = [] )
		{

			// Setup Frontend as soon as supported

		} // end get_blog_posts

		/**
		 * Shortcode callback
		 *
		 * @since 1.0.0
		 */
		function shortcode_callback( $atts, $content = null, $function_name )
		{

			global $wp_filter;

			$wp_filter_cache = $wp_filter;

			if ( 'post_cat' == $this->shortcode_atts['custom_posttypes'] )
				$this->shortcode_atts['custom_posttypes'] = 'post';

			$module_id               = $this->shortcode_atts['module_id'];
			$module_class            = $this->shortcode_atts['module_class'];
			$fullwidth               = $this->shortcode_atts['dfbm_fullwidth'];
			$content_below_image     = $this->shortcode_atts['content_below_image'];
			$item_animation          = $this->shortcode_atts['item_animation'];
			$article_distance        = ( $v = $this->shortcode_atts['article_distance'] ) ? $v : 0;
			$column_max		         = ( $v = $this->shortcode_atts['column_max'] ) ? $v : 3;
			$show_posts_featured     = $this->shortcode_atts['show_posts_featured'];
			$posts_featured          = $this->shortcode_atts['posts_featured'];
			$featured_overlay_color  = ( $v = $this->shortcode_atts['featured_overlay_color'] ) ? $v : 'rgba(255,255,255,.75)';
			$layout_before_posts     = $this->shortcode_atts['layout_before_posts'];
			$show_category_filter    = $this->shortcode_atts['show_category_filter'];
			$category_filter_style   = $this->shortcode_atts['category_filter_style'];
			$custom_posttypes        = $this->shortcode_atts['custom_posttypes'];
			$include_categories      = $this->shortcode_atts['include_' . $custom_posttypes . '_categories'];
			$exclude_categories      = $this->shortcode_atts['exclude_' . $custom_posttypes . '_categories'];
			$hide_content		     = $this->shortcode_atts['hide_content'];
			$content_absolute	     = $this->shortcode_atts['content_absolute'];
			$show_thumbnail	  	     = $this->shortcode_atts['show_thumbnail'];
			$thumb_same_height	     = $this->shortcode_atts['thumb_same_height'];
			$define_thumb_height     = $this->shortcode_atts['define_thumb_height'];
			$show_star_rating	     = $this->shortcode_atts['show_star_rating'];
			$star_rating_color	     = $this->shortcode_atts['star_rating_color'];
			$star_rating_color_bg    = $this->shortcode_atts['star_rating_color_bg'];
			$star_rating_color_fb    = $this->shortcode_atts['star_rating_color_fb'];
			$star_rating_color_bg_fb = $this->shortcode_atts['star_rating_color_bg_fb'];
			$show_add_to_cart	     = $this->shortcode_atts['show_add_to_cart'];
			$add_to_cart_color	     = $this->shortcode_atts['add_to_cart_color'];
			$post_content_background_color = $this->shortcode_atts['post_content_background_color'];
			$bg_layout    		     = $this->shortcode_atts['bg_layout'];
			$use_inner_shadow        = $this->shortcode_atts['use_inner_shadow'];
			$use_dropshadow          = $this->shortcode_atts['use_dropshadow'];
			$use_overlay		     = $this->shortcode_atts['use_overlay'];
			$overlay_icon_color      = $this->shortcode_atts['overlay_icon_color'];
			$hover_overlay_color     = $this->shortcode_atts['hover_overlay_color'];
			$show_pagination         = $this->shortcode_atts['show_pagination'];
			$use_lightbox		     = $this->shortcode_atts['use_dfbm_lightbox'];
			$setup_image_pos	     = $this->shortcode_atts['setup_image_pos'];
			$lightbox_background     = ( $v = $this->shortcode_atts['lightbox_background'] ) ? esc_html( $v ) : 'rgba(0,0,0,.85)';

			$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

			$this->shortcode_atts['read_more_text'] = '' != $this->shortcode_atts['read_more_text'] ? esc_html( $this->shortcode_atts['read_more_text'] ) : esc_html__( 'Read More', DFBM()->domain() );

			$this->shortcode_atts['add_more_text'] = '' != $this->shortcode_atts['add_more_text'] ? esc_html( $this->shortcode_atts['add_more_text'] ) : esc_html__( 'Add More Posts', DFBM()->domain() );

			if ( array_key_exists( 'image', $this->advanced_options ) && array_key_exists( 'css', $this->advanced_options['image'] ) ) :

				$module_class .= $this->generate_css_filters( $function_name, 'child_', self::$data_utils->array_get( $this->advanced_options['image']['css'], 'main', '%%order_class%%' ) );

			endif;

			if ( $article_distance >= 0 ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '
						%%order_class%%.et_pb_dfbm_blog .filterable-blogposts article,
						.et_pb_featured_posts[data-count="3"] .right article:first-child
					',
					'declaration' => sprintf( 'margin-bottom: %1$spx;', esc_html( $article_distance ) ),

				] );

				$values = array(

					'desktop' => array(
						'margin-bottom' => 0,
					),
					'tablet' => array(
						'margin-bottom' => 0,
					),
					'phone' => array(
						'margin-bottom' => esc_html( $article_distance ),
					),

				); // end $values

				$selector = '.et_pb_featured_posts[data-count="3"] .left article';

				et_pb_generate_responsive_css( $values, $selector, true, $function_name );

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '
						.et_pb_featured_posts[data-count="2"] article,
						.et_pb_featured_posts[data-count="3"] > div

					',
					'declaration' => sprintf( 'margin-left: %1$spx; margin-right: %1$spx;', esc_html( (int) $article_distance / 2 ) ),

				] );

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '
						%%order_class%%.et_pb_dfbm_blog.grid .article-col

					',
					'declaration' => sprintf( 'margin-left: %1$spx; margin-right: %1$spx;', esc_html( (int) $article_distance / 2 ) ),

				] );

			endif;

			if ( $post_content_background_color ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '
						%%order_class%% .filterable-blogposts .et_pb_post .article-inner
						' .
							( 'on' == $content_absolute
							? ', %%order_class%% .filterable-blogposts .et_pb_post .et_pb_content_container'
							: '' )
						. '
					',
					'declaration' => sprintf( 'background-color: %1$s;', esc_html( $post_content_background_color ) ),

				] );

			endif;

			if ( 'off' == $fullwidth && 'on' == $show_thumbnail && 'on' == $thumb_same_height ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '
						%%order_class%% .filterable-blogposts .et_pb_image_container img,
						%%order_class%% .filterable-blogposts .et_pb_video_overlay,
						%%order_class%% .filterable-blogposts .et_main_video_container,
						%%order_class%% .filterable-blogposts iframe,
						%%order_class%% .filterable-blogposts .wp-video,
						%%order_class%% .filterable-blogposts .wp-video-shortcode,
						%%order_class%% .filterable-blogposts .et_pb_slides,
						%%order_class%% .filterable-blogposts .et_pb_post .et_pb_slide
					',
					'declaration' => sprintf('
							height: %1$spx!important;
							min-height: %1$spx!important;
							max-height: %1$spx!important;',
							esc_html( $define_thumb_height ) ),

				] );

			endif;

			if ( 'on' == $use_overlay && $overlay_icon_color ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf( 'color: %1$s !important;', esc_html( $overlay_icon_color ) ),

				] );

			endif;

			if ( 'on' == $use_overlay && $hover_overlay_color ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf( 'background-color: %1$s;', esc_html( $hover_overlay_color ) ),

				] );

			endif;

			if ( $setup_image_pos ) :

				switch ( $setup_image_pos ) :

					case 'top' :

						$setup_image_pos = '50% 1px';

						break;

					case 'center' :

						$setup_image_pos = '50%';

						break;

					case 'bottom' :

						$setup_image_pos = '50% 100%';

						break;

				endswitch;

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '.et_pb_dfbm_blog .et_pb_image_container img, .dfbm-lb-content img',
					'declaration' => sprintf( 'object-position: %1$s;', esc_html( $setup_image_pos ) ),

				] );

			endif;

			if ( 'on' == $use_lightbox ) :

				ET_Builder_Element::set_style( $function_name,
				[

					'selector'    => '.dfbm-lb-pop',
					'declaration' => sprintf( 'background-color: %1$s;', esc_html( $lightbox_background ) ),

				] );

			endif;

			if ( class_exists( 'WooCommerce' ) ) :

				if ( 'on' == $show_star_rating && $star_rating_color ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% .star-rating span::before',
						'declaration' => sprintf( 'color: %1$s;', esc_html( $star_rating_color ) ),

					] );

				endif;

				if ( 'on' == $show_star_rating && $star_rating_color_bg ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% .star-rating::before',
						'declaration' => sprintf( 'color: %1$s!important;', esc_html( $star_rating_color_bg ) ),

					] );

				endif;

				if ( 'on' == $show_star_rating && $star_rating_color_fb ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% .filterable-blogposts .star-rating span::before',
						'declaration' => sprintf( 'color: %1$s;', esc_html( $star_rating_color_fb ) ),

					] );

				endif;

				if ( 'on' == $show_star_rating && $star_rating_color_bg_fb ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% .filterable-blogposts .star-rating::before',
						'declaration' => sprintf( 'color: %1$s!important;', esc_html( $star_rating_color_bg_fb ) ),

					] );

				endif;

				if ( 'on' == $show_add_to_cart && $add_to_cart_color ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% a.add_to_cart_button',
						'declaration' => sprintf( 'color: %1$s !important;', esc_html( $add_to_cart_color ) ),

					] );

				endif;
			endif;

			if ( 'on' === $use_inner_shadow )
				$module_class .= ' inner_shadow';

			if ( 'on' === $use_dropshadow )
				$module_class .= ' et_pb_blog_grid_dropshadow';

			if ( 'on' == $show_posts_featured && $posts_featured ) :

				if ( $featured_overlay_color ) :

					ET_Builder_Element::set_style( $function_name,
					[

						'selector'    => '%%order_class%% .content-overlay .et_pb_content_container',
						'declaration' => sprintf( 'background-color: %1$s;', esc_html( $featured_overlay_color ) ),

					] );

				endif;

				if ( isset( DFBM()->getLayout()->featured ) && ! empty( DFBM()->getLayout()->featured ) )
					$featuredIn = DFBM()->getLayout()->featured;

				else
					$featuredIn = dfbmControllerBlogposts::checkFeaturedIds( $posts_featured, $custom_posttypes );

				if ( ! empty( $featuredIn ) ) :

					$this->shortcode_atts['posts_featured'] = $featuredIn;

					$featuredPosts = dfbmControllerBlogposts::featuredPosts( $featuredIn, $custom_posttypes, $this->shortcode_atts );

					if ( 'off' == $this->shortcode_atts['show_category_filter'] ) :

						ET_Builder_Element::set_style( $function_name,
						[

							'selector'    => '.et_pb_featured_posts',
							'declaration' => sprintf( 'margin-bottom: %1$spx;', esc_html( (int) $article_distance ) ),

						] );

					endif;
				endif;

				if ( ! isset ( $featuredPosts ) || ! $featuredPosts )
					$this->shortcode_atts['posts_featured'] = '';

				if ( $v = $layout_before_posts )
					$layoutBeforePosts = dfbmControllerBlogposts::getLayoutHtml( trim( $v ) );

			endif;

			if ( 'on' == $show_category_filter ) :

				$seperator = 'text' == $category_filter_style ? true : false;

				$filter = sprintf(
					'<nav class="et_pb_blog_filters %1$s clearfix">
						<div id="dfbm-active-cat" class="dfbm-active-cat">%2$s</div>
						%3$s
					</nav>',
					esc_attr( $category_filter_style ),
					esc_html__( 'All', DFBM()->domain() ),
					dfbmControllerBlogposts::buildTheFilter(
						esc_attr( $include_categories ),
						esc_attr( $exclude_categories ),
						dfbmControllerBlogposts::getTaxonomySlug( esc_attr( $custom_posttypes ) ),
						$seperator
					)
				);

			endif;

			if ( isset( DFBM()->getLayout()->query ) && ! empty( DFBM()->getLayout()->query ) )
				$qArgs = DFBM()->getLayout()->query;

			else
				$qArgs = dfbmControllerBlogposts::buildQuery( $this->shortcode_atts, false, false, false );

			$posts = dfbmControllerBlogposts::buildFeed( $qArgs, $this->shortcode_atts, false, false, false );

			if ( is_int( DFBM()->getQuery() ) )
				$qArgs['maximum_pages'] = DFBM()->getQuery();

			$masonry = 'on' === $fullwidth ? false : true;

			dfbmControllerBlogposts::enqueScripts( $this->shortcode_atts, false, $masonry );

			$class = " et_pb_module et_pb_bg_layout_{$bg_layout}";

			foreach ( dfbmControllerBlogposts::feedDefaults() as $key => $value ) :

				if ( isset( $this->shortcode_atts[$key] ) )
					$dataAtts[] = $this->shortcode_atts[$key];

			endforeach;

			$output = sprintf(
				'<div id="dfbm-container%5$s" class="%1$s%3$s%6$s">
					%7$s
					%8$s
					%9$s
					<div class="filterable-blogposts%10$s%11$s%12$s" data-config=\'%13$s\' data-atts=\'%14$s\'%15$s>
						%2$s
					</div>
				%4$s',
				( 'on' === $fullwidth ? 'et_pb_dfbm_blog full clearfix' : 'et_pb_dfbm_blog grid clearfix' ), // 1
				$posts->posts . $posts->pagination, // 2
				esc_attr( $class ), // 3
				( 'on' !== $show_pagination ? '</div><!-- .et_pb_posts -->' : '' ), // 4
				( '' !== $module_id ? sprintf( ' %1$s', esc_attr( $module_id ) ) : '' ), // 5
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ), // 6
				isset( $featuredPosts ) && ! empty( $featuredPosts ) ? $featuredPosts : '', // 7
				( isset( $layoutBeforePosts ) && ! empty( $layoutBeforePosts ) ? $layoutBeforePosts : '' ), // 8
				( 'on' == $show_category_filter ? $filter : '' ), // 9
				( 'off' == $hide_content && 'on' == $content_absolute ) ? ' content-overlay' : '', // 10
				( 'on' == $fullwidth ) ? ( 'on' == $content_below_image || 'on' == $content_absolute ? ' below' : ' next' ) : '', // 11
				apply_filters( 'dfbm_additional_class', '' ), // 12
				json_encode( $qArgs ), // 13
				json_encode( $dataAtts ), // 14
				( ! empty( $exclude_categories ) ) ? ' data-cat-not-id="' . str_replace( ' ', '', esc_attr( $exclude_categories ) ) . '"' : '' // 15
			);

			$wp_filter = $wp_filter_cache;

			unset( $wp_filter_cache );

			return $output;

		} // end shortcode_callback
	} // end class
} // end if
