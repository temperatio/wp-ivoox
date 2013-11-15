<?php
/*
Plugin Name: ivoox Shortcode
Description: This pluging allows you to embed an ivoox audio in a post
Plugin URI: https://github.com/temperatio/wp-ivoox
Author: César Gómez <cesar@temperatio.com>
Author URI: http://www.cyberdespacio.org
Version: 1.0
License: GPL2
Text Domain: wp-ivoox
Domain Path: /lang
*/

/*

    Copyright (C) 2013  César Gómez cesar@temperatio.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) )
    die( "Can't load this file directly" );
/**
 * Plugin class
 */
class WPivoox {

    /**
     * Call required hooks
     */
    function __construct() {
        load_plugin_textdomain( 'wp-ivoox', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
        add_action('admin_init', array($this, 'wp_ivoox_admin_init'));
        add_shortcode('ivoox', array($this,'wp_ivoox_shortcode'));
    }

    /**
     * Initialice editor button in admin area
     */
    function wp_ivoox_admin_init() {
        if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
            add_filter('mce_buttons', array($this, 'wp_ivoox_register_button'));
            add_filter('mce_external_plugins', array($this, 'wp_ivoox_add_plugin'));
        }
    }

    /**
     * Register new button
     * @param  array $buttons Editor buttons array
     * @return array          Editor buttons array with new button
     */
    function wp_ivoox_register_button($buttons) {
       array_push($buttons, "|", "ivoox");
       return $buttons;
    }

    /**
     * Add the editor plugin
     * @param  array $plugins Editor plugins array
     * @return array          Editor plugins array with the new plugin
     */
    function wp_ivoox_add_plugin($plugins) {
       $plugins['ivoox'] = plugins_url( 'editor-plugin/customcodes.js', __FILE__ );
       return $plugins;
    }

    /**
     * Get an ivoox url in $content and return the embed code
     * @param  Array  $atts    Shortcode attributes
     * @param  String $content ivoox URL
     * @return String          The embed code
     */
    function wp_ivoox_shortcode( $atts, $content  = null ) {
        extract(shortcode_atts(array(
            'type'=>'normal'
        ), $atts ));

        if(is_null($content)){
            return '<p style="font-style: italic;">' . __("You must provide an ivoox.com URL", "wp-ivoox") . '<p>';
        }
        if (preg_match('/^http.+?_(.{2})_(.+?)_1\.html$/i', $content, $result)) {
            $ivoox_id = $result[2];
            switch ($type) {
                case 'mini':
                    $code = '<iframe width="238" height="48" frameborder="0" allowfullscreen="" scrolling="no" src="http://www.ivoox.com/player_ek_' . $ivoox_id . '_1.html"></iframe>';
                    break;
                case 'flash':
                    $code = '<object id="player' . $ivoox_id . '" width="240" height="133" type="application/x-shockwave-flash" data="http://www.ivoox.com/playerivoox_ee_' . $ivoox_id . '_1.html"><param name="movie" value="http://www.ivoox.com/playerivoox_ee_' . $ivoox_id . '_1.html"></param><param name="AllowScriptAccess" value="always"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><embed src="http://www.ivoox.com/playerivoox_ee_' . $ivoox_id . '_1.html" type="application/x-shockwave-flash" allowfullscreen="true" wmode="transparent" allowscriptaccess="always" width="240" height="133"></embed></object>';
                    break;
                default:
                    $code = '<iframe width="100%" height="120" frameborder="0" allowfullscreen="" scrolling="no" src="http://www.ivoox.com/player_ej_' . $ivoox_id . '_1.html"></iframe>';
                    break;
            }
            return $code;
        } else {
            return '<p style="font-style: italic;">' . __("Please, check the ivoox.com URL is correct", "wp-ivoox") . '<p>';
        }
    }
}

$wp_ivoox = new WPivoox();



