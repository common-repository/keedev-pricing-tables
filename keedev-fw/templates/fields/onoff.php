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
$class          = isset( $class ) ? $class : '';
$data           = isset( $data ) ? $data : array();
$allowed_values = array( 'yes', 'no' );
$value          = !empty( $value ) && in_array( $value, $allowed_values ) ? $value : 'no';
$status         = 'yes' === $value ? '' : 'disabled';
?>
<span class="keedev-onoff <?php echo $class . ' ' . $status ?>">
    <input type="hidden" name="<?php echo $name ?>"
           id="<?php echo $id ?>"
           value="<?php echo esc_attr( $value ) ?>"
        <?php echo $custom_attributes ?>
        <?php echo keedev_get_html_data( $data ); ?>/>
</span>
