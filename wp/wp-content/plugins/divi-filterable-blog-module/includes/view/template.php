<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' ); ?>

<?php if ( isset( DFBM()->getLayout()->shop ) ) : ?>

<?php global $shortname; ?>

<?php get_header( 'shop' ); ?>

	<?php if ( apply_filters( 'dfbm_show_before_main_content', true ) ) : ?>

		<?php if ( apply_filters( 'dfbm_hide_woocommerce_breadcrumb', false ) ) : ?>

			<?php remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_main_content' ); ?>

	<?php endif; ?>

	    <header class="woocommerce-products-header">

			<?php if ( apply_filters( 'dfbm_show_shop_title', true ) && 'extra' != $shortname ) : ?>

				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

			<?php endif; ?>

			<?php if ( apply_filters( 'dfbm_show_shop_description', true ) ) : ?>

				<?php do_action( 'woocommerce_archive_description' ); ?>

			<?php endif; ?>

	    </header>

	<?php if ( apply_filters( 'dfbm_show_shop_filter', true ) ) : ?>

		<?php do_action( 'woocommerce_before_shop_loop' ); ?>

	<?php endif; ?>

<?php else : ?>

	<?php get_header(); ?>

	<div id="main-content">
		<div class="container dfbm">
			<article class="page type-page status-publish hentry">
				<div class="entry-content">

<?php endif; ?>


	<?php echo do_shortcode( apply_filters( 'dfbm_archive_layout_include', DFBM()->getLayout()->layout->post_content ) ); ?>


<?php if ( isset( DFBM()->getLayout()->shop ) ) : ?>

	<?php do_action( 'woocommerce_after_main_content' ); ?>

	<?php get_footer( 'shop' ); ?>

<?php else : ?>

				</div><!-- .entry-content -->
			</article><!-- .page.type-page -->
		</div> <!-- .container -->
	</div> <!-- #main-content -->

	<?php get_footer(); ?>

<?php endif; ?>
