<?php
/**
 * This file belongs to the keedev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $field
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly
extract( $field );

wp_enqueue_style( 'font-awesome' );

$default           = isset( $default ) ? $default : '';
$default_icon_text = $default;
$default_icon_data = KeeDev()->icons->get_icon_data( $default_icon_text );

$icon_text = $value;
$icon_data = KeeDev()->icons->get_icon_data( $value );

$keedev_icons = KeeDev()->icons->get_icons();
?>

<div id="keedev-icons-<?php echo $id ?>__container" class="keedev-icons__container">

    <div class="keedev-icons-data__container keedev-clearfix">
        <input class="keedev-icons-data-text" type="hidden" id="<?php echo $id ?>" name="<?php echo $name ?>" value="<?php echo $icon_text; ?>"/>
        <div class="keedev-icons-data-preview__container">
            <span class="keedev-icons-data-preview" <?php echo $icon_data ?>></span>
        </div>
        <div class="keedev-icons-data-label"><?php _e( 'Select Icon', 'keedev' ) ?></div>
        <div class="clear"></div>
    </div>


    <div class="keedev-icons-selector">

        <div class="keedev-icons-list__container">
            <ul class="keedev-icons-list">
                <?php foreach ( $keedev_icons as $font => $icons ):
                    foreach ( $icons as $_icon_key => $_icon_name ):
                        $_icon_text = $font . ':' . $_icon_name;
                        $_icon_class = $_icon_text == $icon_text ? 'active' : '';
                        $_icon_class .= $_icon_text == $default_icon_text ? ' default' : '';
                        ?>
                        <li class="<?php echo $_icon_class ?>" data-font="keedev-<?php echo $font ?>" data-icon="<?php echo '&#x' . $_icon_key; ?>" data-key="<?php echo $_icon_key ?>"
                            data-name="<?php echo $_icon_name ?>"></li>
                        <?php
                    endforeach;
                endforeach; ?>
            </ul>
        </div>

        <div class="keedev-icons-actions">
            <?php if ( $default_icon_text ): ?>
                <div class="keedev-icons-action keedev-icons-action-set-default"><?php _e( 'Set Default', 'keedev' ) ?>
                    <i class="keedev-icons-default-icon-preview" <?php echo $default_icon_data ?>></i></div>
            <?php endif ?>
        </div>

    </div>

</div>