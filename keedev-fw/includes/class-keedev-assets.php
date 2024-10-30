<?php
/**
 * This file belongs to the KeeDev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_Assets' ) ) {
    class KeeDev_Assets {
        private static $_instance;

        /** @return KeeDev_Assets */
        public static function instance() {
            return isset( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        }

        public function enqueue_scripts() {
            wp_register_style( 'keedev-globals', KEEDEV_ASSETS_URL . '/css/keedev-globals.css', array(), KEEDEV_VERSION );
            wp_register_style( 'keedev-fields', KEEDEV_ASSETS_URL . '/css/keedev-fields.css', array( 'keedev-globals' ), KEEDEV_VERSION );
            wp_register_style( 'keedev-utils', KEEDEV_ASSETS_URL . '/css/keedev-utils.css', array( 'dashicons' ), KEEDEV_VERSION );

            wp_register_script( 'keedev-icons', KEEDEV_ASSETS_URL . '/js/keedev-icons.js', array( 'jquery' ), KEEDEV_VERSION );
            wp_register_script( 'keedev-fields', KEEDEV_ASSETS_URL . '/js/keedev-fields.js', array( 'jquery', 'keedev-icons' ), KEEDEV_VERSION );
            wp_register_script( 'keedev-utils', KEEDEV_ASSETS_URL . '/js/keedev-utils.js', array( 'jquery' ), KEEDEV_VERSION );
        }

    }
}