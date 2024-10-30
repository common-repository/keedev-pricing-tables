<?php
/**
 * Framework: keedev framework
 * Version: 1.0.0
 * Author: keedev
 * Text Domain: keedev
 * Domain Path: /languages/
 *
 * @author  keedev
 * @version 1.0.0
 */
/**
 * This file belongs to the KeeDev framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

!defined( 'KEEDEV' ) && define( 'KEEDEV', true );
!defined( 'KEEDEV_VERSION' ) && define( 'KEEDEV_VERSION', '1.0.0' );
!defined( 'KEEDEV_PATH' ) && define( 'KEEDEV_PATH', dirname( __FILE__ ) );
!defined( 'KEEDEV_URL' ) && define( 'KEEDEV_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
!defined( 'KEEDEV_TEMPLATE_PATH' ) && define( 'KEEDEV_TEMPLATE_PATH', KEEDEV_PATH . '/templates' );
!defined( 'KEEDEV_ASSETS_PATH' ) && define( 'KEEDEV_ASSETS_PATH', KEEDEV_PATH . '/assets' );
!defined( 'KEEDEV_ASSETS_URL' ) && define( 'KEEDEV_ASSETS_URL', KEEDEV_URL . '/assets' );

// include the Keedev Framework class
require_once( 'includes/class-keedev.php' );

// include the other files
require_once( 'functions-keedev.php' );
require_once( 'includes/class-keedev-assets.php' );
require_once( 'includes/class-keedev-icons.php' );
require_once( 'includes/class-keedev-settings.php' );


// Load KeeDev Framework!
KeeDev::instance();