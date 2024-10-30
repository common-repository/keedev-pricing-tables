jQuery( document ).ready( function ( $ ) {
    "use strict";

    var in_sync = false;

    /*----------------------------------------
     Show/Hide row and column settings
     ----------------------------------------*/
    var $table         = $( '#keedev-pt-pricing-table-admin' ),
        $show_settings = $( '#keedev-pt-pricing-table-admin-show-settings' );

    $show_settings.on( 'click', function () {
        //$table.find( '.keedev-pt-pricing-table-admin-row-settings-column' ).toggle();
        $table.find( '.keedev-pt-pricing-table-admin-column-settings' ).toggle();
    } );

    /*----------------------------------------
     Highlight
     ----------------------------------------*/
    var highlight = {
        class: 'keedev-pt-pricing-table-admin-highlight',
        delay: 500,
        init : function ( target ) {
            target.addClass( highlight.class )
                .delay( highlight.delay ).queue( function () {
                $( this ).removeClass( highlight.class ).dequeue();
            } );
        }
    };

    /*----------------------------------------
     init Color Picker in table
     ----------------------------------------*/
    var colorPickerHandler = '.keedev-pt-pricing-table-admin-field-color',
        colorPickerOptions = {
            onInit: function () {
            },
            change: function ( event, ui ) {
            },
            clear : function () {
                var input = $( this );
                input.val( input.data( 'default-color' ) );
                input.change();
            }
        };

    $table.find( colorPickerHandler ).wpColorPicker( colorPickerOptions );

    /*----------------------------------------
     Dynamic Table init
     ----------------------------------------*/
    var dynamic_table_options = {
        addRow_selector      : '.keedev-pt-pricing-table-admin-row-action-add',
        deleteRow_selector   : '.keedev-pt-pricing-table-admin-row-action-delete',
        addColumn_selector   : '.keedev-pt-pricing-table-admin-column-action-add',
        deleteColumn_selector: '.keedev-pt-pricing-table-admin-column-action-delete',
        minColumnNumber      : 4,
        onElementAdded_custom: function ( target ) {
            target.find( colorPickerHandler ).wpColorPicker( colorPickerOptions );
            highlight.init( target );
        },
        onColumnCellAdded    : this.onElementAdded_custom,
        onRowAdded           : this.onElementAdded_custom
    };

    $table.keedev_dynamic_table( dynamic_table_options );

    $table.sortable( {
                         items               : '> tbody > tr',
                         cursor              : 'move',
                         handle              : '.keedev-pt-pricing-table-admin-anchor',
                         scrollSensitivity   : 40,
                         forcePlaceholderSize: true,
                         axis                : 'y'
                     } );

    /* set class based on Type field to control visibility of the other fields through css */
    $table.on( 'change', 'select.keedev-pt-pricing-table-admin-field-type', function ( event ) {
        var $target        = $( event.target ),
            type           = $target.val(),
            $cell_settings = $target.closest( '.keedev-pt-pricing-table-admin-cell-settings' ).first(),
            field_classes  = ( $cell_settings.attr( 'class' ).match( /\bkeedev-pt-pricing-table-admin-type-\S+/g ) || [] ).join( ' ' );

        $cell_settings.removeClass( field_classes );
        $cell_settings.addClass( 'keedev-pt-pricing-table-admin-type-' + type );

        // Sync row
        if ( !in_sync && $( '#keedev-pt-settings-sync-row-types' ).val() === 'yes' ) {
            in_sync = true;
            $target.closest( 'tr' ).find( 'select.keedev-pt-pricing-table-admin-field-type' ).val( type ).trigger( 'change' );
            in_sync = false;
        }
    } );


    /*----------------------------------------
     Show/Hide Badge fields
     ----------------------------------------*/
    $( '.keedev-pt-pricing-table-admin-table-field-settings--badge' )
        .on( 'change', function () {
            var settings_container     = $( this ).closest( '.keedev-pt-pricing-table-admin-column-settings' ),
                badge_fields           = settings_container.find( '.keedev-pt-show-if-badge' ),
                badge_field_containers = badge_fields.closest( '.keedev-pt-pricing-table-admin-field__container' );
            if ( $( this ).val() !== '' ) {
                badge_field_containers.show();
            } else {
                badge_field_containers.hide();
            }
        } )
        .trigger( 'change' );

    /*----------------------------------------
     Distraction Free
     ----------------------------------------*/
    var $body = $( document.body );
    $( '.keedev-pt-distraction-free-toggle input' ).on( 'change', function () {
        if ( $( this ).val() === 'yes' ) {
            $body
                .removeClass( 'keedev-pt-distraction-free-off' )
                .addClass( 'keedev-pt-distraction-free-on' );
        } else {
            $body
                .removeClass( 'keedev-pt-distraction-free-on' )
                .addClass( 'keedev-pt-distraction-free-off' );
        }
    } );

    /*----------------------------------------
     Style Selector
     ----------------------------------------*/
    var $style_selector                       = $( '#keedev-pt-settings-style-selector' ),
        $style_selector_value                 = $style_selector.find( '.keedev-pt-settings-style-selector__value' ),
        $style_selector_label_container       = $style_selector.find( '.keedev-pt-settings-style-selector__label-container' ),
        $style_selector_label_container_arrow = $style_selector.find( '.dashicons' ),
        $style_selector_label                 = $style_selector.find( '.keedev-pt-settings-style-selector__label' ),
        $style_selector_options               = $style_selector.find( '.keedev-pt-settings-style-selector__options' ),
        $style_selector_items                 = $style_selector_options.find( '.keedev-pt-settings-style-selector__item' );

    $style_selector_label_container.on( 'click', function () {
        $style_selector_options.slideToggle();
        $style_selector_label_container_arrow.toggleClass( 'dashicons-arrow-down' );
        $style_selector_label_container_arrow.toggleClass( 'dashicons-arrow-up' );
    } );

    $style_selector_items.on( 'click', function () {
        $style_selector_items.removeClass( 'active' );
        $style_selector_value.val( $( this ).data( 'value' ) );
        $style_selector_label.html( $( this ).data( 'label' ) );
        $( this ).addClass( 'active' );
    } );
} );
