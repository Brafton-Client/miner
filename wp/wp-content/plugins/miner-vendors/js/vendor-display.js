(function($){
    function getData(city){
        $.ajax({
            type: "post",
            dataType: "json",
            url: miner_ajax.ajax_url,
            data: {
                action: "get_vendors",
                city: city
            },
            success: function(response){
                add_vendor_images(response)
            }
        })
    }
    function add_vendor_images($vendor_array){
        //use jquery to clear out the existing vendor columns
        $('.vendors').empty();
        console.log($vendor_array);
        //loop through the array and populate the columsn with the images
        for(let $product_id in $vendor_array) {
            //console.log($vendor_array[$product_id])
            var $this_products_vendors = $vendor_array[$product_id];
            for(let client of $vendor_array[$product_id]) {
                console.log(client);
                $('#product-'+ $product_id).append('<img src="'+client.vendor_image+'" />');
            }
        }
    }
    jQuery(document).ready(function(){
        $('#cities-select').change(function($event){
            var city = $event.target.value;

            getData(city);
        })
    })
})(jQuery);
