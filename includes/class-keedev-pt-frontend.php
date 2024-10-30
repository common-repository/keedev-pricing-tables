<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Frontend' ) ) {
    class KeeDev_PT_Frontend {
        /** @var KeeDev_PT_Frontend */
        private static $_instance;

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_shortcode( 'keedev_pricing_table', array( $this, 'render_shortcode' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        }

        public function render_shortcode( $atts ) {
            $html = '';
            if ( !empty( $atts[ 'id' ] ) && $pricing_table = keedev_pt_get_pricing_table( $atts[ 'id' ] ) ) {
                wp_enqueue_style( 'keedev-pricing-tables-frontend' );

                $default_atts = array(
                    'style'         => '',
                    'hover_effect'  => '',
                    'active_style'  => '',
                    'column_margin' => ''
                );

                $args                    = wp_parse_args( $atts, $default_atts );
                $args[ 'pricing_table' ] = $pricing_table;

                ob_start();
                keedev_pt_get_template( 'pricing-table.php', $args );
                $html = ob_get_clean();
            }

            return $html;
        }

        public function enqueue_scripts() {
            wp_register_style( 'keedev-pt-montserrat', '//fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800', array(), KEEDEV_PT_VERSION );
            wp_register_style( 'keedev-pricing-tables-frontend', KEEDEV_PT_ASSETS_URL . '/css/frontend.css', array( 'keedev-pt-montserrat' ), KEEDEV_PT_VERSION );
        }
    }
}