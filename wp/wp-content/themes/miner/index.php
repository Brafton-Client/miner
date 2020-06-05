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
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$filters = $_GET;
$tax_query = null;


	if(isset($filters['content-type'])){
		$tax_query[] = array( 
			'taxonomy'	=> 'content-type',
			'field'		=> 'slug',
			'terms'		=> array($filters['content-type'])
		);
	}
	if(isset($filters['product'])){
		$tax_query[] = array( 
			'taxonomy'	=> 'category',
			'field'		=> 'slug',
			'terms'		=> array($filters['product'])
		);
	}
	if(isset($filters['industry'])){
		$tax_query[] = array( 
			'taxonomy'	=> 'industry',
			'field'		=> 'slug',
			'terms'		=> array($filters['industry'])
		);
	}
if($tax_query && count($tax_query) > 1){
	$tax_query['relation'] = 'AND';
}
$resources_parameters = array(
	'post_type'	=> 'post',
	'posts_per_page'	=> 8,
	'post__not_in'	=> $sticky,
	'ignore_sticky_posts'	=> 1,
	'paged'	=> $paged
	);
if(isset($filters['s']) && $tax_query == null){
	$resources_parameters['s'] = $filters['s'];
}
if($tax_query){
	$resources_parameters['tax_query'] = $tax_query;
}
$resources = new WP_Query($resources_parameters);

$content_types = get_terms('content-type');
$products = get_terms('category');
$industries = get_terms('industry');
function minerSelectedValue($value, $slug){
	if($value == $slug){
		echo 'selected';
	}
}
?>

<div id="main-content">
    <div class="filter-criteria">
        <div class="container">
            <form id="filters" class="filters" method="get" >
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/red-triangle.svg" class="embelish"/>
                <div class="filter">
                    <select class="content-type" name="content-type" value="">
						<option value="">Content Type</option>
						<?php foreach($content_types as $content_type){?>
							<option <?php minerSelectedValue($filters['content-type'], $content_type->slug); ?> value="<?php echo $content_type->slug; ?>"><?php echo $content_type->name; ?></option>
						<?php } ?>
                    </select>
                </div>
                <div class="filter">
                    <select class="product" name="product" value="">
												<option value="">Product</option>
					<?php foreach($products as $product){?>
							<option <?php minerSelectedValue($filters['product'], $product->slug); ?> value="<?php echo $product->slug; ?>"><?php echo $product->name; ?></option>
						<?php } ?>
                    </select>
                </div>
                <div class="filter">
                    <select class="industry" name="industry" value="">
											<option value="">Industry</option>
					<?php foreach($industries as $industry){?>
							<option <?php minerSelectedValue($filters['industry'], $industry->slug); ?> value="<?php echo $industry->slug; ?>"><?php echo $industry->name; ?></option>
						<?php } ?>
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
		<div class="container items">
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
    <div class="container items">
        <!-- <div id="content-area" class="clearfix"> -->

            <?php
			if ( $resources->have_posts() ) :
				while ( $resources->have_posts() ) : $resources->the_post();
					$post_format = et_pb_post_format(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?> >
					<div class="featured-image">
						<?php the_post_thumbnail('full'); ?>
						<div class="shadow">
							
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
				</article> <!-- .et_pb_post -->
            <?php
					endwhile;
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>



		<!-- </div> #content-area -->
		<?php 
	$bignum = 999999999;
	if ( $resources->max_num_pages > 1 ){
		
		echo '<nav class="pagination">';
		echo paginate_links( array(
		'format'       => 'page/%#%',
		'current'      => max( 1, get_query_var('paged') ),
		'total'        => $resources->max_num_pages,
		'prev_text'    => '',
		'next_text'    => 'Next',
		'type'         => 'list',
		'end_size'     => 1,
		'mid_size'     => 1,
		//   'add_fragment'	=> '?content_type=books'
		) );
		echo '</nav>';
	}
	?>
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();