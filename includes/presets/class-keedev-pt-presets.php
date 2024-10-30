<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Presets' ) ) {
    class KeeDev_PT_Presets {
        /** @var KeeDev_PT_Presets */
        private static $_instance;

        private $_presets = array();

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            $this->_presets = keedev_pt_get_options( 'presets' );
        }

        public function get_presets() {
            return $this->_presets;
        }

        public function get_preset( $key ) {
            return array_key_exists( $key, $this->_presets ) ? $this->_presets[ $key ] : array();
        }

        public function get_table_settings_from_preset( $key ) {
            $preset = $this->get_preset( $key );
            $args   = array();
            if ( $preset && is_array( $preset ) && isset( $preset[ 'cells' ] ) ) {
                $cells         = $preset[ 'cells' ];
                $cell_settings = array_keys( KeeDev_PT_Pricing_Table_Admin::get_cell_settings() );
                $column_number = count( $cells );
                $row_number    = count( current( $cells ) );

                $args            = KeeDev_PT_Pricing_Table_Admin::get_default_args( $column_number, $row_number );
                $cells_for_table = array();
                for ( $r = 0; $r < $row_number; $r++ ) {
                    for ( $c = 0; $c < $column_number; $c++ ) {
                        $field = $cells[ $c ][ $r ];
                        foreach ( $cell_settings as $cell_setting ) {
                            $current_value                      = isset( $field[ $cell_setting ] ) ? $field[ $cell_setting ] : KeeDev_PT_Pricing_Table_Admin::get_default_cell_settings_value( $cell_setting );
                            $cells_for_table[ $cell_setting ][] = $current_value;

                        }
                    }
                }

                $args[ 'cells' ] = $cells_for_table;
            }

            return $args;
        }
    }
}