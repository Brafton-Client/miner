<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Enqueue
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerEnqueue' ) )
{

	class dfbmControllerEnqueue
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $rq;

		private $check;

		private $active;

		private $layout;

		private $content;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			$this->rq = $_REQUEST;

			$this->layout = isset( $this->rq['et_pb_preview'], $this->rq['shortcode'] );

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

			if ( $this->layout )
				add_action( 'wp_head', [ $this, 'detect' ] );

			add_action( 'get_header', [ $this, 'detect' ] );

		} // end initialize

		/**
		 * Detects if shortcode is present
		 *
		 * @since 1.0.0
		 */
		public function detect()
		{

			global $post;

			$this->check = apply_filters( 'dfbm_check_content_for_enqueue', true );

			if ( $this->check ) :

				if ( $this->layout )
					$this->content = $this->rq['shortcode'];

				else
					$this->content = is_object( $l = DFBM()->getLayout() ) && isset( $l->layout )
									 ? $l->layout->post_content
									 : ( $post ? $post->post_content : '' );

				$this->active = false !== strpos( $this->content, 'et_pb_dfbm_blog' );

			endif;

			add_action( 'wp_head', [ $this, 'redirect' ], 1 );

			if ( ! $this->check || $this->active ) :

				if ( apply_filters( 'dfbm_hide_scrollbar', true ) ) :

					add_filter( 'body_class', function( $classes )
					{

				        $classes[] = 'scrollbar-hidden';
				        return $classes;

					}); // end add_filter
				endif;

				if ( $this->layout )
					$this->enqueue();

				else
					add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );

			endif;
		} // end detect

		/**
		 * Check for redirection in page head
		 *
		 * @since 1.0.0
		 */
		public function redirect()
		{

			echo DFBM()->suffix() ? $this->historyCheckMin() : $this->historyCheckNorm();

		} // end redirect

		/**
		 * Enqueue and get options for localized scripts
		 *
		 * @since 1.0.0
		 */
		public function enqueue()
		{

			$masonry = DFBM()->prefix() . '-masonry';
			$threat  = DFBM()->prefix() . '-blogthread';
			$lightbx = DFBM()->prefix() . '-lightbox';

			$dep1 = [ 'jquery' ];
			$dep2 = [ 'jquery', $threat ];

			$this->enqueueStyle( $threat );

			if ( ! $this->check || ( $this->layout && false !== strpos( $this->content, 'use_dfbm_lightbox=\"on\"' ) ) || ( ! $this->layout && false !== strpos( $this->content, 'use_dfbm_lightbox="on"' ) ) ) :

				$this->enqueueStyle( $lightbx );

			endif;

			if ( ! $this->check || ( $this->layout && false !== strpos( $this->content, 'dfbm_fullwidth=\"off\"' ) ) || ( ! $this->layout && false !== strpos( $this->content, 'dfbm_fullwidth="off"' ) ) ) :

				wp_register_script( $masonry, DFBM()->assUrl() . 'js/' . $masonry . DFBM()->suffix() . '.js', array( 'jquery' ), DFBM()->version(), true );

				array_push( $dep1, $masonry );
				array_push( $dep2, $masonry );

			endif;

			$this->registerScript( $threat, $dep1 );

			$this->registerScript( $lightbx, $dep2 );

		} // end enqueue

		/**
		 * Enqueue style
		 *
		 * @since 1.0.0
		 */
		public function enqueueStyle( $slug )
		{

			wp_enqueue_style( $slug, DFBM()->assUrl() .'css/' .  $slug . DFBM()->suffix() . '.css', [], DFBM()->version() );

		} // end enqueueStyle

		/**
		 * Register scripts
		 *
		 * @since 1.0.0
		 */
		public function registerScript( $slug, $dep, $footer = true )
		{

			wp_register_script( $slug, DFBM()->assUrl() . 'js/' . $slug . DFBM()->suffix() . '.js', $dep, DFBM()->version(), $footer );

		} // end enqueueScript

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 */
		public function enqueueScript( $slug, $dep, $footer = true )
		{

			wp_enqueue_script( $slug, DFBM()->assUrl() . 'js/' . $slug . DFBM()->suffix() . '.js', $dep, DFBM()->version(), $footer );

		} // end enqueueScript

		/**
		 * Add redirect check to head - mormal
		 *
		 * @since 1.0.0
		 */
		public function historyCheckNorm()
		{
?>

			<!--noptimize--><script type="text/javascript">

			(function(w){
				"use strict";

				var hst = w.history.state;

				var obj = null != hst && Object.keys(hst).length === 0 && hst.constructor === Object ? false : JSON.parse( hst );

				if ( w.sessionStorage.getItem( 'dfbmRedirect' ) || ( obj && null != obj.state.addMore ) || ( obj && null != obj.state.scroll ) )
					document.documentElement.className += ' redirected';

				if ( obj && null == obj.shop && null != obj.base && null != obj.state && obj.base != w.location.href )
				{

					var search = null != obj.search ? obj.search : false;

					if ( search && obj.base + search == w.location.href )
						return;

					if ( false !== obj.state )
					{

						w.sessionStorage.setItem( 'dfbmRedirect', w.location.href );

						w.history.replaceState( JSON.stringify( obj ), '', obj.base + ( search ? search : '' ) );

						return w.location.reload();

					}
				}
			}(window));

			</script><!--/noptimize-->

<?php
		} // end historyCheckNorm

		/**
		 * Add redirect check to head - mormal
		 *
		 * @since 1.0.0
		 */
		public function historyCheckMin()
		{
?>
<!--noptimize--><script type="text/javascript">!function(e){"use strict";var t=e.history.state,s=(null==t||0!==Object.keys(t).length||t.constructor!==Object)&&JSON.parse(t);if((e.sessionStorage.getItem("dfbmRedirect")||s&&null!=s.state.addMore||s&&null!=s.state.scroll)&&(document.documentElement.className+=" redirected"),s&&null==s.shop&&null!=s.base&&null!=s.state&&s.base!=e.location.href){var a=null!=s.search&&s.search;if(a&&s.base+a==e.location.href)return;if(!1!==s.state)e.sessionStorage.setItem("dfbmRedirect",e.location.href),e.history.replaceState(JSON.stringify(s),"",s.base+(a||"")),e.location.reload()}}(window);</script><!--/noptimize-->
<?php
		} // end historyCheckMin
	} // end class
} // end if
