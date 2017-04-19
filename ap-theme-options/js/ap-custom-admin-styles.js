jQuery( document ).ready( function( $ ) {
    var current_field_id,
        image_uploader;

    // Upload button click.
    $( ".btn-upload-img" ).click( function( event ) {
        event.preventDefault();

        // Get the id of the corresponding field.
        current_field_id = $( this ).data( "field-id" );

        // If the uploader object already exists, reopen it.
        if ( image_uploader ) {
            image_uploader.open();

            return;
        }
 
        // Create an uploader by extending the wp.media object.
        image_uploader = wp.media.frames.file_frame = wp.media( {
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        } );
 
        // Open the uploader.
        image_uploader.open();    

        // After the file is selected, get the URL and set it as the hidden field's value.
        image_uploader.on( 'select', function() {
            attachment = image_uploader.state().get( 'selection' ).first().toJSON();
            $( "#" + current_field_id + "-upload-field" ).val( attachment.url );

            // Show the image thumbnail and the remove button.
            $( "#" + current_field_id + "-thumbnail" ).attr( 'src', attachment.url ).removeClass( "hide" );
            $( "#" + current_field_id + "-remove-button" ).removeClass( "hide" );            
        } );
     } );

     // Remove image button click.
     $( ".btn-remove-img" ).click( function( event ) {
        event.preventDefault();

        // Get the id of the corresponding upload field.
        current_field_id = $( this ).data( "field-id" );

        // Remove the field value.
        $( "#" + current_field_id + "-upload-field" ).val( "" );

        // Hide the current image.
        $( "#" + current_field_id + "-thumbnail").addClass( "hide" );

        $( this ).addClass( "hide" );
     } );
} );