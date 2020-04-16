function getData(city){
    jQuery.ajax({
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

    console.log($vendor_array);
    //loop through the array and populate the columsn with the images
    for(let $product_id in $vendor_array){
        var $this_products_vendors = $vendor_array[$product_id];
        console.log($this_products_vendors);
    }
}
jQuery(document).ready(function(){
    jQuery('#cities-select').change(function($event){
        var city = $event.target.value;

        getData(city);
    })
})
