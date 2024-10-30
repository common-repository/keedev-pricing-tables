<?php
if ( !class_exists( 'KeeDev_PT_Premium_Info' ) ) {
    class KeeDev_PT_Premium_Info {
        private static $_instance;

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();;
        }

        private function __construct() {
            add_filter( 'keedev_pt_panel_tabs', array( $this, 'add_premium_tab' ) );
            add_action( 'keedev_pt_print_premium_tab', array( $this, 'print_premium_tab' ) );

            add_action( 'keedev_pt_print_pricing_table_list', array( $this, 'print_premium_info_box' ), 9 );
        }

        public function add_premium_tab( $tabs ) {
            $tabs[ 'premium' ] = __( 'Premium', 'keedev-pricing-tables' );

            return $tabs;
        }

        public function print_premium_tab() {
            include( 'premium-landing.php' );
        }

        public function print_premium_info_box() {
            include( 'premium-info-box.php' );
        }
    }

    //KeeDev_PT_Premium_Info::instance();
}