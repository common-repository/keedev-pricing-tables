<?php
/**
 * Plugin Name: KeeDev Pricing Tables
 * Description: KeeDev Pricing Tables allows to create gorgeous pricing tables! Enjoy
 * Version: 1.0.0
 * Author: KeeDev
 * Author URI: http://keedev.com/
 * Requires at least: 4.5
 * Tested up to: 4.9.7
 *
 * Text Domain: keedev-pricing-tables
 *
 * @package KeeDev Pricing Tables
 * @author  KeeDev
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !defined( 'KEEDEV_PT' ) ) define( 'KEEDEV_PT', true );
if ( !defined( 'KEEDEV_PT_VERSION' ) ) define( 'KEEDEV_PT_VERSION', '1.0.0' );
if ( !defined( 'KEEDEV_PT_FREE_INIT' ) ) define( 'KEEDEV_PT_FREE_INIT', plugin_basename( __FILE__ ) );
if ( !defined( 'KEEDEV_PT_INIT' ) ) define( 'KEEDEV_PT_INIT', plugin_basename( __FILE__ ) );
if ( !defined( 'KEEDEV_PT_DIR' ) ) define( 'KEEDEV_PT_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
if ( !defined( 'KEEDEV_PT_URL' ) ) define( 'KEEDEV_PT_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
if ( !defined( 'KEEDEV_PT_TEMPLATES_PATH' ) ) define( 'KEEDEV_PT_TEMPLATES_PATH', KEEDEV_PT_DIR . '/templates' );
if ( !defined( 'KEEDEV_PT_OPTIONS_PATH' ) ) define( 'KEEDEV_PT_OPTIONS_PATH', KEEDEV_PT_DIR . '/options' );
if ( !defined( 'KEEDEV_PT_VIEWS_PATH' ) ) define( 'KEEDEV_PT_VIEWS_PATH', KEEDEV_PT_DIR . '/views' );
if ( !defined( 'KEEDEV_PT_ASSETS_URL' ) ) define( 'KEEDEV_PT_ASSETS_URL', KEEDEV_PT_URL . '/assets' );

/* Three, two, one, go! */
require_once( 'class-keedev-pricing-tables.php' );
add_action( 'plugins_loaded', 'KeeDev_Pricing_Tables', 12 );

/* Load KeeDev Framework */
if ( !function_exists( 'keedev_register_plugin' ) && file_exists( plugin_dir_path( __FILE__ ) . 'keedev-fw/loader.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'keedev-fw/loader.php' );
}
keedev_register_plugin( plugin_dir_path( __FILE__ ) );

/* Premium info */
require_once( 'premium-info/init.php' );