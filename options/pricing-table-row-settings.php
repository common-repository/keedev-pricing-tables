<?php
$meta_name = 'table[row_settings]';

$settings = array(
    'height' => array(
        'label'   => __( 'Height', 'keedev-pricing-tables' ),
        'name'    => "{$meta_name}[height][]",
        'type'    => 'number',
        'default' => '',
    )
);

return $settings;