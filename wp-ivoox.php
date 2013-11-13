<?php
/*
Plugin Name: ivoox Shortcode & Widget
Description: This pluging allows you to embed an ivoox audio in a widget or post/page
Plugin URI: http://temperatio.com/wp-ivoox
Author: César Gómez
Author URI: http://www.cyberdespacio.org
Version: 1.0
License: GPL2
Text Domain: wp-ivoox
Domain Path: /lang
*/

/*

    Copyright (C) 2013  César Gómez  cesar@temperatio.com

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

function wp_ivoox_shortcode( $atts ) {
    $atts = extract( shortcode_atts( array( 'default'=>'values' ),$atts ) );

    // do shortcode actions here
}
add_shortcode( 'ivoox','wp_ivoox_shortcode' );