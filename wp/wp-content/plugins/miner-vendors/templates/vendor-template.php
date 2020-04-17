<?php
 
 $vendor_query = new WP_Query(
	 array(
		 'post_type' =>'vendor',
		 'post_status' => 'publish',
         'posts_per_page' => 8, 
	)
);

/**
 * @param $r array
 * reformat city data object array into multidimensional array
 */
function getCities($r){
	return array(
		'name'=>$r->name,
		'slug'=>$r->slug
	);
}
$cities = get_terms([
    'taxonomy' => 'vendor_city',
    'hide_empty' => false,
]);
$products = get_terms([
    'taxonomy' => 'vendor_product',
    'hide_empty' => false,
]);
$vendor_cities = array_map('getCities',$cities);
?>
<div id="miner-vendor-lp">
<select name="cities" id="cities-select">
	<option value="">--Please choose an option--</option>
	<?php 
	foreach($vendor_cities as $city) { 
		?>
    	<option style='color: #000' value='<?php echo $city["slug"] ?>'><?php echo $city["name"] ?></option>
    <?php } ?>
</select>
<div class="chart">
		<div class="products">
			<?php foreach($products as $product) {
				?>
				<div class="chart-column">
					<div class="product">
						<!-- alternate route needed for assigning image to product id, need to back-out ACF function call! -->
						<img src="<?php echo MINER_PLUGIN_URL.'images/'.$product->slug.'.png'; ?>" alt="<?php echo $product->term_id ?>" />
						<h4><?php echo $product->name ?></h4>
					</div>
					<div class="vendors" id="product-<?php echo $product->term_id; ?>">
						<?php 
							$vendor_query = new WP_Query(
									array(
										'post_type' =>'vendor',
										'post_status' => 'publish',
										'posts_per_page' => -1, 
										'tax_query'	=> array( 
											array( 
												'taxonomy'	=> 'vendor_product',
												'field'		=> 'term_id',
												'terms'		=> $product->term_id
											)
										)
								)
							);
							if ( $vendor_query->have_posts() ) {

								// Load posts loop.
									while ( $vendor_query->have_posts() ) {
										$vendor_query->the_post();
										the_post_thumbnail();
									}

							}
						?>
					</div>
				</div>
			<?php } ?>
		</div>
</div>
</div>