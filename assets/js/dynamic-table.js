jQuery( document ).ready( function ( $ ) {
    "use strict";
    $.fn.keedev_dynamic_table = function ( options ) {
        var self             = this,
            _getRowNumber    = function () {
                return $( self ).find( '> tbody > tr' ).length;
            },
            _getColumnNumber = function () {
                return $( self ).find( '> tbody > tr:first-child > td' ).length;
            },
            _updateSelect    = function () {
                var currentSelect = $( this ),
                    value         = currentSelect.val();

                currentSelect.find( 'option' ).removeAttr( "selected" ).filter( function () {
                    return $( this ).attr( "value" ) == value;
                } ).first().attr( "selected", "selected" );
            },
            defaults         = {
                addRow_selector      : '.keedev-dynamic-table__add-row',
                deleteRow_selector   : '.keedev-dynamic-table__delete-row',
                addColumn_selector   : '.keedev-dynamic-table__add-column',
                deleteColumn_selector: '.keedev-dynamic-table__delete-column',
                minRowNumber         : 1,
                minColumnNumber      : 1,
                onRowAdded           : function ( row ) {
                },
                onColumnAdded        : function ( index ) {
                },
                onColumnCellAdded    : function ( cell ) {
                },
                addRow               : function () {
                    var target     = $( this ),
                        currentRow = target.closest( 'tr' ),
                        newRow     = currentRow.clone();
                    currentRow.after( newRow );

                    options.onRowAdded.call( options, newRow );
                },
                deleteRow            : function () {
                    if ( _getRowNumber() > options.minRowNumber ) {
                        var target     = $( this ),
                            currentRow = target.closest( 'tr' );
                        currentRow.remove();
                    }
                },
                addColumn            : function () {
                    var target      = $( this ),
                        currentCell = target.closest( 'th' ),
                        index       = currentCell.index() + 1;

                    if ( index ) {
                        var th    = $( self ).find( '> thead > tr > th:nth-child(' + index + ')' ),
                            tds   = $( self ).find( '> tbody > tr > td:nth-child(' + index + ')' ),
                            thNew = th.clone();

                        th.after( thNew );
                        options.onColumnCellAdded.call( options, thNew );

                        tds.each( function () {
                            var tdNew = $( this ).clone();
                            $( this ).after( tdNew );

                            options.onColumnCellAdded.call( options, tdNew );
                        } );
                        options.onColumnAdded.call( options, index );
                    }
                },
                deleteColumn         : function () {
                    if ( _getColumnNumber() > options.minColumnNumber ) {
                        var target      = $( this ),
                            currentCell = target.closest( 'th' ),
                            index       = currentCell.index() + 1;

                        if ( index ) {
                            var th  = $( self ).find( '> thead > tr > th:nth-child(' + index + ')' ),
                                tds = $( self ).find( '> tbody > tr > td:nth-child(' + index + ')' );

                            th.remove();
                            tds.remove();
                        }
                    }
                }
            };
        options              = $.extend( defaults, options );

        return $( this ).each( function () {
            var $table = $( this );

            $table.on( 'click', options.addRow_selector, options.addRow );
            $table.on( 'click', options.deleteRow_selector, options.deleteRow );
            $table.on( 'click', options.addColumn_selector, options.addColumn );
            $table.on( 'click', options.deleteColumn_selector, options.deleteColumn );

            // fix cloning issue with select fields by updating the selected option on change event
            $table.on( 'change', 'select', _updateSelect );
        } );
    };
} );