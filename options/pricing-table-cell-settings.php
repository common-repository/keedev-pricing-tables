<?php
$meta_name = 'table[cells]';

$settings = array(
    'type'     => array(
        'label'   => __( 'Type', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[type][]",
        'class'   => 'keedev-pt-pricing-table-admin-field-type',
        'type'    => 'select',
        'default' => 'default',
        'options' => array(
            'button' => __( 'Button', 'keedev-pricing-tables' ),
            'text'   => __( 'Text', 'keedev-pricing-tables' ),
            'title'  => __( 'Title', 'keedev-pricing-tables' ),
            'price'  => __( 'Price', 'keedev-pricing-tables' ),
        )
    ),
    'price'    => array(
        'label'   => __( 'Price', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[price][]",
        'class'   => 'keedev-pt-pricing-table-admin-field-text',
        'type'    => 'text',
        'default' => '',
    ),
    'currency' => array(
        'label'   => __( 'Currency', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[currency][]",
        'class'   => 'keedev-pt-pricing-table-admin-field-currency',
        'type'    => 'text',
        'default' => '',
    ),
    'text'     => array(
        'label'   => __( 'Text', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[text][]",
        'class'   => 'keedev-pt-pricing-table-admin-field-text',
        'type'    => 'text',
        'default' => '',
    ),
    'url'      => array(
        'label'   => __( 'Url', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[url][]",
        'class'   => 'keedev-pt-pricing-table-admin-field-url',
        'type'    => 'text',
        'default' => '',
    )
);

return $settings;