<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Admin' ) ) {
    class KeeDev_PT_Admin {
        /** @var KeeDev_PT_Admin */
        private static $_instance;

        /** @var KeeDev_PT_Presets */
        public $presets;

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            // register post types
            KeeDev_PT_Pricing_Table_CPT_Manager::instance();

            $this->presets = KeeDev_PT_Presets::instance();

            // create the settings page by using KeeDev Framework
            $this->create_settings();

            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        }

        /**
         * create the settings page by using KeeDev Framework
         */
        private function create_settings() {
            $keedev = KeeDev::instance();
            $tabs   = array(
                'pricing-table-list' => __( 'Pricing Tables', 'keedev-pricing-tables' ),
            );
            $tabs   = apply_filters( 'keedev_pt_panel_tabs', $tabs );

            $args = array(
                'page_title'    => _x( 'Pricing Tables', 'Plugin Name', 'keedev-pricing-tables' ),
                'menu_title'    => _x( 'Pricing Tables', 'Plugin Name', 'keedev-pricing-tables' ),
                'page'          => 'keedev-pricing-tables',
                'tabs'          => $tabs,
                'plugin-init'   => KEEDEV_PT_INIT,
                'plugin-url'    => KEEDEV_PT_DIR,
                'settings-path' => KEEDEV_PT_DIR . '/settings'
            );
            $keedev->settings->add_page( $args );

            // prints the Pricing Table tab
            add_action( 'keedev_pt_print_pricing_table_list', array( $this, 'print_pricing_table_list' ) );
        }

        /**
         * prints the Pricing Table tab
         */
        public function print_pricing_table_list() {
            require_once( KEEDEV_PT_VIEWS_PATH . '/admin/pricing-table-list.php' );
        }

        public function enqueue_scripts() {
            $screen = get_current_screen();

            wp_register_style( 'keedev-pt-admin', KEEDEV_PT_ASSETS_URL . '/css/admin.css', array( 'wp-color-picker' ), KEEDEV_PT_VERSION );
            wp_register_script( 'keedev-pt-dynamic-table', KEEDEV_PT_ASSETS_URL . '/js/dynamic-table.js', array( 'jquery' ), KEEDEV_PT_VERSION, true );
            wp_register_script( 'keedev-pt-pricing-table-admin', KEEDEV_PT_ASSETS_URL . '/js/pricing-table-admin.js', array( 'jquery', 'jquery-ui-sortable', 'keedev-pt-dynamic-table', 'wp-color-picker' ), KEEDEV_PT_VERSION, true );
            wp_register_script( 'keedev-pt-wizard', KEEDEV_PT_ASSETS_URL . '/js/wizard.js', array( 'jquery' ), KEEDEV_PT_VERSION, true );

            if ( KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table === $screen->id ) {
                wp_enqueue_style( 'keedev-fields' );
                wp_enqueue_script( 'keedev-fields' );

                wp_enqueue_script( 'keedev-pt-pricing-table-admin' );
            }

            if ( KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table === $screen->id || strpos( $screen->id, 'keedev-pricing-tables' ) !== false ) {
                wp_enqueue_style( 'keedev-utils' );
                wp_enqueue_script( 'keedev-utils' );

                wp_enqueue_style( 'keedev-pt-admin' );
            }

            if ( strpos( $screen->id, 'keedev-pricing-tables' ) !== false ) {
                wp_enqueue_script( 'keedev-pt-wizard' );
            }
        }
    }
}