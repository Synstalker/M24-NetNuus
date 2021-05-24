jQuery(document).ready( function($) {

    jQuery('input.open_graph_image').click(function(e) {

        e.preventDefault();
        var image_frame;
        var target_field = jQuery(this).attr("data-target");
        if(image_frame){
            image_frame.open();
        }
        // Define image_frame as wp.media object
        image_frame = wp.media({
            title: 'Select Media',
            multiple : false,
            library : {
                type : 'image',
            }
        });

        image_frame.on('close',function() {
            // On close, get selections and save to the hidden input
            // plus other AJAX stuff to refresh the image preview
            var selection =  image_frame.state().get('selection');

            attachment = selection.first().toJSON();

            jQuery( target_field ).val( attachment['url'] );
        });

        image_frame.on('open',function() {

        });

        image_frame.open();
    });

});