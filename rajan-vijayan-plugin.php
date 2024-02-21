<?php
/*
Plugin Name: Rajan Vijayan Plugin
Description: A plugin to retrieve data from a remote API
Author: Rajan Vijayan
Author URI: https://rajanvijayan.com
Text Domain: rajan-vijayan
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Load Composer autoloader
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Load translation
load_plugin_textdomain( 'rajan-vijayan', false, dirname( plugin_basename( __FILE__ ) ) . '/language' );

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'src/Ajax/AjaxHandler.php';
require_once plugin_dir_path( __FILE__ ) . 'src/Blocks/GutenbergBlock.php';
require_once plugin_dir_path( __FILE__ ) . 'src/CLI/RefreshCommand.php';
require_once plugin_dir_path( __FILE__ ) . 'src/Admin/AdminPage.php';
