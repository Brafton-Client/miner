<?php get_header(); 

$sticky = get_option('sticky_posts');
if(count($sticky) > 4){
	$sticky_adjusted = array_slice($sticky, 0, 4);
}
$sticky_resources_parameters = array(
	'post_type'	=> 'post',
	'posts_per_page'	=> 4,
	'post__in'	=> $sticky_adjusted,
	'ignore_sticky_posts'	=> 1

);
$sticky_resources = new WP_Query($sticky_resources_parameters);

$resources_parameters = array(
	'post_type'	=> 'post',
	'posts_per_page'	=> 8,
	'post__not_in'	=> $sticky,
	'ignore_sticky_posts'	=> 1
	);
$resources = new WP_Query($resources_parameters);

?>

<div id="main-content">
    <div class="filter-criteria">
        <div class="container">
            <form class="filters">
                <div class="filter">
                    <select class="content-type" name="content-type" value="">
                        <option value="">eBooks</option>
                    </select>
                </div>
                <div class="filter">
                    <select class="product" name="product" value="">
                        <option value="">Docks</option>
                    </select>
                </div>
                <div class="filter">
                    <select class="industry" name="industry" value="">
                        <option value="">Oil</option>
                    </select>
                </div>
            </form>
            <form class="search">
                <div class="search">
                    <input type="text" placeholder="Search" name="s" />
                </div>
            </form>
        </div>
	</div>
	<?php if( $sticky_resources->have_posts()){ ?>
	<div class="featured-resources">
		<div class="container">
			<h2>Featured Items</h2>
			<?php while ( $sticky_resources->have_posts() ) { $sticky_resources->the_post(); 
				
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?> >
					<div class="featured-image">
						<?php the_post_thumbnail('full'); ?>
						<div class="shadow">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/star.png" class="feature"/>
						</div>
					</div>
				<?php $cats = get_the_category();
				if($cats){
					$count = count($cats);
					echo '<p>';
					foreach($cats as $cat){
						echo $cat->name;
						$count--;
						if($count > 0){
							echo ', ';
						}
					}
					echo '</p>';
				} ?>
				<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</article>
			<?php }?>
		</div>
	</div>
	<?php } ?>
    <div class="container">
        <div id="content-area" class="clearfix">

            <?php
			if ( $resources->have_posts() ) :
				while ( $resources->have_posts() ) : $resources->the_post();
					$post_format = et_pb_post_format(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

                <?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$alttext   = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb     = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								et_core_esc_previously( $first_video )
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
                <a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
                    <?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
                </a>
                <?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

                <?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
                <?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h2>
                <?php endif; ?>

                <?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							truncate_post( 270 );
						} else {
							the_content();
						}
					?>
                <?php endif; ?>

            </article> <!-- .et_pb_post -->
            <?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>



        </div> <!-- #content-area -->
    </div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();