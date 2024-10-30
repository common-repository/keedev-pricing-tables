<?php
/**
 * This file belongs to the KeeDev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev' ) ) {
    final class KeeDev {
        /** @var  KeeDev */
        private static $_instance;

        /** @var KeeDev_Settings */
        public $settings;

        /** @var KeeDev_Icons */
        public $icons;

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            $this->settings = KeeDev_Settings::instance();
            $this->icons    = KeeDev_Icons::instance();

            KeeDev_Assets::instance();

            do_action( 'keedev_loaded' );
        }

    }
}

if (!function_exists('KeeDev')){
    function KeeDev(){
        return KeeDev::instance();
    }
}