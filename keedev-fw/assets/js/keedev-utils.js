jQuery( document ).ready( function ( $ ) {
    "use strict";

    /**
     * Copy to clipboard
     */
    $( document ).on( 'click', '.keedev-copy-to-clipboard', function () {
        var self           = $( this ),
            target = self.data( 'target' ),
            target_obj      = $( target );

        if ( target_obj.length > 0 ) {
            var temp = $( "<input>" );
            $( 'body' ).append( temp );

            temp.val( target_obj.html() ).select();
            document.execCommand( "copy" );

            temp.remove();
        }
    } );


} );