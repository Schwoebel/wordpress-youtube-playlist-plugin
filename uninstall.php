<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Sveonix Web Development - YouTube Playlist
 * @author    Curtis Schwoebel <curtis.schwoebel@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Curtis Schwoebel
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here