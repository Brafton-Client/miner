<?php
 
 $vendor_query = new WP_Query(
	 array(
		 'post_type' =>'vendor',
		 'post_status' => 'publish',
         'posts_per_page' => 8, 
	)
);
$cities = get_terms([
    'taxonomy' => 'vendor_city',
    'hide_empty' => false,
]);
/*if($vendor_query->have_posts() ) : while ($vendor_query->have_posts() ) : $vendor_query->the_post();
the_title();
endwhile;

endif;*/
echo '<pre>';
var_dump($cities);
 
?>