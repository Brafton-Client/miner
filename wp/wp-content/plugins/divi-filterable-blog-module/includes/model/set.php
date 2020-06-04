<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Model Set
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmModelSet' ) )
{

	class dfbmModelSet
	{

		/**
		 * Set option
		 *
		 * @since 1.0.0
		 */
		public function option( $option, $value = true )
		{

			return update_option( esc_attr( $option ), esc_attr( $value ) );

		} // end option

		/**
		 * Set transient
		 *
		 * @since 1.0.0
		 */
		public function transient( $transient, $time = false, $value = true )
		{

			return set_transient( esc_attr( $transient ), esc_attr( $value ), esc_attr( $time ) );

		} // end transient

		/**
		 * Set new layout
		 *
		 * @since 1.0.0
		 */
		public function layout( $user, $title, $content )
		{

			$args =
			[

				'post_author'    => esc_attr( $user ),
				'post_title'     => esc_attr( $title ),
				'post_content'   => wp_kses( $content, wp_kses_allowed_html( 'post' ) ),
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'post_type'      => ET_BUILDER_LAYOUT_POST_TYPE,
				'meta_input'     =>
				[

					'_et_pb_built_for_post_type'       => 'page',
					'_et_pb_use_builder'               => 'on',
					'_et_pb_ab_bounce_rate_limit'      => '5',
					'_et_pb_ab_stats_refresh_interval' => 'hourly',
					'_et_pb_old_content' 			   => '',
					'_et_pb_enable_shortcode_tracking' => '',
					'_dfbm_initial_query'              =>
					[

						'posts_number' => 6,

					],
				],
			];

			return wp_insert_post( $args );

		} // end layout

		/**
		 * Set layout term
		 *
		 * @since 1.0.0
		 */
		public function layoutTerm( $id )
		{

			return wp_set_post_terms( (int) $id, 'layout', 'layout_type' );

		} // end layoutTerm

		/**
		 * Set post meta
		 *
		 * @since 1.0.0
		 */
		public function meta( $id, $key, $value )
		{

			return update_post_meta( (int) $id, esc_attr( $key ), $value );

		} // end meta
	} // end class
} // end if
