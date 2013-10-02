<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Sveonix Web Development - YouTube Playlist
 * @author    Curtis Schwoebel <curtis.schwoebel@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Curtis Schwoebel
 *
 * @wordpress-plugin
 * Plugin Name: YouTube Playlists
 * Plugin URI:  
 * Description: This plugin will give you the ability to add a listing of YouTube Playlist videos associated with the YouTube account name that you want to display
 * Version:     1.0.0
 * Author:      Curtis Schwoebel
 * Author URI:  TODO
 * Text Domain: SWD_youtube-playlists-sv
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

ini_set ( 'include_path', dirname ( __FILE__ ) . '/assets/ZendGdata-1.12.3/library' );
require_once( plugin_dir_path( __FILE__ ) . 'swd-youtube_playlists.class.php' );
include(plugin_dir_path( __FILE__ ) . '/assets/youtube_playlist.class.php');

// Register hooks that are fired when the plugin is activated or deactivated.
// When the plugin is deleted, the uninstall.php file is loaded.
register_activation_hook( __FILE__, array( 'SWD_YouTube_Playlists', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SWD_YouTube_Playlists', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'SWD_YouTube_Playlists', 'get_instance' ) );
