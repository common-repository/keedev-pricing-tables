jQuery( document ).ready( function ( $ ) {
    "use strict";

    var add_new = $( '#keedev-pt-add-new' ),
        wizard  = $( '#keedev-pt-wizard' );

    add_new.on( 'click', function ( e ) {
        e.preventDefault();
        wizard.slideToggle();
    } );
} );