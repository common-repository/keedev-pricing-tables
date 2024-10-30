<?php
/**
 * @var KeeDev_PT_Pricing_Table $pricing_table
 * @var string                  $style
 * @var string                  $hover_effect
 * @var string                  $active_style
 * @var string                  $column_margin
 */

$style         = !!$style ? $style : $pricing_table->get_style();
$hover_effect  = !!$hover_effect ? $hover_effect : $pricing_table->get_hover_effect();
$active_style  = !!$active_style ? $active_style : $pricing_table->get_active_style();
$column_margin = !!$column_margin ? $column_margin : $pricing_table->get_column_margin( 'int' );
$table_css_id  = 'keedev-pt-pricing-table-' . $pricing_table->get_id();
?>
<div id="<?php echo $table_css_id ?>" class="keedev-pt-pricing-table keedev-pt-clearfix keedev-pt-pricing-table--<?php echo $style ?>-style keedev-pt-pricing-table--<?php echo $hover_effect ?>-hover-effect keedev-pt-pricing-table--<?php echo $active_style ?>-active-style">
    <?php
    if ( $table_info = $pricing_table->get_table_info() ) {
        extract( $table_info );
        /**
         * @var $col_settings
         * @var $row_settings
         * @var $col_number
         * @var $row_number
         * @var $cells
         * @var $columns
         */

        $margins     = ( $col_number - 1 ) * $column_margin;
        $each_margin = $margins / $col_number;
        $width       = 100 / $col_number;
        $width       = floor( $width * 100 ) / 100;
        $width       = "calc({$width}% - {$each_margin}px)";
        //$width   = ( 100 - $margins ) / $col_number;
        for ( $col = 0; $col < $col_number; $col++ ) {
            $current_column_number = $col + 1;
            $last                  = $col === ( $col_number - 1 );
            $style                 = "width:$width;";
            $style                 .= !$last ? "margin-right:{$column_margin}px;" : '';

            $active    = !empty( $col_settings[ 'active' ][ $col ] ) && 'yes' === $col_settings[ 'active' ][ $col ] ? 'active' : 'not-active';
            $alignment = !empty( $col_settings[ 'alignment' ][ $col ] ) ? $col_settings[ 'alignment' ][ $col ] : 'center';

            $column_classes = "keedev-pt-pricing-table-column";
            $column_classes .= " keedev-pt-pricing-table-column--{$alignment}-alignment";
            $column_classes .= " keedev-pt-pricing-table-column--{$active}";

            echo "<div class='$column_classes' data-column-number='$current_column_number' style='$style'>";

            if ( !empty( $col_settings[ 'badge' ][ $col ] ) && !empty( $col_settings[ 'badge_text' ][ $col ] ) ) {
                $badge            = $col_settings[ 'badge' ][ $col ];
                $badge_text       = $col_settings[ 'badge_text' ][ $col ];
                $badge_color      = !empty( $col_settings[ 'badge_color' ][ $col ] ) ? $col_settings[ 'badge_color' ][ $col ] : '#dc2b5c';
                $badge_text_color = !empty( $col_settings[ 'badge_text_color' ][ $col ] ) ? $col_settings[ 'badge_text_color' ][ $col ] : '#ffffff';

                keedev_pt_get_template( "pricing-table/badge.php", compact( 'table_css_id', 'current_column_number', 'badge', 'badge_text', 'badge_color', 'badge_text_color' ) );
            }

            echo "<ul class='keedev-pt-pricing-table-column__list'>";
            for ( $row = 0; $row < $row_number; $row++ ) {
                $position = $row * $col_number + $col;
                $type     = $cells[ 'type' ][ $position ];
                echo "<li class='keedev-pt-pricing-table-row keedev-pt-pricing-table-row-{$type}'>";
                echo "<div class='keedev-pt-pricing-table-inside'>";
                echo "<div class='keedev-pt-pricing-table-field__container'>";
                $field = array();
                foreach ( array_keys( KeeDev_PT_Pricing_Table_Admin::get_cell_settings() ) as $key ) {
                    $field[ $key ] = isset( $cells[ $key ][ $position ] ) ? $cells[ $key ][ $position ] : KeeDev_PT_Pricing_Table_Admin::get_default_cell_settings_value( $key );
                }

                $template = "pricing-table/" . $field[ 'type' ] . '.php';
                keedev_pt_get_template( $template, $field );
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
    ?>
</div>