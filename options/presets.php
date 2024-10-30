<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

$full_preset_col_html     = '<span class="keedev-pt-wizard-preset-column keedev-pt-wizard-preset-column--full"></span>';
$standard_preset_col_html = '<span class="keedev-pt-wizard-preset-column keedev-pt-wizard-preset-column--standard"></span>';
$mini_preset_col_html     = '<span class="keedev-pt-wizard-preset-column keedev-pt-wizard-preset-column--mini"></span>';

$full_cells = array(
    array(
        array(
            'type' => 'title',
            'text' => 'Basic'
        ),
        array(
            'type'     => 'price',
            'price'    => 'Free',
            'currency' => '',
            'text'     => '',
        ),
        array(
            'type' => 'text',
            'text' => 'Totally Free'
        ),
        array(
            'type' => 'text',
            'text' => '5 users'
        ),
        array(
            'type' => 'text',
            'text' => '10 projects'
        ),
        array(
            'type' => 'text',
            'text' => '10 GB amount of space'
        ),
        array(
            'type' => 'text',
            'text' => '5 email accounts'
        ),
        array(
            'type' => 'text',
            'text' => 'For individuals'
        ),
        array(
            'type' => 'button',
            'text' => 'SIGN UP!'
        ),
    ),
    array(
        array(
            'type' => 'title',
            'text' => 'Standard'
        ),
        array(
            'type'     => 'price',
            'price'    => '12,<small>99</small>',
            'currency' => '$',
            'text'     => '/2 months',
        ),
        array(
            'type' => 'text',
            'text' => 'Available for 2 months'
        ),
        array(
            'type' => 'text',
            'text' => '10 users'
        ),
        array(
            'type' => 'text',
            'text' => '50 projects'
        ),
        array(
            'type' => 'text',
            'text' => '50 GB amount of space'
        ),
        array(
            'type' => 'text',
            'text' => '10 email accounts'
        ),
        array(
            'type' => 'text',
            'text' => 'For small business websites'
        ),
        array(
            'type' => 'button',
            'text' => 'SIGN UP!'
        ),
    ),
    array(
        array(
            'type' => 'title',
            'text' => 'Premium'
        ),
        array(
            'type'     => 'price',
            'price'    => '39,<small>99</small>',
            'currency' => '$',
            'text'     => '/6 months',
        ),
        array(
            'type' => 'text',
            'text' => 'Available for 6 months'
        ),
        array(
            'type' => 'text',
            'text' => '50 users'
        ),
        array(
            'type' => 'text',
            'text' => '100 projects'
        ),
        array(
            'type' => 'text',
            'text' => '1 TB amount of space'
        ),
        array(
            'type' => 'text',
            'text' => '100 email accounts'
        ),
        array(
            'type' => 'text',
            'text' => 'For corporate teams'
        ),
        array(
            'type' => 'button',
            'text' => 'SIGN UP!'
        ),
    ),
    array(
        array(
            'type' => 'title',
            'text' => 'Professional'
        ),
        array(
            'type'     => 'price',
            'price'    => '59,<small>99</small>',
            'currency' => '$',
            'text'     => '/1 year',
        ),
        array(
            'type' => 'text',
            'text' => 'Available for 1 year'
        ),
        array(
            'type' => 'text',
            'text' => 'unlimited users'
        ),
        array(
            'type' => 'text',
            'text' => 'unlimited projects'
        ),
        array(
            'type' => 'text',
            'text' => 'unlimited amount of space'
        ),
        array(
            'type' => 'text',
            'text' => 'unlimited email accounts'
        ),
        array(
            'type' => 'text',
            'text' => 'For large enterprices'
        ),
        array(
            'type' => 'button',
            'text' => 'SIGN UP!'
        ),
    )
);


$mini_cells = array();
foreach ( $full_cells as $single_full_cell ) {
    $mini_cells[] = array( $single_full_cell[ 0 ], $single_full_cell[ 1 ], $single_full_cell[ 2 ], $single_full_cell[ 8 ] );
}

$standard_cells = array();
foreach ( $full_cells as $single_full_cell ) {
    $standard_cells[] = array( $single_full_cell[ 0 ], $single_full_cell[ 1 ], $single_full_cell[ 2 ], $single_full_cell[ 3 ], $single_full_cell[ 4 ], $single_full_cell[ 5 ], $single_full_cell[ 8 ] );
}

return array(
    'empty'           => array(
        'title' => __( 'Empty', 'keedev-pricing-tables' )
    ),
    'separator-1'     => 'separator',
    'mini-2-cols'     => array(
        'title'   => __( 'Mini 2 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $mini_preset_col_html, 2 ),
        'cells'   => array_slice( $mini_cells, 1, 2 )
    ),
    'mini-3-cols'     => array(
        'title'   => __( 'Mini 3 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $mini_preset_col_html, 3 ),
        'cells'   => array_slice( $mini_cells, 0, 3 )
    ),
    'mini-4-cols'     => array(
        'title'   => __( 'Mini 4 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $mini_preset_col_html, 4 ),
        'cells'   => $mini_cells
    ),
    'separator-2'     => 'separator',
    'standard-2-cols' => array(
        'title'   => __( 'Standard 2 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $standard_preset_col_html, 2 ),
        'cells'   => array_slice( $standard_cells, 1, 2 )
    ),
    'standard-3-cols' => array(
        'title'   => __( 'Standard 3 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $standard_preset_col_html, 3 ),
        'cells'   => array_slice( $standard_cells, 0, 3 )
    ),
    'standard-4-cols' => array(
        'title'   => __( 'Standard 4 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $standard_preset_col_html, 4 ),
        'cells'   => $standard_cells
    ),
    'separator-3'     => 'separator',
    'full-2-cols'     => array(
        'title'   => __( 'Full 2 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $full_preset_col_html, 2 ),
        'cells'   => array_slice( $full_cells, 1, 2 )
    ),
    'full-3-cols'     => array(
        'title'   => __( 'Full 3 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $full_preset_col_html, 3 ),
        'cells'   => array_slice( $full_cells, 0, 3 )
    ),
    'full-4-cols'     => array(
        'title'   => __( 'Full 4 Columns', 'keedev-pricing-tables' ),
        'content' => str_repeat( $full_preset_col_html, 4 ),
        'cells'   => $full_cells
    ),
);