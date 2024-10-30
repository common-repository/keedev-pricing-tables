jQuery( document ).ready( function ( $ ) {
    "use strict";


    $.fn.keedev_icons = function () {
        return $( this ).each( function () {
            var container = $( this ),
                dom       = {
                    container    : '.keedev-icons__container',
                    dataContainer: '.keedev-icons-data__container',
                    preview      : '.keedev-icons-data-preview',
                    text         : '.keedev-icons-data-text',
                    selector     : '.keedev-icons-selector',
                    list         : '.keedev-icons-list',
                    element      : '.keedev-icons-list li',
                    setDefault   : '.keedev-icons-action-set-default'
                };

            var preview = container.find( dom.preview ).first(),
                text    = container.find( dom.text ),
                close   = function () {
                    container.find( dom.selector ).hide();
                };

            container.on( 'click', dom.element, function ( event ) {
                         var target = $( event.target ).closest( 'li' ),
                             font   = target.data( 'font' ),
                             icon   = target.data( 'icon' ),
                             key    = target.data( 'key' ),
                             name   = target.data( 'name' );

                         preview.attr( 'data-font', font );
                         preview.attr( 'data-icon', icon );
                         preview.attr( 'data-key', key );
                         preview.attr( 'data-name', name );

                         text.val( font.replace( 'keedev-', '' ) + ':' + name );

                         container.find( dom.element ).removeClass( 'active' );
                         target.addClass( 'active' );
                         close();
                     } )

                     .on( 'click', dom.dataContainer, function () {
                         container.find( dom.selector ).toggle();
                     } )

                     .on( 'click', dom.setDefault, function () {
                         container.find( dom.element + '.default' ).trigger( 'click' );
                     } );
        } );
    };


} );