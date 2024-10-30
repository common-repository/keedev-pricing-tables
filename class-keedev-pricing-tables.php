<?php
/**
 * KeeDev Pricing Tables class
 *
 * @package KeeDev Pricing Tables
 * @author  KeeDev
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_Pricing_Tables' ) ) {
    class KeeDev_Pricing_Tables {
        /** @var KeeDev_Pricing_Tables|KeeDev_Pricing_Tables_Premium */
        private static $_instance;

        /** @var  KeeDev_PT_Admin */
        public $admin;

        /** @var  KeeDev_PT_Frontend */
        public $frontend;

        /** @var  KeeDev_PT_Icons */
        public $icons;

        public static function instance() {
            /** @var KeeDev_Pricing_Tables|KeeDev_Pricing_Tables_Premium $class */
            $class = class_exists( __CLASS__ . '_Premium' ) ? __CLASS__ . '_Premium' : __CLASS__;

            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new $class();
        }

        protected function __construct() {
            $this->includes();
            $this->init();
        }

        /**
         * clone is private for Singleton
         */
        private function __clone() {
        }

        /**
         * include required files
         */
        protected function includes() {
            require_once( 'includes/class-keedev-pt-admin.php' );
            require_once( 'includes/class-keedev-pt-frontend.php' );
            require_once( 'includes/class-keedev-pt-pricing-table-cpt-manager.php' );
            require_once( 'includes/class-keedev-pt-pricing-table.php' );
            require_once( 'includes/class-keedev-pt-pricing-table-list.php' );
            require_once( 'includes/class-keedev-pt-pricing-table-admin.php' );
            require_once( 'includes/presets/class-keedev-pt-presets.php' );

            require_once( 'includes/functions-keedev-pt.php' );

            // TEST
            if ( defined( 'KEEDEV_PT_TEST' ) && KEEDEV_PT_TEST ) {
                require_once( 'test/class-keedev-pt-test.php' );
            }
        }

        /**
         * Three, two, one, go!
         */
        protected function init() {
            $is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

            if ( is_admin() ) {
                $this->admin = KeeDev_PT_Admin::instance();
            }

            if ( !is_admin() || $is_ajax ) {
                $this->frontend = KeeDev_PT_Frontend::instance();
            }

            do_action( 'keedev_pricing_tables_loaded', $this );
        }
    }
}

if ( !function_exists( 'KeeDev_Pricing_Tables' ) ) {
    function KeeDev_Pricing_Tables() {
        return KeeDev_Pricing_Tables::instance();
    }
}