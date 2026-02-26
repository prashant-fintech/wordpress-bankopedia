<?php
/*
 * Plugin Name: TextBuilder
 * Plugin URI: https://textbuilder.ai
 * Description: With the TextBuilder.ai WordPress Plugin, you can quickly create content and post it directly to your blog without any manual effort.
 * Version: 1.2.0
 * Author: TextBuilder.ai
 * Author URI: https://textbuilder.ai/about/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP: 7.4
 * Requires at least: 6.0
 * Text Domain: textbuilder
 * Domain Path: /languages/
 */

define('TEXTBUILDER_VERSION', '1.2.0');
define('TEXTBUILDER_ROOT', __FILE__);
define('TEXTBUILDER_ROOT_DIRNAME', basename(dirname(TEXTBUILDER_ROOT)));
define('TEXTBUILDER_PLUGIN_URL', rtrim(plugin_dir_url(__FILE__), '/') . '/');
define('TEXTBUILDER_API_URL', 'https://api.textbuilder.ai/');

function textBuilder()
{
    require_once 'vendor/autoload.php';
    $plugin = \TextBuilder\TextBuilder::getInstance();
    $plugin->boot();
}

textBuilder();
