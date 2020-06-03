<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Ajax
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerAjax' ) )
{

	class dfbmControllerAjax
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

			require_once( DFBM()->divFunc() );

			require_once( DFBM()->divElem() );

			add_action( 'wp_ajax_dfbm_get_posts', [ $this, 'getPosts' ] );

			add_action( 'wp_ajax_nopriv_dfbm_get_posts', [ $this, 'getPosts' ] );

			add_action( 'wp_ajax_dfbm_get_video', [ $this, 'getVideo' ] );

			add_action( 'wp_ajax_nopriv_dfbm_get_video', [ $this, 'getVideo' ] );

			add_action( 'wp_ajax_dfbm_set_archive_query', [ $this, 'setArchiveQuery' ] );

			add_action( 'wp_ajax_nopriv_dfbm_get_nonce', [ $this, 'getNonceAlt' ] );

		} // end initialize

		/**
		 * Get the posts
		 *
		 * @since 1.0.0
		 */
		public function getPosts()
		{

			if ( $this->verifyRequest( 'post' ) ) :

				$this->sanitizePost();

				$obj = new stdClass();

				$pag = false;

				switch ( $obj->case = $_POST['option'] ) :

				    case 'category' :

				    	$q = $_POST['query'];

				    	$visibility = [];

				    	$rating = $metaQuery = $order = $orderby = $metaKey = '';

						$args['custom_posttypes'] = $q['post_type'];

						$args['posts_number'] = (int) $_POST['atts']['posts_number'];

						$args['include_' . $q['post_type'] . '_categories'] = $_POST['target'];

						if ( isset( $_POST['targetNot'] ) )
							$args['exclude_' . $q['post_type'] . '_categories'] = $_POST['targetNot'];

						if ( is_array( $_POST['atts']['posts_featured'] ) )
							$args['posts_featured'] = $this->arrayStringInt( $_POST['atts']['posts_featured'] );

						if ( isset( $q['tax_query'] ) ) :

							foreach ( $q['tax_query'] as $key => $value ) :

								if ( 'product_visibility' == $value['taxonomy'] || false !== strpos( $value['taxonomy'], 'tag' ) )
									$visibility[] = $value;

							endforeach;
						endif;

						if ( isset( $q['orderby'] ) )
							$orderby = $q['orderby'];

						if ( isset( $q['order'] ) )
							$order = $q['order'];

						if ( isset( $q['meta_key'] ) )
							$metaKey = $q['meta_key'];

						if ( isset( $q['meta_query'] ) )
							$metaQuery = $q['meta_query'];

						$q = dfbmControllerBlogposts::buildQuery( $args, false, false, false );

						if ( $visibility )
							$q['tax_query'] = isset( $q['tax_query'] ) ? array_merge( $q['tax_query'], $visibility ) : $visibility;

						if ( $metaQuery )
							$q['meta_query'] = $metaQuery;

						if ( $metaKey )
							$q['meta_key'] = $metaKey;

						if ( $order )
							$q['order'] = $order;

						if ( $orderby )
							$q['orderby'] = $orderby;

						$_POST['query'] = $q;

						$obj->target = $_POST['target'];

						$obj->name = $_POST['name'];

						$pag = esc_url( $_POST['base'] );

				        break;

				    case 'paged' :

						$_POST['query']['paged'] = (int) $_POST['target'];

				    	if ( 0 === $_POST['query']['paged'] )
							$_POST['query']['paged'] = 2;

						if ( 1 === $_POST['query']['paged'] )
							$_POST['query']['paged'] = 0;

						$offset = (int) $_POST['atts']['offset_number'];

						if ( $offset > 0 )
							$this->calcOffset( $offset );

						$pag = esc_url( $_POST['base'] );

				        break;

				    case 'more' :

				    	if ( 0 === $_POST['query']['paged'] )
							$_POST['query']['paged'] = 2;

						else
							$_POST['query']['paged']++;

						$offset = (int) $_POST['atts']['offset_number'];

						if ( $offset > 0 )
							$this->calcOffset( $offset );

				        break;

				endswitch;

				$obj->query = $_POST['query'];

				if ( 'product' == $obj->query['post_type'] ) :

					new dfbmControllerInitialize;

					new WC_Query;

				endif;

				$obj->content = $this->fetchPosts( $pag );

				if ( is_int( DFBM()->getQuery() ) )
					$obj->query['maximum_pages'] = DFBM()->getQuery();

				echo json_encode( $obj );

			endif;

			wp_die();

		} // end getPosts

		/**
		 * Calculate the query offset
		 *
		 * @since 1.0.0
		 */
		protected function calcOffset( $offset )
		{

			if ( (int) $_POST['query']['paged'] > 0 )
				$_POST['query']['offset'] = ( ( (int) $_POST['query']['paged'] - 1 ) * (int) $_POST['query']['posts_per_page'] ) + $offset;

			else
				$_POST['query']['offset'] = (int) $offset;

		} // end calcOffset

		/**
		 * Fetch the posts
		 *
		 * @since 1.0.0
		 */
		protected function fetchPosts( $pag )
		{

			$s     = $_SERVER;

			$obj   = new stdClass();

			$posts = dfbmControllerBlogposts::buildFeed( $_POST['query'], $_POST['atts'], false, false, false, $pag );

			if ( ! empty( $posts->posts ) && ! empty( $cdn = esc_attr( $_POST['atts']['cdn_origin'] ) ) ) :

				$srch1  = 'src="' . $s['REQUEST_SCHEME'] . '://' . $s['SERVER_NAME'];

				$rplc1  = 'src="' . $s['REQUEST_SCHEME'] . '://' . $cdn;

				$posts->posts = str_replace( $srch1, $rplc1, $posts->posts );

				$srch2  = 'url(' . $s['REQUEST_SCHEME'] . '://' . $s['SERVER_NAME'];

				$rplc2  = 'url(' . $s['REQUEST_SCHEME'] . '://' . $cdn;

				$posts->posts = str_replace( $srch2, $rplc2, $posts->posts );

			endif;

			$posts->posts = array_map( 'trim', explode( '%,%', $posts->posts ) );

			unset( $posts->posts[ count( $posts->posts ) - 1 ] );

			return $posts;

		} // end fetchPosts

		/**
		 * Sanitize the $_POST-Array
		 *
		 * @since 1.0.0
		 */
		protected function sanitizePost()
		{

			if ( isset( $_POST['query']['posts_per_page'] ) )
				$_POST['query']['posts_per_page'] = (int) $_POST['query']['posts_per_page'];

			if ( isset( $_POST['query']['post_status'] ) )
				$_POST['query']['post_status'] = 'publish';

			if ( isset( $_POST['query']['paged'] ) )
				$_POST['query']['paged'] = (int) $_POST['query']['paged'];

			if ( isset( $_POST['query']['maximum_pages'] ) )
				$_POST['query']['maximum_pages'] = (int) $_POST['query']['maximum_pages'];

			if ( isset( $_POST['query']['post__not_in'] ) )
				$_POST['query']['post__not_in'] = $this->arrayStringInt( $_POST['query']['post__not_in'] );

			if ( isset( $_POST['query']['tax_query'] ) ) :

				foreach ( $_POST['query']['tax_query'] as $key => &$value ) :

					$value['terms'] = $this->arrayStringInt( $value['terms'] );

				endforeach;
			endif;

			if ( count( $atts = dfbmControllerBlogposts::feedDefaults() ) === count( $_POST['atts'] ) )
				$_POST['atts'] = $this->createArgs( $atts );

		} // end sanitizePost

		/**
		 * Set archive initial query
		 *
		 * @since 1.0.0
		 */
		public function setArchiveQuery()
		{

			if ( current_user_can( apply_filters( 'dfbm_edit_archive_capability', 'edit_posts' ) )
				 && $this->verifyRequest( 'query' ) ) :

				$query = $_POST['query'];

				foreach ( $query as $key => $value ) :

					if ( ! empty( $value ) )
						$queryVars[ esc_attr( $key ) ] = esc_attr( $value );

				endforeach;

				( new dfbmModelSet )->meta( $_POST['postID'], '_dfbm_initial_query', $queryVars );

			endif;

			wp_die();

		} // end setArchiveQuery

		/**
		 * Create args
		 *
		 * @since 1.0.0
		 */
		protected function createArgs( $atts )
		{

			$i = 0;

			foreach ( $atts as $key => $value ) :

				$args[$key] = $_POST['atts'][$i];

				$i++;

			endforeach;

			return $args;

		} // end createArgs

		/**
		 * Verify nonce
		 *
		 * @since 1.0.0
		 */
		protected function verifyRequest( $opt )
		{

			$n = isset( $_POST['nonce'] ) ? esc_attr( $_POST['nonce'] ) : false;
			if ( $n && ( DFBM()->dfbmIsCached() ? dfbmControllerBlogposts::getNonceAlt( $n ) : wp_verify_nonce( $n, 'dfbm-nonce-value' ) ) ) :

				if ( ( 'post' == $opt
					   && isset( $_POST['query']['post_type'], $_POST['option'], $_POST['atts'] )
					   && self::verifyCpts( $_POST['query']['post_type'] ) )
				  || ( 'video' == $opt && isset( $_POST['vidLink'] ) && 'dfbm_get_video' == $_POST['action'] )
				  || ( 'query' == $opt && isset( $_POST['postID'], $_POST['query'] ) && 'dfbm_set_archive_query' == $_POST['action'] )
				)
				return true;

			endif;

			wp_die( $this->getError() );

		} // end verifyRequest

		/**
		 * Verify posttypes
		 *
		 * @since 1.0.0
		 */
		protected function verifyCpts( $qpts )
		{

			$cpts = dfbmControllerBlogposts::getPosttypes();

			if ( is_array( $qpts ) ) :

				foreach( $qpts as $key ) :

					if ( ! in_array( $key, $cpts ) ) return false;

				endforeach;

				return true;

			endif;

			if ( ! in_array( $qpts, $cpts ) )
				return false;

			return true;

		} // end verifyCpts

		/**
		 * Change arrays strings to integer
		 *
		 * @since 1.0.0
		 */
		protected function arrayStringInt( $arr ) { return array_map( 'intval', $arr ); } // end arrayStringInt

		/**
		 * Fetch video shortcode
		 *
		 * @since 1.0.0
		 */
		public function getVideo()
		{

			if ( $this->verifyRequest( 'video' ) ) :

				$suff = [ 'mp4', 'webm', 'ogg' ];

				$link = esc_attr( $_POST['vidLink'] );

				foreach ( $suff as $key ) :

					if ( false !== strpos( $link, $key ) ) :

						$link = str_replace( $key, '', $link );

						break;

					endif;
				endforeach;

				$s     = $_SERVER;

				$host  = ! empty( $cdn = esc_attr( $_POST['cdn'] ) )
						 ? $s['REQUEST_SCHEME'] . '://' . $cdn
						 : $s['REQUEST_SCHEME'] . '://' . $s['SERVER_NAME'];

				if ( $cdn && false === strpos( $link, $cdn ) )
					$link = str_replace( $s['SERVER_NAME'], $cdn, $link );

				$short = '[video';

				foreach ( $suff as $key ) :

					if ( file_exists( ABSPATH . str_replace( $host . '/', '', $link ) . $key ) )
						$short .= ' ' . $key . '="' . $link . $key . '"';

				endforeach;

				$short .= ' autoplay="true"][/video]';

				$output = ! empty( $v = do_shortcode( $short ) ) ? $v : $this->noVideo();

				echo json_encode( $output );

			endif;

			wp_die();

		} // end getVideo

		/**
		 * Video error message
		 *
		 * @since 1.0.0
		 */
		protected function noVideo()
		{

			return  '<p class="dfbm-response dfbm-error">'
						. esc_html__( 'That fails. Please check your video settings. If you use a CDN-Service for your embedded videos, you must declare your CDN-Origin within the lightbox module settings.', DFBM()->domain() ) .
					'</p>';

		} // end noVideo

		/**
		 * Get error message
		 *
		 * @since 1.0.0
		 */
		protected function getError()
		{

			return  '<p class="dfbm-response dfbm-error">'
						. esc_html__( 'That fails. Please reload the page and try it again.', DFBM()->domain() ) .
					'</p>';

		} // end getError
	} // end class
} // end if
