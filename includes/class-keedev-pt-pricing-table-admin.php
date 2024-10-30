<?php
/**
 * Pricing Table Admin Object
 * used to print/manage the table list shown in the Pricing Table metabox
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Pricing_Table_Admin' ) ) {
    class KeeDev_PT_Pricing_Table_Admin {

        public $col_settings;
        public $row_settings;
        public $col_number;
        public $row_number;
        public $cells;

        public function __construct( $args = array() ) {
            $validate_results = self::validate_args( $args );
            if ( !$validate_results )
                $validate_results = self::validate_args( self::get_default_args() );

            if ( $validate_results ) {
                $this->col_settings = $validate_results[ 'col_settings' ];
                $this->row_settings = $validate_results[ 'row_settings' ];
                $this->col_number   = $validate_results[ 'col_number' ];
                $this->row_number   = $validate_results[ 'row_number' ];
                $this->cells        = $validate_results[ 'cells' ];
            }
        }

        public static function get_default_args( $columns = 3, $rows = 1 ) {
            $required_col_settings  = array_keys( self::get_column_settings() );
            $required_row_settings  = array_keys( self::get_row_settings() );
            $required_cell_settings = array_keys( self::get_cell_settings() );
            $column_settings        = array();
            $row_settings           = array();
            $cells                  = array();
            foreach ( $required_col_settings as $key ) {
                $default_value = self::get_default_column_settings_value( $key );
                for ( $i = 0; $i < $columns; $i++ ) {
                    $column_settings[ $key ][] = $default_value;
                }
            }
            foreach ( $required_row_settings as $key ) {
                $default_value = self::get_default_row_settings_value( $key );
                for ( $i = 0; $i < $rows; $i++ ) {
                    $row_settings[ $key ][] = $default_value;
                }
            }
            foreach ( $required_cell_settings as $key ) {
                $default_value = self::get_default_cell_settings_value( $key );
                for ( $i = 0; $i < $columns; $i++ ) {
                    $cells[ $key ][] = $default_value;
                }
            }

            return array(
                'column_settings' => $column_settings,
                'row_settings'    => $row_settings,
                'cells'           => $cells,
            );
        }

        public function display() {
            echo "<div id='keedev-pt-pricing-table-admin__wrapper'>";
            echo "<table id='keedev-pt-pricing-table-admin' class='widefat fixed striped'>";
            $this->print_header();
            $this->print_rows();
            echo '</table>';
            echo '</div>';
        }

        public function is_valid() {
            return !empty( $this->col_settings ) && !empty( $this->row_settings ) && !empty( $this->col_number ) && !empty( $this->row_number ) && !empty( $this->cells );
        }

        public function print_field( $field = array(), $key = '' ) {
            if ( !empty( $field[ 'type' ] ) ) {

                echo "<div class='keedev-pt-pricing-table-admin-field__container keedev-pt-pricing-table-admin-field-{$key}__container'>";
                if ( !empty( $field[ 'label' ] ) )
                    echo "<label>" . $field[ 'label' ] . "</label>";

                keedev_get_field( $field, true, false );

                echo '</div>';

            }
        }

        public function print_header() {
            ?>
            <thead>
            <th class='keedev-pt-pricing-table-admin-anchor-column'>
                <span id="keedev-pt-pricing-table-admin-show-settings" class="dashicons dashicons-admin-generic"></span>
            </th>
            <th class='keedev-pt-pricing-table-admin-row-settings-column'></th>
            <?php
            for ( $i = 0; $i < $this->col_number; $i++ ) {
                echo "<th class='keedev-pt-pricing-table-admin-column'>";
                echo "<div class='keedev-pt-pricing-table-admin-table-field-settings keedev-pt-pricing-table-admin-column-settings'>";
                foreach ( self::get_column_settings() as $key => $field ) {
                    $field[ 'value' ] = isset( $this->col_settings[ $key ][ $i ] ) ? $this->col_settings[ $key ][ $i ] : self::get_default_column_settings_value( $key );
                    $this->print_field( $field, $key );
                }
                echo "</div>";

                echo "<div class='keedev-pt-pricing-table-admin-column-actions'>";
                echo "<span class='keedev-pt-pricing-table-admin-column-action-add dashicons dashicons-plus-alt'></span>";
                echo "<span class='keedev-pt-pricing-table-admin-column-action-delete dashicons dashicons-dismiss'></span>";
                echo "</div>";
                echo "</th>";
            }
            ?>
            <th class='keedev-pt-pricing-table-admin-row-action-column'></th>
            </thead>
            <?php
        }

        public function print_rows() {
            ?>
            <tbody>
            <?php
            for ( $i = 0; $i < $this->row_number; $i++ ) {
                echo "<tr class='keedev-pt-pricing-table-admin-row'>";

                echo "<td class='keedev-pt-pricing-table-admin-anchor-column keedev-pt-pricing-table-admin-anchor'><span class='dashicons dashicons-menu'></span></td>";

                echo "<td class='keedev-pt-pricing-table-admin-row-settings-column'>";
                echo "<div class='keedev-pt-pricing-table-admin-table-field-settings keedev-pt-pricing-table-admin-row-settings'>";
                foreach ( self::get_row_settings() as $key => $field ) {
                    $field[ 'value' ] = isset( $this->row_settings[ $key ][ $i ] ) ? $this->row_settings[ $key ][ $i ] : self::get_default_row_settings_value( $key );
                    $this->print_field( $field, $key );
                }
                echo '</div>';
                echo "</td>";

                for ( $j = 0; $j < $this->col_number; $j++ ) {
                    $cell_index = $j + ( $i * $this->col_number );
                    $type       = isset( $this->cells[ 'type' ][ $cell_index ] ) ? $this->cells[ 'type' ][ $cell_index ] : 'text';
                    $type_class = 'keedev-pt-pricing-table-admin-type-' . $type;
                    echo "<td class='keedev-pt-pricing-table-admin-column'>";
                    echo "<div class='keedev-pt-pricing-table-admin-table-field-settings keedev-pt-pricing-table-admin-cell-settings $type_class'>";
                    foreach ( self::get_cell_settings() as $key => $field ) {
                        $field[ 'value' ] = isset( $this->cells[ $key ][ $cell_index ] ) ? $this->cells[ $key ][ $cell_index ] : self::get_default_cell_settings_value( $key );
                        $this->print_field( $field, $key );
                    }
                    echo "</div>";
                    echo "</td>";
                }

                echo "<td class='keedev-pt-pricing-table-admin-row-action-column'>";
                echo "<span class='keedev-pt-pricing-table-admin-row-action-add dashicons dashicons-plus-alt'></span>";
                echo "<span class='keedev-pt-pricing-table-admin-row-action-delete dashicons dashicons-dismiss'></span>";
                echo "</td>";

                echo "</tr>";
            }
            ?>
            </tbody>
            <?php
        }

        public static function validate_args( $args = array() ) {
            if ( !empty( $args[ 'column_settings' ] ) && !empty( $args[ 'row_settings' ] ) && !empty( $args[ 'cells' ] ) ) {
                $col_settings = $args[ 'column_settings' ];
                $row_settings = $args[ 'row_settings' ];
                $cells        = $args[ 'cells' ];
                $col_number   = count( current( $col_settings ) );
                $row_number   = count( current( $row_settings ) );

                return compact( 'col_settings', 'row_settings', 'col_number', 'row_number', 'cells' );
            }

            return false;
        }

        public static function get_column_settings() {
            return keedev_pt_get_options( 'pricing-table-column-settings' );
        }

        public static function get_row_settings() {
            return keedev_pt_get_options( 'pricing-table-row-settings' );
        }

        public static function get_cell_settings() {
            return keedev_pt_get_options( 'pricing-table-cell-settings' );
        }

        public static function get_default_cell_settings_value( $key ) {
            $settings = self::get_cell_settings();

            return isset( $settings[ $key ][ 'default' ] ) ? $settings[ $key ][ 'default' ] : '';
        }

        public static function get_default_row_settings_value( $key ) {
            $settings = self::get_row_settings();

            return isset( $settings[ $key ][ 'default' ] ) ? $settings[ $key ][ 'default' ] : '';
        }

        public static function get_default_column_settings_value( $key ) {
            $settings = self::get_column_settings();

            return isset( $settings[ $key ][ 'default' ] ) ? $settings[ $key ][ 'default' ] : '';
        }

    }
}