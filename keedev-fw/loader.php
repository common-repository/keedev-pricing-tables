<?php

if ( !class_exists( 'KeeDev_Loader' ) ) {
    final class KeeDev_Loader {
        private static $_instance;

        /** @var array */
        private $_plugins = array();

        /** @var string */
        private $_version;

        /** @var string */
        private $_init;

        private $_free_to_deactivate = array();

        public static function get_instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_action( 'plugins_loaded', array( $this, 'load' ), 11 );
        }

        private function __clone() {

        }

        /**
         * load the keedev framework
         */
        public function load() {
            if ( !defined( 'KEEDEV' ) && $init = $this->get_init() ) {
                file_exists( $init ) && require_once( $init );
            }

            foreach ( $this->_free_to_deactivate as $free_to_deactivate ) {
                keedev_deactivate_plugin( $free_to_deactivate );
            }
        }

        /**
         * register a plugin
         *
         * @param $plugin_path
         */
        public function register_plugin( $plugin_path ) {
            $default_headers = array(
                'Name'       => 'Framework',
                'Version'    => 'Version',
                'Author'     => 'Author',
                'TextDomain' => 'Text Domain',
                'DomainPath' => 'Domain Path',
            );

            $current_data = get_file_data( trailingslashit( $plugin_path ) . 'keedev-fw/init.php', $default_headers );
            $init         = trailingslashit( $plugin_path ) . 'keedev-fw/init.php';

            // Save plugin information
            $this->_plugins[ $plugin_path ] = array(
                'framework-data' => $current_data
            );

            if ( !empty( $this->_version ) ) {
                if ( version_compare( $this->_version, $current_data[ 'Version' ], '<' ) ) {
                    $this->_version = $current_data[ 'Version' ];
                    $this->_init    = $init;
                }
            } else {
                $this->_version = $current_data[ 'Version' ];
                $this->_init    = $init;
            }
        }

        public function register_free_to_deactivate( $const ) {
            $this->_free_to_deactivate[] = $const;
        }

        public function get_version() {
            return $this->_version;
        }

        public function get_init() {
            return $this->_init;
        }
    }
}

if ( !function_exists( 'keedev_loader' ) ) {
    /**
     * @return KeeDev_Loader
     */
    function keedev_loader() {
        return KeeDev_Loader::get_instance();
    }
}

if ( !function_exists( 'keedev_register_plugin' ) ) {
    /**
     * @param string $plugin_path
     */
    function keedev_register_plugin( $plugin_path ) {
        keedev_loader()->register_plugin( $plugin_path );
    }
}

if ( !function_exists( 'keedev_register_free_to_deactivate' ) ) {
    /**
     * @param string $free_init_const
     */
    function keedev_register_free_to_deactivate( $free_init_const ) {
        keedev_loader()->register_free_to_deactivate( $free_init_const );
    }
}