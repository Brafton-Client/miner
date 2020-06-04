(function(){
    
    $r = jQuery;
    $filtersForm = $r('#filters');
    $r('select.content-type').change(function(){
        $filtersForm.submit();
    });
    $r('select.product').change(function(){
        $filtersForm.submit();
    });
    $r('select.industry').change(function(){
        $filtersForm.submit();
    });
   $filtersForm.submit(function($e){
        
        console.log("hello");

        $r('select').each(function() {
            var inputElement = $r(this);

            inputElement.val() == "" ? inputElement.remove() : null;
        });
        console.log("done");
        // $r(this).trigger('submit');
        return;
        $e.preventDefault();
    });
})();