<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Layouts
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerLayouts' ) )
{

	class dfbmControllerLayouts
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $runs;

		private $inserted;

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

			$this->runs     = 0;

			$this->inserted = true;

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

			add_action( 'current_screen', function( $hook )
			{

				if ( in_array( $hook->base, [ 'edit', 'post' ] ) )
					$this->deleteLayout();

			}); // end add_action
		} // end initialize

		/**
		 * Delete layouts from db
		 *
		 * @since 1.0.0
		 */
		public function deleteLayout()
		{

			global $pagenow;

			foreach ( $this->getLayouts() as $key => $value ) :

				$post = ( new dfbmModelGet )->postByTitle( $key, ET_BUILDER_LAYOUT_POST_TYPE );

				if ( $post )
					( new dfbmModelDelete )->post( $post->ID );

			endforeach;

			$this->insertLayout();

		} // end deleteLayout

		/**
		 * Add layouts to db
		 *
		 * @since 1.0.0
		 */
		public function insertLayout()
		{

			$user = wp_get_current_user()->ID;

			foreach ( $this->getLayouts() as $key => $value ) :

				$id = ( new dfbmModelSet )->layout( $user, $key, $value );

				if ( ! $id ) :

					$this->inserted = false;

					break;

				endif;

				( new dfbmModelSet )->layoutTerm( $id );

			endforeach;

			if ( ! $this->inserted && $this->runs < 4 ) :

				$this->runs++;

				return $this->deleteLayout();

			endif;

			if ( $this->inserted )
				( new dfbmModelSet )->option( DFBM()->prefix() . '_layouts_added' );

		} // end insertLayout

		/**
		 * Archive templates
		 *
		 * @since 1.0.0
		 */
		public function getLayouts()
		{

			return
			[

				'DFBM-Author-Light' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog_light admin_label="Divi - Filterable Blog Module Light" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Search-Light' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog_light admin_label="Divi - Filterable Blog Module Light" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Archive-Light' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog_light admin_label="Divi - Filterable Blog Module Light" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Shop-Light' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="0px||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="on" use_custom_width="off" width_unit="on" use_custom_gutter="on" gutter_width="1" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off" custom_padding="||0px|"][et_pb_column type="4_4"][et_pb_dfbm_blog_light admin_label="Divi - Filterable Blog Module Light" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="product" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="off" show_date="off" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Author' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog admin_label="Divi - Filterable Blog Module" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Search' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog admin_label="Divi - Filterable Blog Module" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Archive' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="off" use_custom_width="off" width_unit="on" use_custom_gutter="off" custom_padding="0px||0px|" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off"][et_pb_column type="4_4"][et_pb_dfbm_blog admin_label="Divi - Filterable Blog Module" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="post" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="on" show_date="on" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

				'DFBM-Shop' =>
				'[et_pb_section bb_built="1" admin_label="section" transparent_background="off" allow_player_pause="off" inner_shadow="off" parallax="off" parallax_method="on" custom_padding="0px||0px|" make_fullwidth="off" use_custom_width="off" width_unit="on" make_equal="off" use_custom_gutter="off"][et_pb_row admin_label="row" make_fullwidth="on" use_custom_width="off" width_unit="on" use_custom_gutter="on" gutter_width="1" allow_player_pause="off" parallax="off" parallax_method="on" make_equal="off" parallax_1="off" parallax_method_1="off" custom_padding="||0px|"][et_pb_column type="4_4"][et_pb_dfbm_blog admin_label="Divi - Filterable Blog Module" dfbm_fullwidth="off" content_below_image="off" show_posts_featured="off" show_category_filter="off" category_filter_style="nav" show_order_options="off" order_options_order="DESC" order_options_orderby="date" custom_posttypes="product" hide_content="off" content_absolute="off" content_absolute_event="on" show_thumbnail="on" thumb_same_height="on" define_thumb_height="270" show_header="on" header_tag="h2" show_content="excerpt" show_limit_words="on" limit_words_count="35" show_comments="on" show_categories="on" show_limit_categories="on" show_author="off" show_date="off" show_star_rating="on" show_product_price="on" show_add_to_cart="on" read_more="on" show_pagination="on" add_more_button="off" add_more_fullwidth="off" offset_number="0" use_overlay="off" use_overlay_featured="off" use_dfbm_lightbox="off" videos_in_feed="off" scroll_animate_offset="off" scroll_offset_height_mob="0" bg_layout="light" setup_image_pos="center" use_inner_shadow="on" use_dropshadow="off" different_fonts="off" post_meta_link_fb_font_size_tablet="51" post_meta_link_fb_line_height_tablet="5" use_border_color="off" border_color="#ffffff" border_style="solid" /][/et_pb_column][/et_pb_row][/et_pb_section]',

			];

		} // end getLayouts
	} // end class
} // end if
