<?php
/**
 * Prints the Pricing Table list table in KeeDev -> Pricing Tables
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( !class_exists( 'WP_Posts_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );
}

if ( !class_exists( 'KeeDev_PT_Pricing_Table_List' ) ) {
    class KeeDev_PT_Pricing_Table_List extends WP_Posts_List_Table {

        /**
         * Initialize the Pricing Table table list.
         */
        public function __construct() {
            $post_type = KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table;

            $screen            = get_current_screen();
            $screen->post_type = $post_type;

            $args = array(
                'singular' => $post_type,
                'plural'   => $post_type . 's',
                'ajax'     => false,
                'screen'   => $screen
            );
            parent::__construct( $args );

            $this->process_bulk_action();
        }

        /**
         * Helper to create links for editing with params.
         *
         * @access protected
         *
         * @param array  $args URL parameters for the link.
         * @param string $label Link text.
         * @param string $class Optional. Class attribute. Default empty string.
         *
         * @return string The formatted link string.
         */
        protected function get_edit_link( $args, $label, $class = '' ) {
            unset( $args[ 'post_type' ] );
            $args[ 'page' ] = 'keedev-pricing-tables';
            $url            = add_query_arg( $args, admin_url( 'admin.php' ) );

            $class_html = '';
            if ( !empty( $class ) ) {
                $class_html = sprintf(
                    ' class="%s"',
                    esc_attr( $class )
                );
            }

            return sprintf(
                '<a href="%s"%s>%s</a>',
                esc_url( $url ),
                $class_html,
                $label
            );
        }

        /**
         * Table list views.
         *
         * @return array
         */
        protected function get_views() {
            global $avail_post_stati;
            $avail_post_stati = wp_edit_posts_query();

            return parent::get_views();
        }

        /**
         * Determine if the current view is the "All" view.
         *
         * @return bool Whether the current view is the "All" view.
         */
        protected function is_base_request() {
            $vars = $_GET;
            unset( $vars[ 'paged' ] );
            unset( $vars[ 'page' ] );

            if ( empty( $vars ) ) {
                return true;
            }

            return false;
        }

        /**
         * Prepare table list items.
         */
        public function prepare_items() {
            global $wp_query;
            $per_page = $this->get_items_per_page( 'edit_' . KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table . '_per_page' );

            $columns  = $this->get_columns();
            $hidden   = array();
            $sortable = $this->get_sortable_columns();

            // Column headers
            $this->_column_headers = array( $columns, $hidden, $sortable );

            $current_page = $this->get_pagenum();

            // Query args
            $args = array(
                'post_type'           => KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table,
                'posts_per_page'      => $per_page,
                'ignore_sticky_posts' => true,
                'paged'               => $current_page,
            );

            // Handle the status query
            if ( !empty( $_REQUEST[ 'post_status' ] ) ) {
                $args[ 'post_status' ] = sanitize_text_field( $_REQUEST[ 'post_status' ] );
            }

            if ( !empty( $_REQUEST[ 's' ] ) ) {
                $args[ 's' ] = sanitize_text_field( $_REQUEST[ 's' ] );
            }

            // Get the items
            $wp_query = new WP_Query( $args );

            parent::prepare_items();
        }


        /**
         * Get bulk action
         *
         * @since  1.0.0
         * @return array|false|string
         */
        function get_bulk_actions() {
            if ( isset( $_GET[ 'post_status' ] ) && 'trash' == $_GET[ 'post_status' ] ) {
                return array(
                    'restore' => __( 'Restore' ),
                    'delete'  => __( 'Delete Permanently' )
                );
            }

            return array(
                'trash' => __( 'Move to Trash' )
            );

        }

        public function process_bulk_action() {

            $actions = $this->current_action();

            if ( !empty( $actions ) && isset( $_REQUEST[ 'post' ] ) ) {

                $item_ids = (array) $_REQUEST[ 'post' ];

                foreach ( $item_ids as $item_id ) {

                    $post = get_post( $item_id );

                    if ( !$post || $post->post_type !== $this->screen->post_type ) {
                        continue;
                    }

                    $post_type_object = get_post_type_object( $post->post_type );

                    if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {
                        switch ( $actions ) {
                            case 'delete':
                                wp_delete_post( $item_id, true );
                                break;
                            case 'restore':
                                wp_untrash_post( $item_id );
                                break;
                            case 'trash':
                                wp_trash_post( $item_id );
                                break;
                            default:

                        }
                    }
                }
            }
        }

        /**
         * Generate row actions div
         *
         * @access protected
         *
         * @param array $actions The list of actions
         * @param bool  $always_visible Whether the actions should be always visible
         *
         * @return string
         */
        protected function row_actions( $actions, $always_visible = false ) {
            unset( $actions[ 'inline hide-if-no-js' ] );

            return parent::row_actions( $actions, $always_visible );
        }

    }
}