<?php
/**
 * This file belongs to the keedev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_Settings' ) ) {
    class KeeDev_Settings {
        /** @var  KeeDev_Settings */
        private static $_instance;

        const MENU_SLUG = 'keedev_settings';

        /** @var array */
        private $_pages = array();

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_action( 'admin_menu', array( $this, 'add_keedev_menu_page' ) );

            add_action( 'admin_menu', array( $this, 'add_setting_pages' ) );

            add_action( 'admin_init', array( $this, 'register_settings' ) );
            add_action( 'admin_init', array( $this, 'add_fields' ) );
        }

        public function add_fields() {
            if ( $settings_data = $this->get_current_settings_data() ) {
                extract( $settings_data );
                /**
                 * @var $page_id
                 * @var $page_data
                 * @var $tabs
                 * @var $tab_id
                 * @var $tab_title
                 * @var $tab_options
                 */
                if ( !$tab_id )
                    return;

                // TODO: prelevare il valore dell'opzione corrente

                $sections = isset( $tab_options[ 'sections' ] ) ? $tab_options[ 'sections' ] : array();
                foreach ( $sections as $section => $data ) {
                    $section_title = !empty( $data[ 'title' ] ) ? $data[ 'title' ] : '';
                    $fields        = !empty( $data[ 'fields' ] ) ? $data[ 'fields' ] : array();
                    add_settings_section( "keedev_settings_{$tab_id}_{$section}", $section_title, array(), 'keedev' );

                    foreach ( $fields as $field ) {
                        if ( isset( $field[ 'id' ] ) && isset( $field[ 'type' ] ) && isset( $field[ 'name' ] ) ) {
                            add_settings_field( "keedev_setting_" . $field[ 'id' ], $field[ 'name' ], array( $this, 'print_field' ), 'keedev', "keedev_settings_{$tab_id}_{$section}", $field );
                        }
                    }
                }
            }
        }


        /**
         * add the KeeDev menu page
         */
        public function add_keedev_menu_page() {
            if ( !$this->get_pages() )
                return;

            global $admin_page_hooks;

            if ( !isset( $admin_page_hooks[ self::MENU_SLUG ] ) ) {
                $position        = apply_filters( 'keedev_menu_item_position', '60.5' );
                $capability      = apply_filters( 'keedev_menu_page_capability', 'manage_options' );
                $icon_base64_url = $this->get_base64_icon_url();

                add_menu_page( 'KeeDev', 'KeeDev', $capability, self::MENU_SLUG, null, $icon_base64_url, $position );
            }
        }

        /**
         * get the base64 url of the KeeDev menu icon
         * 
         * @return string
         */
        public function get_base64_icon_url() {
            $icon_path = KEEDEV_ASSETS_PATH . '/images/keedev-menu-icon.svg';
            if ( !file_exists( $icon_path ) ) {
                return '';
            }

            ob_start();
            include( $icon_path );
            $icon            = ob_get_clean();
            $icon_base64_url = 'data:image/svg+xml;base64,' . base64_encode( $icon );

            return $icon_base64_url;
        }

        /**
         * @param array $data array of page data
         */
        public function add_page( $data ) {
            $default_data = array(
                'page'        => '', // REQUIRED
                'page_title'  => __( 'Plugin Settings', 'keedev' ),
                'menu_title'  => __( 'Settings', 'keedev' ),
                'capability'  => 'manage_options',
                'icon_url'    => '',
                'position'    => null,
                'parent'      => '',
                'parent_page' => self::MENU_SLUG,
            );
            $data         = wp_parse_args( $data, $default_data );

            if ( !empty( $data[ 'page' ] ) ) {
                $this->_pages[ $data[ 'page' ] ] = $data;
            }

        }

        /**
         * add the settings pages under KeeDev menu
         */
        public function add_setting_pages() {
            if ( !$this->get_pages() )
                return;

            foreach ( $this->get_pages() as $page_id => $page_data ) {
                $parent = $page_data[ 'parent_page' ];

                if ( !empty( $parent ) ) {
                    add_submenu_page( $parent, $page_data[ 'page_title' ], $page_data[ 'menu_title' ], $page_data[ 'capability' ], $page_id, array( $this, 'print_settings_page' ) );
                } else {
                    add_menu_page( $page_data[ 'page_title' ], $page_data[ 'menu_title' ], $page_data[ 'capability' ], $page_id, array( $this, 'print_settings_page' ), $page_data[ 'icon_url' ], $page_data[ 'position' ] );
                }
            }

            // remove the KeeDev submenu
            remove_submenu_page( self::MENU_SLUG, self::MENU_SLUG );

            do_action( 'keedev_settings_page_added' );
        }

        /**
         * get the registered pages
         *
         * @return array
         */
        public function get_pages() {
            return $this->_pages;
        }

        /**
         *  return the current settings page
         *
         * @return bool|string
         */
        public function get_current_page_id() {
            $page_ids = array_keys( $this->get_pages() );
            if ( isset( $_GET[ 'page' ] ) && in_array( $_GET[ 'page' ], $page_ids ) )
                return $_GET[ 'page' ];

            return false;
        }

        /**
         * return an array for the current page id and data
         *
         * @return array|bool
         */
        public function get_current_settings_data() {
            if ( $page_id = $this->get_current_page_id() ) {
                $page_data = $this->get_page_data( $page_id );
                $tabs      = isset( $page_data[ 'tabs' ] ) ? $page_data[ 'tabs' ] : array();

                if ( isset( $_GET[ 'tab' ] ) && isset( $tabs[ $_GET[ 'tab' ] ] ) ) {
                    $tab_id    = $_GET[ 'tab' ];
                    $tab_title = $tabs[ $tab_id ];
                } elseif ( !!$tabs ) {
                    $tab_id    = current( array_keys( $tabs ) );
                    $tab_title = current( $tabs );
                } else {
                    $tab_id    = false;
                    $tab_title = __( 'General', 'keedev' );
                }

                if ( isset( $page_data[ 'settings-path' ] ) ) {
                    $options_file_path = trailingslashit( $page_data[ 'settings-path' ] ) . $tab_id . '.php';
                    if ( file_exists( $options_file_path ) )
                        $tab_options = include( $options_file_path );
                    else {
                        $tab_options = array();
                    }
                }

                return compact( 'page_id', 'page_data', 'tabs', 'tab_id', 'tab_title', 'tab_options' );
            }

            return false;
        }

        public function get_default_options() {
            // TODO: da fare
            return array();
        }

        public function get_options() {
            // TODO: da sistemare, ogni volta che viene chiamato fa un get options
            if ( $page_id = $this->get_current_page_id() ) {
                $options = get_option( 'keedev_' . $page_id . '_options' );
                if ( $options !== false )
                    return $options;
            }

            return $this->get_default_options();
        }

        /**
         * get page data
         *
         * @param $page_id
         *
         * @return array|mixed
         */
        public function get_page_data( $page_id ) {
            $pages = $this->get_pages();

            return isset( $pages[ $page_id ] ) ? $pages[ $page_id ] : array();
        }

        /**
         * prints the field
         *
         * @param $field
         */
        function print_field( $field ) {
            if ( !empty( $field ) ) {
                keedev_get_field( $field, true );
            }
        }

        /**
         * print the current settings page
         */
        public function print_settings_page() {
            if ( $settings_data = $this->get_current_settings_data() ) {
                extract( $settings_data );
                /**
                 * @var $page_id
                 * @var $page_data
                 * @var $tabs
                 * @var $tab_id
                 * @var $tab_title
                 * @var $tab_options
                 */

                $type = isset( $tab_options[ 'type' ] ) ? $tab_options[ 'type' ] : 'settings';

                echo "<div id='keedev-settings-wrap'>";
                // Navigation
                echo "<h2 class='nav-tab-wrapper'>";
                foreach ( $tabs as $id => $title ) {
                    $active = $tab_id == $id ? 'nav-tab-active' : '';
                    echo "<a class='nav-tab $active' href='?page=$page_id&tab=$id'>$title</a>";
                }
                echo "</h2>";

                echo "<div id='wrap' class='keedev-settings-container'>";

                if ( 'custom' === $type && !empty( $tab_options[ 'action' ] ) ) {
                    do_action( $tab_options[ 'action' ], $settings_data );
                } else {
                    ?>
                    <form id="keedev-settings-form" method="post" action="options.php">
                        <?php do_settings_sections( 'keedev' ); ?>
                        <p>&nbsp;</p>
                        <?php settings_fields( 'keedev_' . $page_id . '_options' ); ?>
                        <input type="hidden" name="<?php echo "keedev_{$page_id}_options[$tab_id]" ?>" value="<?php echo esc_attr( $tab_id ) ?>"/>
                        <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>"/>
                    </form>
                    <?php
                }

                echo '</div><!-- .keedev-settings-container -->';

                echo '</div><!-- #keedev-settings-wrap -->';
            }
        }

        /**
         * register settings for pages
         */
        public function register_settings() {
            if ( !$this->get_pages() )
                return;

            foreach ( $this->get_pages() as $page_id => $page_data ) {
                $page_id = $page_data[ 'page' ];
                register_setting( 'keedev_' . $page_id . '_options', 'keedev_' . $page_id . '_options' );
            }
        }
    }
}