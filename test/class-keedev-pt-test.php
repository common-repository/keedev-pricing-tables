<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Test' ) ) {
    class KeeDev_PT_Test {
        /** @var KeeDev_PT_Test */
        private static $_instance;

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_shortcode( 'keedev_pt_test_all_styles', array( $this, 'render_shortcode' ) );
        }

        public function render_shortcode( $atts ) {
            $id   = !empty( $atts[ 'id' ] ) ? $atts[ 'id' ] : false;
            $html = '';
            if ( !empty( $atts[ 'id' ] ) && $pricing_table = keedev_pt_get_pricing_table( $atts[ 'id' ] ) ) {

                foreach ( keedev_pt_get_pricing_table_styles() as $style => $label ) {
                    $html .= "<h3 style=\"text-align:center; text-transform:uppercase\">$label</h3>";
                    $html .= do_shortcode( "[keedev_pricing_table id=\"$id\" style=\"$style\"]" );
                }
            }

            return $html;
        }
    }

    KeeDev_PT_Test::instance();
}