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

$class = isset( $class ) ? $class : 'keedev-text-input';
$data  = isset( $data ) ? $data : array();

?>
<input type="text" name="<?php echo $name ?>"
       id="<?php echo $id ?>"
       value="<?php echo esc_attr( $value ) ?>"
       class="<?php echo $class ?>"
       <?php if ( isset( $std ) ) : ?>data-std="<?php echo $std ?>"<?php endif ?>
    <?php echo $custom_attributes ?>
    <?php echo keedev_get_html_data( $data ); ?>/>

