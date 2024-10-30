<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.


if ( !function_exists( 'keedev_pt_get_pricing_tables' ) ) {
    function keedev_pt_get_pricing_tables( $args = array() ) {
        $default_args = array(
            'posts_per_page' => -1,
            'post_type'      => KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table,
            'post_status'    => 'publish',
            'fields'         => 'ids'
        );

        $args = wp_parse_args( $args, $default_args );

        return get_posts( $args );
    }
}

if ( !function_exists( 'keedev_pt_get_options' ) ) {
    function keedev_pt_get_options( $key, $free = false ) {
        $file         = KEEDEV_PT_OPTIONS_PATH . "/{$key}.php";
        $premium_file = KEEDEV_PT_OPTIONS_PATH . "/premium/{$key}.php";

        $options = array();
        if ( !$free && defined( 'KEEDEV_PT_PREMIUM' ) && KEEDEV_PT_PREMIUM && file_exists( $premium_file ) )
            $options = include $premium_file;
        elseif ( file_exists( $file ) )
            $options = include $file;

        return apply_filters( 'keedev_pt_get_options', $options, $key );
    }
}

if ( !function_exists( 'keedev_pt_include_free_or_premium_file' ) ) {
    function keedev_pt_include_free_or_premium_file( $_path, $args = array() ) {
        extract($args);
        list( $_file, $_ext ) = explode( '.', $_path, 2 );
        $_premium_file = $_file . '-premium.' . $_ext;
        $_free_file    = $_path;
        $_include      = '';
        if ( defined( 'KEEDEV_PT_PREMIUM' ) && KEEDEV_PT_PREMIUM && file_exists( $_premium_file ) )
            $_include = include $_premium_file;
        elseif ( file_exists( $_free_file ) )
            $_include = include $_free_file;

        return $_include;
    }
}

if ( !function_exists( 'keedev_pt_get_pricing_table_styles' ) ) {
    function keedev_pt_get_pricing_table_styles() {
        $styles = keedev_pt_get_options( 'pricing-table-styles' );

        return apply_filters( 'keedev_pt_get_pricing_table_styles', $styles );
    }
}

if ( !function_exists( 'keedev_pt_get_html_data' ) ) {
    function keedev_pt_get_html_data( $data = array() ) {
        $data_html = '';
        if ( !!$data ) {
            foreach ( $data as $key => $value ) {
                $data_html .= "data-$key='$value' ";
            }
        }

        return $data_html;
    }
}

if ( !function_exists( 'keedev_pt_get_pricing_table' ) ) {
    function keedev_pt_get_pricing_table( $id = '' ) {
        $pricing_table = new KeeDev_PT_Pricing_Table( $id );

        return $pricing_table->is_valid() ? $pricing_table : false;
    }
}

if ( !function_exists( 'keedev_pt_get_template' ) ) {
    function keedev_pt_get_template( $template = '', $args = array() ) {
        $template_url = KEEDEV_PT_TEMPLATES_PATH . '/' . $template;
        if ( file_exists( $template_url ) ) {
            extract( $args );
            include $template_url;
        }
    }
}

if ( !function_exists( 'keedev_pt_enqueue_badge_color_styles' ) ) {
    function keedev_pt_enqueue_badge_color_styles( $args = array() ) {
        if ( !empty( $args[ 'badge' ] ) ) {
            ob_start();
            keedev_pt_get_template( 'pricing-table/badge-colors/' . $args[ 'badge' ] . '.php', $args );
            $css = ob_get_clean();

            wp_add_inline_style( 'keedev-pricing-tables-frontend', $css );
        }
    }
}

if ( !function_exists( 'keedev_pt_darker_color' ) ) {
    function keedev_pt_darker_color( $col, $fact ) {
        $col  = str_replace( '#', '', $col );
        $r    = $col[ 0 ] . $col[ 1 ];
        $g    = $col[ 2 ] . $col[ 3 ];
        $b    = $col[ 4 ] . $col[ 5 ];
        $r_d  = hexdec( $r );
        $g_d  = hexdec( $g );
        $b_d  = hexdec( $b );
        $r1_d = $fact * $r_d;
        $g1_d = $fact * $g_d;
        $b1_d = $fact * $b_d;
        $r1_0 = $r1_d < 16 ? '0' : '';
        $g1_0 = $g1_d < 16 ? '0' : '';
        $b1_0 = $g1_d < 16 ? '0' : '';
        $r1   = $r1_0 . dechex( $r1_d );
        $g1   = $g1_0 . dechex( $g1_d );
        $b1   = $b1_0 . dechex( $b1_d );

        return '#' . $r1 . $g1 . $b1;
    }
}