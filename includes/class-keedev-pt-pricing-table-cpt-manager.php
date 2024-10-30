<?php
/**
 * Manages the Pricing Table CPT
 * see KeeDev_PT_Pricing_Table_List (prints the list)
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Pricing_Table_CPT_Manager' ) ) {
    class KeeDev_PT_Pricing_Table_CPT_Manager {
        /** @var KeeDev_PT_Pricing_Table_CPT_Manager */
        private static $_instance;

        public static $pricing_table = 'kee_pricing_table';

        public static function instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        private function __construct() {
            add_action( 'init', array( $this, 'register_post_types' ) );

            add_filter( 'manage_' . self::$pricing_table . '_posts_columns', array( $this, 'manage_posts_columns' ) );
            add_action( 'manage_' . self::$pricing_table . '_posts_custom_column', array( $this, 'render_posts_custom_column' ), 10, 2 );

            add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
            add_action( 'save_post', array( $this, 'save_metabox' ) );

            add_action( 'admin_action_duplicate_pricing_table', array( $this, 'duplicate_pricing_table' ) );
            add_filter( 'post_row_actions', array( $this, 'add_duplicate_action' ), 10, 2 );
        }

        /**
         * Manage columns
         *
         * @access public
         * @since  1.0.0
         */
        public function manage_posts_columns( $columns ) {
            $date_text = $columns[ 'date' ];
            unset( $columns[ 'date' ] );

            $columns[ 'shortcode' ] = __( 'Shortcode', 'keedev-pricing-tables' );
            $columns[ 'date' ]      = $date_text;

            return $columns;
        }

        /**
         * Render columns
         *
         * @access public
         * @since  1.0.0
         *
         * @param $column
         * @param $post_id
         */
        public function render_posts_custom_column( $column, $post_id ) {
            echo "<code id='keedev-pt-shortcode__container'>[keedev_pricing_table id={$post_id}]</code>";
            echo "<span class='keedev-copy-to-clipboard' data-target='#keedev-pt-shortcode__container'></span>";
        }

        /**
         * register metabox
         */
        public function register_metabox() {
            add_meta_box( 'keedev-pt-settings-metabox',
                          __( 'Settings', 'keedev-pricing-tables' ),
                          array( $this, 'render_settings_metabox' ),
                          self::$pricing_table,
                          'normal',
                          'high' );

            add_meta_box( 'keedev-pt-table-metabox',
                          __( 'Pricing Table', 'keedev-pricing-tables' ),
                          array( $this, 'render_table_metabox' ),
                          self::$pricing_table,
                          'normal',
                          'high' );

            add_meta_box( 'keedev-pt-shortcode-metabox',
                          __( 'Shortcode', 'keedev-pricing-tables' ),
                          array( $this, 'render_shortcode_metabox' ),
                          self::$pricing_table,
                          'side',
                          'default' );
        }

        public function get_default_settings() {
            return array(
                'style'          => 'basic',
                'hover_effect'   => 'none',
                'active_style'   => 'none',
                'column_margin'  => 'medium',
                'sync_row_types' => 'yes'
            );
        }

        /**
         * render the Settings metabox
         *
         * @param WP_Post $post
         */
        public function render_settings_metabox( $post ) {
            $settings = array();

            foreach ( $this->get_default_settings() as $key => $default_value ) {
                $settings[ $key ] = metadata_exists( 'post', $post->ID, $key ) ?
                    get_post_meta( $post->ID, $key, true ) :
                    $default_value;
            }

            keedev_pt_include_free_or_premium_file( KEEDEV_PT_VIEWS_PATH . '/admin/metaboxes/metabox-settings.php', $settings );
        }

        /**
         * render the Shortcode metabox
         *
         * @param WP_Post $post
         */
        public function render_shortcode_metabox( $post ) {
            $post_id = $post->ID;
            echo "<code id='keedev-pt-shortcode__container'>[keedev_pricing_table id={$post_id}]</code>";
            echo "<span class='keedev-copy-to-clipboard' data-target='#keedev-pt-shortcode__container'></span>";
        }

        /**
         * render the Pricing Table metabox
         *
         * @param WP_Post $post
         */
        public function render_table_metabox( $post ) {
            $table_data = get_post_meta( $post->ID, 'table', true );

            // PRESET
            global $pagenow;
            if ( 'post-new.php' === $pagenow && !empty( $_GET[ 'keedev-preset' ] ) && 'empty' !== $_GET[ 'keedev-preset' ] ) {
                $preset_key = $_GET[ 'keedev-preset' ];
                $preset     = KeeDev_Pricing_Tables()->admin->presets->get_table_settings_from_preset( $preset_key );
                if ( $preset ) {
                    $table_data = $preset;
                }
            }

            $table = new KeeDev_PT_Pricing_Table_Admin( $table_data );
            $table->display();
        }

        /**
         * save the metabox fields
         *
         * @param int $post_id
         */
        public function save_metabox( $post_id ) {
            if ( self::$pricing_table === get_post_type( $post_id ) ) {

                foreach ( $this->get_default_settings() as $key => $default_value ) {
                    if ( isset( $_POST[ $key ] ) ) {
                        $meta = $_POST[ $key ];
                        update_post_meta( $post_id, $key, $meta );
                    }
                }

                if ( !empty( $_POST[ 'table' ] ) ) {
                    $meta = $_POST[ 'table' ];
                    update_post_meta( $post_id, 'table', $meta );
                }
            }
        }

        /**
         * Add Duplicate action
         *
         * @param array   $actions
         * @param WP_Post $post
         *
         * @return array
         */
        public function add_duplicate_action( $actions, $post ) {
            if ( $post->post_type === self::$pricing_table && $post->post_status === 'publish' ) {
                $args        = array(
                    'action' => 'duplicate_pricing_table',
                    'id'     => $post->ID
                );
                $link        = add_query_arg( $args, admin_url() );
                $action_name = __( 'Duplicate', 'keedev-pricing-tables' );

                $actions[ 'duplicate_pricing_table' ] = "<a href='{$link}'>{$action_name}</a>";
            }

            return $actions;
        }

        /**
         * Duplicate pricing table
         */
        public function duplicate_pricing_table() {
            if ( isset( $_REQUEST[ 'action' ] ) && $_REQUEST[ 'action' ] = 'duplicate_pricing_table' && isset( $_REQUEST[ 'id' ] ) ) {
                $post_id = absint( $_REQUEST[ 'id' ] );
                $post    = get_post( $post_id );

                if ( !$post || $post->post_type !== self::$pricing_table )
                    return;

                $new_post = array(
                    'post_status' => $post->post_status,
                    'post_type'   => self::$pricing_table,
                    'post_title'  => $post->post_title . ' - ' . __( 'Copy', 'keedev-pricing-tables' ),
                );

                $new_post_id = wp_insert_post( $new_post );

                if ( $meta = get_post_meta( $post_id ) ) {
                    foreach ( $meta as $key => $value ) {
                        update_post_meta( $new_post_id, $key, maybe_unserialize( current( $value ) ) );
                    }
                }

                $admin_edit_url = admin_url( "edit.php?post_type=" . self::$pricing_table );
                wp_redirect( $admin_edit_url );
            }
        }

        /**
         * Register post types
         */
        public function register_post_types() {
            if ( post_type_exists( self::$pricing_table ) )
                return;

            $labels = array(
                'name'               => __( 'Pricing Tables', 'keedev-pricing-tables' ),
                'singular_name'      => __( 'Pricing Table', 'keedev-pricing-tables' ),
                'add_new'            => __( 'Add Pricing Table', 'keedev-pricing-tables' ),
                'add_new_item'       => __( 'Add New Pricing Table', 'keedev-pricing-tables' ),
                'edit_item'          => __( 'Edit Pricing Table', 'keedev-pricing-tables' ),
                'view_item'          => __( 'View Pricing Table', 'keedev-pricing-tables' ),
                'not_found'          => __( 'Pricing Table not found', 'keedev-pricing-tables' ),
                'not_found_in_trash' => __( 'Pricing Table not found in trash', 'keedev-pricing-tables' ),
            );

            $args = array(
                'labels'              => $labels,
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => false,
                'exclude_from_search' => true,
                'rewrite'             => true,
                'has_archive'         => false,
                'hierarchical'        => false,
                'show_in_nav_menus'   => false,
                'supports'            => array( 'title' ),
            );

            register_post_type( self::$pricing_table, $args );
        }
    }
}