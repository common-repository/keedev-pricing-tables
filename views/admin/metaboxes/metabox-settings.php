<?php
/**
 * @var string $style
 * @var string $hover_effect
 * @var string $column_margin
 * @var string $sync_row_types
 */
?>

<table class="keedev-pt-metabox-table">

    <tr>
        <td>
            <label for="keedev-pt-settings-style"><?php _e( 'Style', 'keedev-pricing-tables' ) ?></label>
        </td>
        <td>
            <div id="keedev-pt-settings-style-selector">
                <input class="keedev-pt-settings-style-selector__value" type="hidden" name="style" value="<?php echo $style ?>"/>
                <div class="keedev-pt-settings-style-selector__label-container">
                    <span class="keedev-pt-settings-style-selector__label">
                    <?php echo strtr( $style, keedev_pt_get_pricing_table_styles() ); ?>
                    </span>
                    <span class="dashicons dashicons-arrow-down"></span>
                </div>

                <div class="keedev-pt-settings-style-selector__options">
                    <?php
                    foreach ( keedev_pt_get_pricing_table_styles() as $value => $label ) {
                        $active_class = $value === $style ? 'active' : '';
                        $img_url      = KEEDEV_PT_ASSETS_URL . '/images/style-previews/' . $value . '.jpg';
                        echo "<div class='keedev-pt-settings-style-selector__item $active_class' data-value='$value' data-label='$label'>";
                        echo "<img src='$img_url' />";
                        echo "<span>$label</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <label><?php _e( 'Sync Row Types', 'keedev-pricing-tables' ) ?></label>
        </td>
        <td>
            <?php
            $field = array(
                'id'    => 'keedev-pt-settings-sync-row-types',
                'name'  => 'sync_row_types',
                'type'  => 'onoff',
                'value' => $sync_row_types
            );
            keedev_get_field( $field, true, false );
            ?>
        </td>
    </tr>

    <tr>
        <td>
            <label><?php _e( 'Distraction Free', 'keedev-pricing-tables' ) ?></label>

        </td>
        <td>
            <?php
            $field = array(
                'class' => 'keedev-pt-distraction-free-toggle',
                'type'  => 'onoff',
                'value' => 'no'
            );
            keedev_get_field( $field, true, false );
            ?>
        </td>
    </tr>
</table>