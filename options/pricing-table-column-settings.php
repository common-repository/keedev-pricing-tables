<?php
$meta_name = 'table[column_settings]';

$settings =  array(
    'alignment'        => array(
        'label'   => __( 'Alignment', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[alignment][]",
        'type'    => 'select',
        'default' => 'center',
        'options' => array(
            'left'   => __( 'Left', 'keedev-pricing-tables' ),
            'center' => __( 'Center', 'keedev-pricing-tables' ),
            'right'  => __( 'Right', 'keedev-pricing-tables' ),
        )
    )
);

return $settings;