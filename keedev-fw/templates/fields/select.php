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
$multiple      = isset( $multiple ) && $multiple;
$multiple_html = ( $multiple ) ? ' multiple' : '';

if ( $multiple && !is_array( $value ) )
    $value = array();

$class = isset( $class ) ? $class : 'keedev-select';
$data        = isset( $data ) ? $data : array();

?>
<select<?php echo $multiple_html ?>
    id="<?php echo $id ?>"
    name="<?php echo $name ?><?php if ( $multiple ) echo "[]" ?>" <?php if ( isset( $std ) ) : ?>
    data-std="<?php echo ( $multiple ) ? implode( ' ,', $std ) : $std ?>"<?php endif ?>
    class="<?php echo $class ?>"
    <?php echo $custom_attributes ?>
    <?php echo keedev_get_html_data( $data ); ?> >
    <?php foreach ( $options as $key => $item ) : ?>
        <option value="<?php echo esc_attr( $key ) ?>" <?php if ( $multiple ): selected( true, in_array( $key, $value ) );
        else: selected( $key, $value ); endif; ?> ><?php echo $item ?></option>
    <?php endforeach; ?>
</select>