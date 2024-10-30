<?php
$table       = new KeeDev_PT_Pricing_Table_List();
$add_new_url = esc_url( add_query_arg( array( 'post_type' => KeeDev_PT_Pricing_Table_CPT_Manager::$pricing_table ), admin_url( 'post-new.php' ) ) );
$presets     = KeeDev_Pricing_Tables()->admin->presets->get_presets();
?>

<div class="wrap">
    <h1><a id="keedev-pt-add-new" href="<?php echo $add_new_url; ?>" class="add-new-h2"><?php _e( 'Add New Pricing Table', 'keedev-pricing-tables' ) ?></a></h1>

    <div id="keedev-pt-wizard" class="keedev-clearfix">
        <?php foreach ( $presets as $preset_key => $preset ) :
            if ( !is_array( $preset ) ) {
                if ( 'separator' === $preset ) {
                    echo "<div class='keedev-pt-wizard__separator'></div>";
                }
                continue;
            }
            $url      = esc_url( add_query_arg( array( 'keedev-preset' => $preset_key ), $add_new_url ) );
            $defaults = array( 'title' => '', 'content' => '' );
            $preset   = wp_parse_args( $preset, $defaults );
            ?>
            <a href="<?php echo $url ?>">
                <div class="keedev-pt-wizard__item keedev-pt-wizard__item-<?php echo $preset_key ?>">
                    <div class="keedev-pt-wizard__item__content">
                        <div class="keedev-pt-wizard__item__content-wrapper">
                            <?php echo $preset[ 'content' ] ?>
                        </div>
                    </div>
                    <div class="keedev-pt-wizard__item__title">
                        <?php echo $preset[ 'title' ] ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <input type="hidden" name="page" value="<?php echo !empty( $_REQUEST[ 'page' ] ) ? $_REQUEST[ 'page' ] : '' ?>"/>
                        <input type="hidden" name="tab" value="<?php echo !empty( $_REQUEST[ 'tab' ] ) ? $_REQUEST[ 'tab' ] : '' ?>"/>
                        <?php
                        $table->views();
                        $table->prepare_items();
                        $table->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>