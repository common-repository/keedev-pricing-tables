jQuery( document ).ready( function ( $ ) {
    "use strict";

    /**
     * Icons
     */
    $( '.keedev-icons__container' ).keedev_icons();


    /**
     * OnOff
     */
    $( '.keedev-onoff' ).on( 'click', function () {
        var $input = $( this ).find( 'input' ).first();

        if ( $input.val() === 'yes' ) {
            $input.val( 'no' ).trigger( 'change' );
            $( this ).addClass( 'disabled' ).trigger( 'change' );
        } else {
            $input.val( 'yes' ).trigger( 'change' );
            $( this ).removeClass( 'disabled' ).trigger( 'change' );
        }

    } );
} );