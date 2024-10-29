<?php
/**
 * Appful
 *
 * @package           Appful
 * @author            Appful GmbH
 * @copyright         2023 Appful GmbH
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Appful App
 * Plugin URI:        https://appful.io
 * Description:       Appful® is the number 1 plugin for turning your WordPress Content into a native, beautiful app on iOS & Android in under 5 minutes.
 * Version:           3.1.25
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Appful GmbH
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

use AppfulPlugin\Main\AppfulPlugin;

defined( "ABSPATH" ) or die( "Plugin can only be used with WordPress!" );

require_once( plugin_dir_path( __FILE__ ) . "./lib/vendor/autoload.php" );

$appfulPlugin = new AppfulPlugin();
$appfulPlugin->init();
