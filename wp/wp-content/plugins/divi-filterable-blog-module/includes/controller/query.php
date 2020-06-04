<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Query
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerQuery' ) )
{

	class dfbmControllerQuery
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $layout;

		private $getLayout;

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
		 * Check query for archive and / or search
		 *
		 * @since 1.0.0
		 */
		public function initialize()
		{

			add_action( 'pre_get_posts', [ $this, 'query' ] );

		} // end initialize

		/**
		 * Get query and redirect the template when needed
		 *
		 * @since 1.0.0
		 */
		public function query( $q )
		{

			$main = $q->is_main_query() ? true : false;

			if ( ( $main && ( $q->is_archive || $q->is_search ) ) || isset( DFBM()->getLayout()->redirect ) ) :

				$this->getLayout = new dfbmModelGet;

				if ( 'on' == DFBM()->getLayout()->archSearch && $main && $q->is_search ) :

					if ( class_exists( 'WooCommerce' )
						 && 'on' == DFBM()->getLayout()->archWoo
						 && isset( $q->query['post_type'] ) && 'product' == $q->query['post_type']
						 && $this->layout = $this->getLayout->layout( 'shop' ) ) :

						$shopSearch = true;

						DFBM()->setLayout( true, 'shop' );

						DFBM()->setLayout( 'product', 'pt' );

					else :

						$this->layout = $this->getLayout->layout( 'search' );

					endif;

					if ( $this->layout )
						DFBM()->setLayout( $q->query['s'], 'search' );
?>
<?php			else :

					$isArchive = ( $q->is_category || $q->is_tag || $q->is_tax ) ? true : false;

					if ( $main && ( $q->is_author || $q->is_post_type_archive || $isArchive ) ) :

						if ( 'on' == DFBM()->getLayout()->archAuthor && $q->is_author ) :

							if ( ( $this->layout = $this->getLayout->layout( 'author' ) ) ) :

								if ( isset( $q->query['author'] ) )
									DFBM()->setLayout( $q->query['author'], 'author' );

							endif;
?>
<?php					else :

							$isShop = isset( $q->query_vars['wc_query'] ) ? true : false;

							if ( class_exists( 'WooCommerce' )
							      && 'on' == DFBM()->getLayout()->archWoo && $isShop ) :

								if ( $this->layout = $this->getLayout->layout( 'shop' ) ) :

									if ( $q->is_post_type_archive  )
										DFBM()->setLayout( 'index', 'archive' );

								endif;
							endif;

							if ( 'on' == DFBM()->getLayout()->archArchive && ! $isShop && $isArchive ) :

								$this->layout = $this->getLayout->layout( 'archive' );

							endif;

							if ( $this->layout ) :

								if ( $isArchive ) :

									$key   = $q->get_queried_object()->taxonomy;

									$value = $q->get_queried_object()->slug;

									$type  = false !== strpos( $key, 'cat' ) ? 'cat' : 'tag';

									if ( 'cat' == $type )
										$key = 'category' == $key ? $key . '_name' : $key;

									if ( 'tag' == $type )
										$key = 'post_tag' == $key ? $type : $key;

									DFBM()->setLayout( 'tax', 'archive' );

									DFBM()->setLayout( $type, 'tax' );

									DFBM()->setLayout( $key, 'key' );

									DFBM()->setLayout( $value, 'value' );

								endif;

								if ( is_a( $q->get_queried_object(), 'WP_Post_Type' ) )
									DFBM()->setLayout( $q->get_queried_object()->name, 'pt' );

								else
									DFBM()->setLayout( dfbmControllerBlogposts::getPosttypeByTaxonomy( $q->get_queried_object()->taxonomy ), 'pt' );

							endif;
						endif;
					endif;
				endif;

				if ( $this->layout || isset( DFBM()->getLayout()->redirect ) ) :

					if ( $main ) :

						DFBM()->setLayout( true, 'redirect' );

						DFBM()->setLayout( $this->layout, 'layout' );

						if ( isset( $q->query['paged'] ) )
							DFBM()->setLayout( $q->query['paged'], 'paged' );

						if ( isset( $isShop ) && $isShop )
							DFBM()->setLayout( true, 'shop' );

						$addArgs = ( new dfbmModelGet )->meta( $this->layout->ID, '_dfbm_initial_query' );

						if ( isset( $addArgs['posts_featured'], DFBM()->getLayout()->pt ) ) :

							$addArgs['posts_featured'] = dfbmControllerBlogposts::checkFeaturedIds( $addArgs['posts_featured'], DFBM()->getLayout()->pt );

							if ( $addArgs['posts_featured'] )
								DFBM()->setLayout( $addArgs['posts_featured'], 'featured' );

						endif;

						$addArgs = dfbmControllerBlogposts::buildQuery( $addArgs, false, false, false );

						foreach ( $addArgs as $key => $value ) :

							$q->set( $key, $value );

						endforeach;

						DFBM()->setLayout( $addArgs, 'query' );

					endif;

					return new dfbmControllerView( 'template' );

				endif;

				DFBM()->setLayout( false );

			endif;
		} // end query
	} // end class
} // end if
