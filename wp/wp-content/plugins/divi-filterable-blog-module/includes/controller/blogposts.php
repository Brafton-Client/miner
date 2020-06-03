<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Blogposts
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerBlogposts' ) )
{

	class dfbmControllerBlogposts
	{

		/**
		 * Feed defaults
		 *
		 * @since 1.0.0
		 */
		public static function feedDefaults()
		{

			$defaults =
			[

				'dfbm_fullwidth'         => '',
				'item_animation'		 => '',
				'posts_featured'     	 => '',
				'posts_number'       	 => '',
				'show_order_options'	 => '',
				'order_options_order'	 => '',
				'order_options_orderby'	 => '',
				'custom_posttypes' 	 	 => '',
				'show_star_rating'	 	 => '',
				'show_product_price' 	 => '',
				'show_add_to_cart'	 	 => '',
				'meta_date'          	 => '',
				'show_thumbnail'     	 => '',
				'content_absolute'		 => '',
				'content_absolute_event' => '',
				'hide_content'		 	 => '',
				'show_content'       	 => '',
				'show_limit_words'   	 => '',
				'limit_words_count'  	 => '',
				'show_header'		 	 => '',
				'header_tag'		 	 => '',
				'show_author'        	 => '',
				'show_date'          	 => '',
				'show_categories'    	 => '',
				'show_limit_categories'	 => '',
				'limit_category_count'	 => '',
				'show_comments'      	 => '',
				'show_pagination'    	 => '',
				'add_more_button'	 	 => '',
				'add_more_text'          => '',
				'add_more_fullwidth' 	 => '',
				'read_more'          	 => '',
				'read_more_text'         => '',
				'offset_number'      	 => '',
				'hover_icon'         	 => '',
				'use_overlay'        	 => '',
				'use_dfbm_lightbox'		 => '',
				'lightbox_header'		 => '',
				'lightbox_close'		 => '',
				'lightbox_width'		 => '',
				'videos_in_feed'		 => '',
				'cdn_origin'			 => '',

			];

			foreach ( self::taxFields() as $key )
			{

				$cats[$key] = '';

			} // end foreach

			return array_merge( $defaults, $cats );

		} // end feedDefaults

		/**
		 * Category fields
		 *
		 * @since 1.0.0
		 */
		public static function taxFields( $cpts = false )
		{

			foreach ( ( $cpts ? $cpts : self::getPosttypes() ) as $cpt ) :

				$taxFields[] = 'include_' . $cpt . '_categories';
				$taxFields[] = 'exclude_' . $cpt . '_categories';
				$taxFields[] = 'include_' . $cpt . '_tags';
				$taxFields[] = 'exclude_' . $cpt . '_tags';

			endforeach;

			return $taxFields;

		} // end taxFields

		/**
		 * Build the query for the feed
		 *
		 * @since 1.0.0
		 */
		public static function buildQuery( $args = [], $conditional_tags = [], $current_page = [], $front = true )
		{

			global $paged, $wp_query;

			$defaults      = self::feedDefaults();

			$is_front_page = $front ? et_fb_conditional_tag( 'is_front_page', $conditional_tags ) : is_front_page();
			$is_search     = $front ? et_fb_conditional_tag( 'is_search', $conditional_tags ) : is_search();
			$is_single     = $front ? et_fb_conditional_tag( 'is_single', $conditional_tags ) : is_single();
			$is_archive    = is_archive();
			$is_author 	   = is_author();

			$args          = wp_parse_args( $args, $defaults );

			$query_args    =
			[

				'posts_per_page' => (int) $args['posts_number'],
				'post_status'    => 'publish',

			];

			if ( isset( DFBM()->getLayout()->redirect ) ) :

				if ( $is_search ) :

					$searchCpts = 'any' == get_query_var( 'post_type' ) || ! get_query_var( 'post_type' )
								? apply_filters( 'dfbm_set_search_posttypes', [ 'post' ] )
								: esc_attr( get_query_var( 'post_type' ) );

					$searchArg  = isset( DFBM()->getLayout()->search ) ? esc_attr( DFBM()->getLayout()->search ) : esc_attr( get_query_var( 's' ) );

					$query_args['s']         = $searchArg;
					$query_args['post_type'] = $searchCpts;

				endif;

				if ( $is_author ) :

					$authorID  = isset( DFBM()->getLayout()->author ) ? (int) DFBM()->getLayout()->author : (int) get_query_var( 'author' );

					$query_args['author']    = $authorID;
					$query_args['post_type'] = apply_filters( 'dfbm_set_author_posttypes', [ 'post' ] );

				endif;

				if ( isset( DFBM()->getLayout()->archive ) ) :

					$query_args['post_type'] = $args['custom_posttypes'] = esc_attr( DFBM()->getLayout()->pt );

					if ( 'tax' == DFBM()->getLayout()->archive ) :

						if ( 'cat' == DFBM()->getLayout()->tax ) :

							$query_args[esc_attr( DFBM()->getLayout()->key )] = esc_attr( DFBM()->getLayout()->value );

						endif;

						if ( 'tag' == DFBM()->getLayout()->tax ) :

							$query_args[esc_attr( DFBM()->getLayout()->key )] = esc_attr( DFBM()->getLayout()->value );

						endif;
					endif;

					if ( class_exists( 'WooCommerce' ) && isset( DFBM()->getLayout()->shop ) ) :

						$r = $_REQUEST;

						$orderArgs = WC()->query->get_catalog_ordering_args();

						if ( isset( $r['orderby'] ) ) :

							if ( self::isIn( 'price', $r['orderby'] ) ) :

								$orderArgs['orderby'] = 'meta_value_num';
								$orderArgs['meta_key'] = '_price';

							endif;

							if ( 'popularity' == $r['orderby'] ) :

								$orderArgs['orderby'] = 'meta_value_num';
								$orderArgs['meta_key'] = 'total_sales';

							endif;
						endif;

						$query_args['orderby'] = $orderArgs['orderby'];

						$query_args['order']   = $orderArgs['order'];

						if ( isset( $orderArgs['meta_key'] ) && ! empty( $orderArgs['meta_key'] ) ) :

							$query_args['meta_key'] = $orderArgs['meta_key'];

						endif;

						if ( isset( $_REQUEST['min_price'] ) ) :

							$query_args['meta_query'] = WC()->query->get_meta_query();

						endif;

						$query_args['tax_query'] = WC()->query->get_tax_query();

					endif;
				endif;

				if ( isset( DFBM()->getLayout()->paged ) && is_int( $paged = (int) DFBM()->getLayout()->paged ) && $paged > 0 )
					$paged = $paged;
?>
<?php		else :

				$query_args['post_type'] = esc_attr( $args['custom_posttypes'] );

			endif;

			if ( defined( 'DOING_AJAX' ) && isset( $current_page[ 'paged'] ) ) :

				$paged = (int) $current_page[ 'paged' ];

			else :

				if ( ! $is_archive && ! $is_search && ! $is_author )
					$paged = $is_front_page ? esc_attr( get_query_var( 'page' ) ) : esc_attr( get_query_var( 'paged' ) );

			endif;

			if ( ! $is_search && ! $is_author ) :

				$catSlug = self::getTaxonomySlug( esc_attr( $args['custom_posttypes'] ) );

				$tagSlug = self::getTaxonomySlug( esc_attr( $args['custom_posttypes'] ), 'tag' );

				if ( $catInclude = esc_attr( $args['include_' . esc_attr( $args['custom_posttypes'] ) . '_categories'] ) ) :

					$catIN =
					[
						'taxonomy' => $catSlug,
						'field'    => 'term_id',
						'terms'    => explode( ',', $catInclude ),
						'operator' => 'IN',
					];

					$query_args['tax_query'][] = $catIN;

				endif;

				if ( $catExclude = esc_attr( $args['exclude_' . esc_attr( $args['custom_posttypes'] ) . '_categories'] ) ) :

					$catNotIN =
					[
						'taxonomy' => $catSlug,
						'field'    => 'term_id',
						'terms'    => explode( ',', $catExclude ),
						'operator' => 'NOT IN',
					];

					$query_args['tax_query'][] = $catNotIN;

				endif;

				if ( $tagInclude = esc_attr( $args['include_' . esc_attr( $args['custom_posttypes'] ) . '_tags'] ) ) :

					$tagIN =
					[
						'taxonomy' => $tagSlug,
						'field'    => 'term_id',
						'terms'    => explode( ',', $tagInclude ),
						'operator' => 'IN',
					];

					$query_args['tax_query'][] = $tagIN;


				endif;

				if ( $tagExclude = esc_attr( $args['exclude_' . esc_attr( $args['custom_posttypes'] ) . '_tags'] ) ) :

					$tagNotIN =
					[
						'taxonomy' => $tagSlug,
						'field'    => 'term_id',
						'terms'    => explode( ',', $tagExclude ),
						'operator' => 'NOT IN',
					];

					$query_args['tax_query'][] = $tagNotIN;

				endif;
			endif;

			if ( $args['offset_number'] && ! empty( $args['offset_number'] ) ) :

				if ( $paged > 1 ) :

					$query_args['offset'] = ( ( $paged - 1 ) * (int) $args['posts_number'] ) + (int) $args['offset_number'];

				else :

					$query_args['offset'] = (int) $args['offset_number'];

				endif;

				$query_args['offset_number'] = $args['offset_number'];

			endif;

			if ( $args['posts_featured'] && is_array( $args['posts_featured'] ) ) :

				$query_args['post__not_in'] = $args['posts_featured'];

			endif;

			if ( 'on' == $args['show_order_options'] ) :

				$query_args['order']   = esc_attr( $args['order_options_order'] );

				$query_args['orderby'] = esc_attr( $args['order_options_orderby'] );

			endif;

			if ( $is_single )
				$query_args['post__not_in'][] = esc_attr( get_the_ID() );

			$query_args['paged'] = $paged;

			return apply_filters( 'dfbm_query_args_output', $query_args );

		} // end buildQuery

		/**
		 * Build the feed
		 *
		 * @since 1.0.0
		 */
		public static function buildFeed( $query_args = [], $args = [], $conditional_tags = [], $front = true, $featured = false, $pagination = false )
		{

			global $et_pb_rendering_column_content, $paged, $wp_query;

			$defaults  = self::feedDefaults();
			$args      = wp_parse_args( $args, $defaults );
			$query     = isset( DFBM()->getLayout()->redirect ) && ! $featured && $wp_query->is_main_query() ? $wp_query : new WP_Query( $query_args );

			if ( ! isset( DFBM()->getLayout()->redirect ) && ! $featured ) :

				$origQuery = $wp_query;
				$wp_query  = $query;

			endif;

			$wooLoop = class_exists( 'WooCommerce' ) && 'product' == $args['custom_posttypes'] ? true : false;

			if ( isset( $query, $query->max_num_pages, $query->found_posts ) && ( ( $maxPag = (int) $query->max_num_pages ) > 0 ) && ! $featured ) :

				if ( isset( $query->query['offset_number'] ) && ( $off = (int) $query->query['offset_number'] ) > 0 ) :

					$a = (int) $query->found_posts - $off;
					$b = (int) $query->query['posts_per_page'];
					$c = ($a - $a % $b) / $b;

					$maxPag = $a % $b > 0 ? $c + 1 : $c;

				endif;

				DFBM()->setQuery( $maxPag );

			endif;

			remove_all_filters( 'wp_audio_shortcode_library' );
			remove_all_filters( 'wp_audio_shortcode' );
			remove_all_filters( 'wp_audio_shortcode_class');

			if ( $front ) :

				global $et_fb_processing_shortcode_object;

				$global_processing_original_value = $et_fb_processing_shortcode_object;

			endif;

			$is_front_page = $front ? et_fb_conditional_tag( 'is_front_page', $conditional_tags ) : is_front_page();
			$is_search     = $front ? et_fb_conditional_tag( 'is_search', $conditional_tags ) : is_search();
			$is_single     = $front ? et_fb_conditional_tag( 'is_single', $conditional_tags ) : is_single();
			$is_archive    = is_archive();
			$is_author 	   = is_author();

			$et_is_builder_plugin_active = $front ? et_fb_conditional_tag( 'et_is_builder_plugin_active', $conditional_tags ) : et_is_builder_plugin_active();

			$obj = new stdClass();

			$obj->posts = $obj->pagination = '';

			if ( $query->have_posts() ) :

				ob_start();

				while( $query->have_posts() ) :

					$query->the_post();

					if ( $front ) :

						$global_processing_original_value = $et_fb_processing_shortcode_object;

						$et_fb_processing_shortcode_object = false;

					endif;

					if ( $wooLoop )
						global $product;

					$post 			= get_post();

					$post_format    = et_pb_post_format();
					$thumb          = '';
					$width          = (int) apply_filters( 'dfbm_blog_image_width',
									  ( ( 'on' === $args['dfbm_fullwidth'] && ! $featured ) || $featured ? 1080 : 400 ) );
					$height         = (int) apply_filters( 'dfbm_blog_image_height',
									  ( ( 'on' === $args['dfbm_fullwidth'] && ! $featured ) || $featured ? 675 : 250 ) );
					$classtext      = 'on' === $args['dfbm_fullwidth'] ? 'et_pb_post_main_image' : '';
					$titletext      = get_the_title();
					$thumbnail      = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb          = $thumbnail["thumb"];
					$no_thumb_class = '' === $thumb || 'off' === $args['show_thumbnail'] ? ' et_pb_no_thumb' : '';
					$overlay_class  = 'on' === $args['use_overlay'] || $featured ? ' et_pb_has_overlay' : '';

					if ( 'on' === $args['use_overlay'] && ! $featured
						 || 'on' === $args['use_overlay'] && $featured && 'on' === $args['hide_content']
						 || 'on' === $args['use_overlay'] && $featured && 'on' === $args['use_overlay_featured'] ) :

						$data_icon = '' !== $args['hover_icon']
							? sprintf(
								' data-icon="%1$s"',
								esc_attr( et_pb_process_font_icon( $args['hover_icon'] ) )
							)
							: '';

						$overlay_output = sprintf(
							'<span class="et_overlay%1$s"%2$s></span>',
							( $args['hover_icon'] ? ' et_pb_inline_icon' : '' ),
							$data_icon
						);

					endif;

					if ( in_array( $post_format, array( 'video', 'gallery' ) ) )
						$no_thumb_class = '';

					$ajaxClass = defined( 'DOING_AJAX') && in_array( $post_format, [ 'video', 'gallery', 'audio' ] ) ? ' ajax-' . $post_format : '';

					$lightBox  = 'on' == ( $args['use_dfbm_lightbox'] ) ? '' : ' no-lb';

					$event = $featured || 'on' == $args['content_absolute'] ? ( 'on' == $args['content_absolute_event'] ? ' click' : ' hover' ) : '';
?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class . $overlay_class . $ajaxClass . $event ); ?> >
<?php

						printf( '<div class="article-inner %1$s">', esc_attr( $args['item_animation'] ) );
							et_divi_post_format_content();

							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) :

								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :

									$video_overlay =
										has_post_thumbnail() ?
										sprintf(
											'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
												<div class="et_pb_video_overlay_hover">
													<a href="#" class="et_pb_video_play"></a>
												</div>
											</div>',
											( 'on' === $args['dfbm_fullwidth'] ? $thumb : substr( $thumb, 0, strrpos(  $thumb, '.' ) ) . '-400x250' . substr( $thumb, strrpos( $thumb, '.' ) ) )
										) : '';

										printf(
											'<div class="et_main_video_container">
												%1$s
												%2$s
											</div>',
											$video_overlay,
											$first_video
										);

								elseif ( 'gallery' === $post_format ) :

									et_pb_gallery_images( 'slider' );

								elseif ( '' !== $thumb && 'on' === $args['show_thumbnail'] ) :
?>
									<div class="et_pb_image_container">
										<a href="<?php esc_url( the_permalink() ); ?>" class="entry-featured-image-url<?php echo $lightBox; ?>" data-title="<?php the_title(); ?>">

											<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
<?php
											if ( 'on' === $args['use_overlay'] && ! $featured
												 || 'on' === $args['use_overlay'] && $featured && 'on' === $args['hide_content']
												 || 'on' === $args['use_overlay'] && $featured && 'on' === $args['use_overlay_featured'] )
											{

												echo $overlay_output;

											} // end if
?>
										</a>
									</div>
<?php
								endif;
							endif;

							if ( ( 'off' === $args['dfbm_fullwidth'] || ! in_array( $post_format, [ 'link', 'audio', 'quote' ] ) ) && 'off' === $args['hide_content'] ) :
?>
								<div class="et_pb_content_container<?php echo $event ?>">

									<div class="inner">
<?php
										$metaSeparator = '<p class="post-meta separator">' . apply_filters( 'dfbm_meta_separator', ' | ' ) . '</p>';

										$metaBefore = '';

										if ( 'on' === $args['show_comments'] ) :

											$metaBefore .= sprintf( '<p class="post-meta comments">%1$s</p>', get_comments_number() );

										endif;

										if ( $wooLoop && 'on' == $args['show_star_rating'] ) :

											$comments    = 'on' === $args['show_comments'] ? '' : '0';

											$metaBefore .= ( $v = wc_get_rating_html( $product->get_average_rating() ) )
														   ? '<div class="post-meta rating woocommerce">' . $v . '</div>'
														   : $comments . '<p class="post-meta no-review">' . esc_html__( 'Reviews', DFBM()->domain() ) . '</p>';
										endif;

										if ( ( 'on' === $args['show_comments'] || ( $wooLoop && 'on' == $args['show_star_rating'] ) ) && 'on' === $args['show_categories'] )
											$metaBefore .= $metaSeparator;

										if ( 'on' === $args['show_categories'] ) :

											if ( $is_search || $is_archive || $is_author )
												$args['custom_posttypes'] = get_post()->post_type;

											$terms = get_the_terms( get_the_ID(), self::getTaxonomySlug( esc_attr( $args['custom_posttypes'] ) ) );

											if ( $featured )
												$notIn = ! empty( $v = $args['exclude_' . $args['custom_posttypes'] . '_categories'] )
														 ? array_map( 'intval', explode( ',', str_replace( ' ', '', $v ) ) ) : '';

											if ( $terms ) :

												$termLinks = [];

												foreach ( $terms as $term ) :

													if ( $featured && is_array( $notIn ) && in_array( $term->term_id, $notIn ) )
														continue;

													$termLinks[] = sprintf(
														'<a href="%1$s" class="cat-selector" data-cat-name="%2$s" data-cat-id="%3$s">%4$s</a>',
														esc_attr( get_term_link( $term->term_id ) ),
														esc_html( $term->name ),
														esc_html( $term->term_id ),
														esc_html( $term->name )
													);

												endforeach;

												if ( 'on' == $args['show_limit_categories'] )
													$termLinks = array_slice( $termLinks, 0, (int) $args['limit_category_count'] );

												$metaBefore .= sprintf(
													'<p class="post-meta category">%1$s</p>',
													implode( ', ', $termLinks )
												);

											endif;
										endif;

										do_action( 'dfbm_post_meta_before', $post, $featured );

										if ( $metaBefore )
											printf( '<div class="header-before">%1$s</div>', $metaBefore );

										do_action( 'dfbm_post_title_before', $post, $featured );

										if ( ! in_array( $post_format, [ 'link', 'audio' ] ) && 'on' == $args['show_header'] ) :

											printf(
												'<%1$s class="entry-title"><a href="%2$s">%3$s</a></%1$s>',
												$args['header_tag'],
												get_the_permalink(),
												get_the_title()
											);

										endif;

										if ( $front )
											$et_fb_processing_shortcode_object = false;

										$et_pb_rendering_column_content = true;

										if ( $front )
											ET_Builder_Element::clean_internal_modules_styles();

										if ( 'none' != $args['show_content'] ) :

											do_action( 'dfbm_posts_content_before', $post, $featured );
?>
											<div class="post-content">
<?php
											switch ( $args['show_content'] ) :

												case 'content' :

													if ( 'on' == $args['show_limit_words'] )
															echo self::limitWordcount( self::prettifyContent( get_the_content() ), (int) $args['limit_words_count'] );

													else
														echo self::prettifyContent( get_the_content() );

												break;

												case 'excerpt' :

													if ( has_excerpt() ) :

														if ( 'on' == $args['show_limit_words'] )
															echo self::limitWordcount( self::prettifyContent( get_the_excerpt() ), (int) $args['limit_words_count'] );

														else
															echo self::prettifyContent( get_the_excerpt() );

													else :

														if ( $front ) :

															if ( '' !== $post_content ) :

																$et_fb_processing_shortcode_object = false;

																if ( 'on' == $args['show_limit_words'] )
																	echo self::limitWordcount( self::prettifyContent( get_the_content() ), (int) $args['limit_words_count'] );

																else
																	echo self::prettifyContent( get_the_content() );

																$et_fb_processing_shortcode_object = $global_processing_original_value;

															endif;

														else :

																if ( 'on' == $args['show_limit_words'] )
																	echo self::limitWordcount( self::prettifyContent( get_the_content() ), (int) $args['limit_words_count'] );

																else
																	echo self::prettifyContent( get_the_content() );

														endif;
													endif;

												break;

											endswitch;

											if ( $front ) :

												$et_fb_processing_shortcode_object = $global_processing_original_value;

												$internal_style = ET_Builder_Element::get_style( true );

												ET_Builder_Element::clean_internal_modules_styles( false );

											endif;

											$et_pb_rendering_column_content = false;

											if ( $front && $internal_style ) :

												printf(
													'<style type="text/css" class="et_fb_blog_inner_content_styles">
														%1$s
													</style>',
													$internal_style
												);
											endif;
?>
											</div><!-- .post-content -->
<?php
										endif;

										if ( 'on' === $args['show_author'] || 'on' === $args['show_date'] )
											echo '<div class="post-meta author date">';

										if ( 'on' === $args['show_author'] ) :

											add_filter( 'the_author_posts_link', function( $link )
											{

												return str_replace( 'rel', 'class="dfbm-author" rel', $link );

											}); // end add_filter

											printf(
												'<p class="post-meta author">%1$s</p>',
												et_get_safe_localization( sprintf(
													__( 'by %s', 'et_builder' ),
													'<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' )
												)
											);

										endif;

										if ( 'on' === $args['show_author'] && 'on' === $args['show_date'] )
											echo $metaSeparator;

										if ( 'on' === $args['show_date'] ) :

											printf(
												'<p class="post-meta date">%1$s</p>',
												et_get_safe_localization( sprintf(
													__( '%s', 'et_builder' ),
													'<span class="published">' . esc_html( get_the_date( $args['meta_date'] ) ) . '</span>' )
												)
											);

										endif;

										if ( 'on' === $args['show_author'] || 'on' === $args['show_date'] )
											echo '</div>';

										if ( $wooLoop ) :

											if ( 'on' == $args['show_product_price'] && $price_html = $product->get_price_html() ) :
?>
												<p class="post-meta price woocommerce"><span class="price"><?php echo $price_html; ?></span></p>
<?php
											endif;
										endif;
?>
									</div><!-- .inner -->
<?php
									do_action( 'dfbm_posts_content_after', $post, $featured );

									if ( $wooLoop && 'on' == $args['show_add_to_cart'] || 'on' == $args['read_more'] ) :
?>
									<div class="bottom">
<?php
										if ( $wooLoop && 'on' == $args['show_add_to_cart'] ) :

											if ( $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ) :

												$prodDefaults =
												[
													'quantity' => 1,
													'class'    => implode( ' ',
													[
														'product_type_' . $product->get_type(),
														'add_to_cart_button',
														'ajax_add_to_cart'
													] )
												];

												$prodArgs = apply_filters( 'woocommerce_loop_add_to_cart_args', $prodDefaults, $product );

												echo apply_filters( 'woocommerce_loop_add_to_cart_link',
													sprintf(
														'<a rel="nofollow" href="%1$s" data-quantity="%2$s" data-product_id="%3$s" data-product_sku="%4$s" class="%5$s">%6$s</a>',
														esc_url( $product->add_to_cart_url() ),
														isset( $prodArgs['quantity'] ) ? esc_attr( $prodArgs['quantity'] ) : 1,
														esc_attr( $product->get_id() ),
														esc_attr( $product->get_sku() ),
														isset( $prodArgs['class'] ) ? esc_attr( $prodArgs['class'] ) : 'button',
														sprintf( '<span class="cart-icon" title="%1$s"></span>', esc_html__( 'Add to cart', DFBM()->domain() ) )
													),
												$product );

											endif;
										endif;

										if ( 'on' == $args['read_more'] ) :
?>
											<a class="et_pb_button read-more" href="<?php esc_url( the_permalink() ); ?>"><?php echo $args['read_more_text']; ?></a>
<?php
										endif;
?>
									</div><!-- .bottom -->
<?php
									do_action( 'dfbm_posts_bottom_after', $post, $featured );

									endif;
?>
								</div><!-- .et_pb_content_container -->
<?php
							endif;
?>
						</div><!-- .article-inner -->
					</article>
<?php
					if ( ( defined( 'DOING_AJAX') || $featured ) )
						echo '%,%';

					if ( $front )
						$et_fb_processing_shortcode_object = $global_processing_original_value;

				endwhile;

				$obj->posts = ob_get_clean();

				if ( ( ! defined( 'DOING_AJAX' ) || $pagination ) && 'on' === $args['show_pagination'] && 'off' === $args['add_more_button'] && ! $featured ) :

					if ( ! $pagination )
						$obj->pagination .= '</div> ' . ( ! defined( 'DOING_AJAX' ) ? '<!-- .et_pb_posts -->' : '');

					if ( isset( $maxPag ) && $maxPag > 1 )
						$obj->pagination .= self::buildPagination( $wp_query, $maxPag, $pagination );

				endif;

				if ( ( ! defined( 'DOING_AJAX' ) || $pagination ) && 'on' === $args['show_pagination'] && 'on' === $args['add_more_button'] && ! $featured ) :

					$obj->pagination .= '</div>' . ( ! defined( 'DOING_AJAX' ) ? '<!-- .et_pb_posts -->' : '');

					if ( isset( $maxPag ) && $maxPag > 1 ) :

						$buttonClass = 'on' === $args['add_more_fullwidth'] ? ' fullwidth' : '';

						$obj->pagination .= '<div id="add-more-section" class="add-more-section"><a id="add-more-button" class="et_pb_button add-more-button' . $buttonClass . '" href="#">' . $args['add_more_text'] . '</a></div>';

					endif;
				endif;
?>
<?php		else: // have posts

				$obj->pagination .= self::noPosts() . '</div> <!-- .et_pb_posts -->';

			endif; // have_posts

			if ( defined( 'DOING_AJAX' ) && $wooLoop && ! apply_filters( 'dfbm_hide_woocommerce_breadcrumb', false ) ) :

				$obj->breadcrumb = self::getWooBreadcrumb();

				$obj->results = self::getWooResults();

			endif;

			if ( ! isset( DFBM()->getLayout()->redirect ) && ! $featured ) :

				wp_reset_query();

				$wp_query = $origQuery;

			endif;

			return $obj;

		} // end buildFeed

		/**
		 * Build featured posts
		 *
		 * @since 1.0.0
		 */
		public static function featuredPosts( $ids, $cpt, $atts )
		{

			$featuredArgs =
			[

				'post_type'      => $cpt,
				'post_status'    => 'publish',
				'post__in'       => $ids,
				'orderby' 		 => 'post__in',

			];

			$featuredPosts = self::buildFeed( $featuredArgs, $atts, false, false, true );

			if ( $featuredPosts && isset( $featuredPosts->posts ) )
			{

				if ( 3 === (int) count( $ids ) ) :

					$featArr = explode( '%,%', $featuredPosts->posts );

					$featuredPosts = sprintf(
						'<div class="left">%1$s</div>
						 <div class="right">%2$s%3$s</div>',
						$featArr[0],
						$featArr[1],
						$featArr[2]
					);

				else :

					$featuredPosts = str_replace( '%,%', '', $featuredPosts->posts );

				endif;

				$featuredPosts = sprintf(
					'<div id="et_pb_featured_posts" class="et_pb_featured_posts content-overlay" data-count="%1$s">%2$s</div>',
					count( $ids ),
					$featuredPosts
				);

			} // end if

			return $featuredPosts ? $featuredPosts : false;

		} // end featuredPosts

		/**
		 * Check the ids for featured posts
		 *
		 * @since 1.0.0
		 */
		public static function checkFeaturedIds( $ids, $cpt )
		{

			$checkIds    = array_map( 'trim', explode( ',', esc_attr( $ids ) ) );

			$featuredIn  = [];

			foreach ( $checkIds as $fId ) :

				if ( $cpt == get_post_type( (int) $fId ) )
					$featuredIn[] = (int) $fId;

				if ( 3 === (int) count( $featuredIn ) )
					break;

			endforeach;

			return $featuredIn;

		} // end checkFeaturedIds

		/**
		 * Build the Pagination
		 *
		 * @since 1.0.0
		 */
		public static function buildPagination( $wp_query, $max, $base = false )
		{

			$paged = max( 1, absint( get_query_var('paged') ) );

			$now   = esc_html__( 'Page ', DFBM()->domain() ) . $paged . esc_html__( ' of ', DFBM()->domain() ) . $max;

			$now   = '<span class="page-numbers pages">' . $now . '</span>';

			$base  = $base ? esc_url( $base ) : get_pagenum_link();

			$base  = explode( '?', html_entity_decode( $base ) );

			$args =
			[

	            'base'      => $base[0] . '%_%',
	            'format'    => 'page/%#%/',
	            'current'   => $paged,
	            'total'     => $max,
	            'show_all'  => false,
	            'end_size'  => 2,
	            'mid_size'  => 2,
	            'prev_text' => esc_html__( 'Prev', DFBM()->domain() ),
	            'next_text' => esc_html__( 'Next', DFBM()->domain() ),
	            'type'      => 'array',

			];

			if ( defined( 'DOING_AJAX') && count( $base ) > 1 ) :

				unset( $base[0] );

				$args['add_fragment'] = '?' . implode( '?', $base );

			endif;

			$links = paginate_links( $args );

			foreach ( $links as $link ) :

				$list[] = '<li class="page-numbers">' . $link . '</li>';

			endforeach;

			return '<div id="dfbm_blog_pagination" class="dfbm_blog_pagination">
				    <div class="pages">' . $now . '</div>
					   <div class="pagination">
					       <ul>'
						     . implode( $list ) .
					      '</ul>
					   </div>
				    </div>';

		} // end buildPagination

		/**
		 * Build the filter
		 *
		 * @since 1.0.0
		 */
		public static function buildTheFilter( $incl = '', $excl = '', $slug = 'category', $sep )
		{

			$terms_args =
			[

				'include' 	 => $incl ? explode ( ',', $incl ) : '',
				'exclude' 	 => $excl ? explode ( ',', $excl ) : '',
				'orderby' 	 => 'name',
				'order'   	 => 'ASC',
				'hide_empty' => true,

			];

			$terms  = get_terms( $slug, $terms_args );

			if ( is_wp_error( $terms ) ) :

				return '
					<ul id="dfbm-cat-nav" class="clearfix">
						<li class="et_pb_blog_filter link all">' . $terms->get_error_message() . '</li>
					</ul>';

			endif;

			foreach ( $terms as $term  ) :

				$ids[] = esc_html( $term->term_id );

			endforeach;

			if ( $sep )
				$sep = '<li class="et_pb_blog_filter seperator">' . apply_filters( 'dfbm_filter_separator', ' / ' ) . '</li>';

			$walker = new dfbmControllerWalker( true, $sep );

			$links  = $walker->walk( $terms, 0 );

			return sprintf( '
				<ul id="dfbm-cat-nav" class="clearfix">
					<li class="et_pb_blog_filter link all">
						<a href="%1$s" class="active cat-selector all" data-cat-name="%2$s" data-cat-id="%3$s">%2$s</a>
					</li>
					%4$s
				</ul>',
				( class_exists( 'WooCommerce' ) && is_woocommerce() ? get_permalink( woocommerce_get_page_id( 'shop' ) ) : explode( '?', html_entity_decode( get_pagenum_link(1) ) )[0] ),
				esc_html__( 'All', DFBM()->domain() ),
				isset( $ids ) ? implode( ',', $ids ) : 'none',
				isset( $links ) ? $links : ''
			);

		} // end buildTheFilter

		/**
		 * Get the WooCommerce Breadcrumb
		 *
		 * @since 1.0.0
		 */
		public static function getWooBreadcrumb()
		{

			global $wp_query;

			$args = apply_filters( 'woocommerce_breadcrumb_defaults',
			[

				'delimiter'   => '&nbsp;&#47;&nbsp;',
				'wrap_before' => '<nav class="woocommerce-breadcrumb">',
				'wrap_after'  => '</nav>',
				'before'      => '',
				'after'       => '',
				'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),

			] );

			$breadcrumbs = new WC_Breadcrumb();

			if ( ! empty( $args['home'] ) )
				$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );

			$args['breadcrumb'] = $breadcrumbs->generate();

			extract( $args );

			ob_start();

				require_once( WC()->plugin_path() . '/templates/global/breadcrumb.php' );

			return ob_get_clean();

		} // end getWooBreadcrumb

		/**
		 * Get the WooCommerce Results Overview
		 *
		 * @since 1.0.0
		 */
		public static function getWooResults()
		{

			ob_start();

				require_once( WC()->plugin_path() . '/templates/loop/result-count.php' );

			return ob_get_clean();

		} // end getWooResults

		/**
		 * Get the posttypes
		 *
		 * @since 1.0.0
		 */
		public static function getPosttypes()
		{

			$cpts = get_post_types( [ 'public' => true, 'publicly_queryable' => true, 'show_ui' => true ] );

			if ( apply_filters( 'dfbm_disable_attachment_for_pt', true ) )
				unset( $cpts['attachment'] );

			return $cpts;

		} // end getPosttypes

		/**
		 * Get posttype by taxonomy
		 *
		 * @since 1.0.0
		 */
		public static function getPosttypeByTaxonomy( $tax )
		{

			$cpts = self::getPosttypes();

			foreach ( $cpts as $cpt ) :

				if ( in_array( $tax, get_object_taxonomies( $cpt ) ) )
					return $cpt;

			endforeach;
		} // end getPosttypeByTaxonomy

		/**
		 * Sanitize Post and Strip out Shortcodes
		 *
		 * @since 1.0.0
		 */
		public static function prettifyContent( $content )
		{

			$content = apply_filters( 'dfbm_strip_shortcodes', true ) ? wpautop( preg_replace('#\[[^\]]+\]#', '', $content ) ) : wpautop( $content );

			return self::stripContentUrlImg( $content );

		} // end prettifyContent

		/**
		 * Strip URLs at the beginning of the post content
		 *
		 * @since 1.0.3
		 */
		public static function stripContentUrlImg( $text )
		{

			if ( apply_filters( 'dfbm_strip_out_plain_url', true ) )
			{

				$parts = explode( "\n", $text, apply_filters( 'dfbm_strip_url_explode_count', 5 ) );

				foreach ( $parts as $key => $part ) :

					if ( self::isIn( '<p>http', $part ) || self::isIn( '<p><img ', $part ) || ( self::isIn( '<p><a ', $part ) && self::isIn( '<img ', $part ) ) )
						unset( $parts[$key] );

				endforeach;

			    $text = implode( ' ', $parts );

			} // end if

			return $text;

		} // end stripContentUrlImg

		/**
		 * Check if needle is inside the haystack
		 *
		 * @since 1.0.9
		 */
		public static function isIn( $need, $hay )
		{

			return false !== strpos( $hay, $need );

		} // end isIn

		/**
		 * Check if needle is not inside the haystack
		 *
		 * @since 1.0.9
		 */
		public static function notIn( $need, $hay )
		{

			return false === strpos( $hay, $need );

		} // end notIn

		/**
		 * Limit the wordcount
		 *
		 * @since 1.0.0
		 */
		public static function limitWordcount( $text, $limit )
		{

		    return implode( ' ', array_slice( explode( ' ', $text, $limit + 1 ), 0, $limit ) ) . apply_filters( 'dfbm_limit_wordcount_suffix', '...' );

		} // end limitWordcount

		/**
		 * Get category slug
		 *
		 * @since 1.0.0
		 */
		public static function getTaxonomySlug( $cpt = 'post', $type = 'cat' )
		{

			if ( $slug = apply_filters( "dfbm_{$cpt}_{$type}", false ) )
				return $slug;

			foreach ( get_object_taxonomies( $cpt ) as $slug ) :

				if ( self::notIn( $type, $slug ) )
					continue;

				return $slug;

			endforeach;
		} // end getTaxonomySlug

		/**
		 * Get layout html
		 *
		 * @since 1.0.0
		 */
		public static function getLayoutHtml( $id )
		{

			$p = get_post( (int) $id );

			return ( ET_BUILDER_LAYOUT_POST_TYPE == $p->post_type ) ? do_shortcode( $p->post_content ) : false;

		} // end getLayoutHtml

		/**
		 * Get the categories
		 *
		 * @since 1.0.0
		 */
		public static function getCategories( $args = [], $cat = '', $route = '', $cpt )
		{

			$defaults = apply_filters( 'dfbm_' . $cat . '_category_options',
			[

				'taxonomy'   => $cat,
				'orderby'    => 'count',
				'order'      => 'DESC',
				'hide_empty' => false,

			]); // end $defaults

			$cats = get_terms( wp_parse_args( $args, $defaults ) );

			if ( is_wp_error( $cats ) ) :

				$output = '<p>' . esc_html__( "The used taxonomy slug is invalid. Check your settings.", DFBM()->domain() ) . '</p>';

			elseif ( empty( $cats ) ) :

				$output = '<p>' . esc_html__( "Currently there are no categories to find. Please add some.", DFBM()->domain() ) . '</p>';

			else :

				$walker  = new dfbmControllerWalker( false, false, true );

				$output  = $walker->walk( $cats, 0 );

				$output .= "\t" . "<%
				if( 'undefined' !== typeof et_pb_&&route&&_categories )
				{
					et_pb_&&route&&_categories = '#&&route&&-' + et_pb_&&route&&_categories.replace( /,/g, ',#&&route&&-' );
					setTimeout( function(){ jQuery( et_pb_&&route&&_categories ).attr( 'checked', true ) }, 10 );
				}%>" . "\n";

			endif;

			$output = '<div id="et_pb_&&route&&_categories" style="' . self::checkboxStyle() . '">' . $output . '</div>';

			return apply_filters( 'dfbm_' . $cat . '_options_html', str_replace( '&&route&&', $route, $output ) );

		} // end getCategories

		/**
		 * Get the tags
		 *
		 * @since 1.0.0
		 */
		public static function getTags( $args = [], $tag = '', $route = '', $cpt )
		{

			$hook = $tag;

			$defaults = apply_filters( 'dfbm_' . $tag . '_category_options',
			[

				'taxonomy'   => $tag,
				'orderby'    => 'count',
				'order'      => 'DESC',
				'hide_empty' => false,

			]); // end $defaults

			$tags = get_terms( wp_parse_args( $args, $defaults ) );

			if ( is_wp_error( $tags ) ) :

				$output = '<p>' . esc_html__( "The used taxonomy slug is invalid. Check your settings.", DFBM()->domain() ) . '</p>';

			elseif ( empty( $tags ) ) :

				$output = '<p>' . esc_html__( "Currently there are no tags to find. Please add some.", DFBM()->domain() ) . '</p>';

			else :

				$output = '';

				foreach ( $tags as $tag ) :

					$output .= sprintf(
						'%3$s<label class="dfbm-tags"><input id="&&route&&-%1$s" type="checkbox" name="et_pb_&&route&&_tags" value="%1$s">%2$s</label><br/>',
						esc_attr( $tag->term_id ),
						esc_html( $tag->name ),
						"\n\t\t\t\t\t"
					);

				endforeach;

				$output .= "\t" . "<%
				if( 'undefined' !== typeof et_pb_&&route&&_tags )
				{
					et_pb_&&route&&_tags = '#&&route&&-' + et_pb_&&route&&_tags.replace( /,/g, ',#&&route&&-' );
					setTimeout( function(){ jQuery( et_pb_&&route&&_tags ).attr( 'checked', true ) }, 10 );
				}%>" . "\n";

			endif;

			$output = '<div id="et_pb_&&route&&_tags" style="' . self::checkboxStyle() . '">' . $output . '</div>';

			return apply_filters( 'dfbm_' . $hook . '_options_html', str_replace( '&&route&&', $route, $output ) );

		} // end getTags

		/**
		 * Get checkbox list style
		 *
		 * @since 1.0.0
		 */
		public static function checkboxStyle()
		{

			return 'max-height:95px;overflow:scroll;border:1px solid #eee;padding:5px;width:350px;max-width:350px;';

		} // end checkboxStyle

		/**
		 * Enqueue Scripts
		 *
		 * @since 1.0.0
		 */
		public static function noPosts()
		{

			$message = esc_html__( 'There are no more posts for this category / tag. Please add another one..', DFBM()->domain() );

			$message = sprintf(
				'<div id="dfbm_blog_pagination" class="dfbm_blog_pagination no-posts">
					<p class="dfbm-response dfbm-error">%1$s</p>
				</div>',
				esc_html( apply_filters( 'dfbm_no_posts_message', $message ) )
			);

			return apply_filters( 'dfbm_no_posts_html', $message );

		} // end noPosts

		/**
		 * Get a alternative nonce
		 *
		 * @since 1.0.0
		 */
		public static function getNonceAlt( $a = false )
		{

		    $met = 'AES-256-CBC';
		    $key = hash( 'sha256', NONCE_KEY );
		    $vec = substr( hash( 'sha256', NONCE_SALT ), 0, 16 );

		    if ( ! $a )
		    	return base64_encode( openssl_encrypt( time() . AUTH_KEY, $met, $key, 0, $vec ) );

		    $decrypt = openssl_decrypt( base64_decode( utf8_encode( $a ) ), $met, $key, 0, $vec );
		    $length  = strlen( AUTH_KEY );
		    $check   =
		    [
		    	'time' => (int) substr( $decrypt, 0, strlen( $decrypt ) - $length ),
		    	'auth' => substr( $decrypt, - $length ),
		    ];

		    if ( AUTH_KEY == $check['auth'] && ( ( $check['time'] - time() ) < apply_filters( 'dfbm_alt_nonce_life', 600 ) ) )
		    	return true;

		    return false;

		} // end getNonceAlt

		/**
		 * Enqueue Scripts
		 *
		 * @since 1.0.0
		 */
		public static function enqueScripts( $args, $frontEnd = false, $masonry = false )
		{

			$locBlog =
			[

				'nonce'  => DFBM()->dfbmIsCached() ? self::getNonceAlt() : wp_create_nonce( 'dfbm-nonce-value' ),
				'url'    => admin_url( 'admin-ajax.php' ),
				'cMax'   => esc_attr( $args['column_max'] ),
				'cDist'  => esc_attr( $args['article_distance'] ),
				'cWidth' => apply_filters( 'dfbm_column_collapse_max_width', absint( et_get_option( 'content_width', '1080' ) ) ),
				'lBase'  => explode( '?', html_entity_decode( get_pagenum_link(1) ) )[0],
				'page'   => is_page() || is_single() ? true : false,
				'header' => 'on' == $args['scroll_animate_offset'] ? esc_attr( $args['scroll_offset_height'] ) : false,
				'mobile' => 'on' == $args['scroll_animate_offset'] ? esc_attr( $args['scroll_offset_height_mob'] ) : false,
				'ltBox'  => 'on' == ( $args['use_dfbm_lightbox'] ) ? 'on' : false,

			];

			if ( $frontEnd )
				wp_enqueue_style( DFBM()->prefix() . '-blogthread' );

			if ( $masonry )
				wp_enqueue_script(  DFBM()->prefix() . '-masonry' );

			wp_enqueue_script(  DFBM()->prefix() . '-blogthread' );

			wp_localize_script( DFBM()->prefix() . '-blogthread', 'dfbmPhp', $locBlog );

			if ( 'on' == ( $args['use_dfbm_lightbox'] ) )
			{

				$locLB =
				[

					'header' => esc_attr( $args['lightbox_header'] ),
					'close'  => esc_attr( $args['lightbox_close'] ),
					'width'  => (int) $args['lightbox_width'] > 99 ? 99 : esc_attr( $args['lightbox_width'] ),
					'cdn'    => $args['cdn_origin'],
					'more'   => $args['read_more_text'],

				];

				wp_enqueue_script(  DFBM()->prefix() . '-lightbox' );
				wp_localize_script( DFBM()->prefix() . '-lightbox', 'dfbmPhpLB', $locLB );

			} // end if

			if ( 'on' == $args['videos_in_feed'] )
			{

				wp_enqueue_style( 'wp-mediaelement' );
				wp_enqueue_script( 'wp-mediaelement' );

			} // end if
		} // end enqueScripts
	} // end class
} // end if
