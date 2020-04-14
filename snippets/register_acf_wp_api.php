<?php 
/**
 * exposes ACF fields to the built in wordpress api available after wp 4.7
 * for full functionality use
 * https://github.com/airesvsg/acf-to-rest-api#editing-the-fields
 */
$post_type = "post";

function my_rest_prepare_post($data, $post, $request) {  
    $_data = $data->data;

    $fields = get_fields($post->ID);

    foreach ($fields as $key => $value){
        $_data[$key] = get_field($key, $post->ID);
    }

    $data->data = $_data;
    return $data;
}

add_filter("rest_prepare_{$post_type}", 'my_rest_prepare_post', 10, 3);