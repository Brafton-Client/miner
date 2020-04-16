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
			<?php foreach($products as $product) { ?>
				<div class="chart-column">
					<div class="product"><?php echo $product->name ?></div>
					<div class="vendors">
					test
					</div>
				</div>
			<?php } ?>
		</div>
</div>
