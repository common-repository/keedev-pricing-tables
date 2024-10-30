<?php
/**
 * This file belongs to the keedev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !function_exists( 'keedev_deactivate_plugin' ) ) {
    function keedev_deactivate_plugin( $const ) {
        !function_exists( 'is_plugin_active' ) && require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        defined( $const ) && is_plugin_active( constant( $const ) ) && deactivate_plugins( constant( $const ) );
    }
}

if ( !function_exists( 'keedev_get_field' ) ) {
    /**
     * gets or prints a KeeDev field
     *
     * @param array $field
     * @param bool  $echo
     * @param bool  $container
     *
     * @return string|void
     */
    function keedev_get_field( $field, $echo = false, $container = true ) {
        if ( empty( $field[ 'type' ] ) )
            return '';

        $default = array(
            'id'                => '',
            'value'             => '',
            'name'              => '',
            'custom_attributes' => '',
        );
        $field   = wp_parse_args( $field, $default );

        if ( $template = keedev_get_field_template_path( $field ) ) {
            !$echo && ob_start();

            if ( $container ) echo '<div class="keedev-field__container keedev-' . $field[ 'type' ] . '-field__container">';

            do_action( 'keedev_get_field_before', $field );
            include( $template );
            do_action( 'keedev_get_field_after', $field );

            if ( $container ) echo '</div>';

            return !$echo ? ob_get_clean() : true;
        }

        return '';
    }
}

if ( !function_exists( 'keedev_get_field_template_path' ) ) {
    function keedev_get_field_template_path( $field ) {
        if ( empty( $field[ 'type' ] ) )
            return false;

        $template = KEEDEV_TEMPLATE_PATH . '/fields/' . sanitize_title( $field[ 'type' ] ) . '.php';
        $template = apply_filters( 'keedev_get_field_template_path', $template, $field );

        return file_exists( $template ) ? $template : false;
    }
}

if ( !function_exists( 'keedev_get_html_data' ) ) {
    function keedev_get_html_data( $data = array() ) {
        $data_html = '';
        if ( !!$data ) {
            foreach ( $data as $key => $value ) {
                $data_html .= "data-$key='$value' ";
            }
        }

        return $data_html;
    }
}