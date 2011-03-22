<?php
/**
 * Plugin Name: Dynamic Content Widget
 * Plugin URI: http://dikhoffsoftware.com/dynamic-content-widget
 * Description: A widget that can render a post or a page, using a template in your theme.
 * Version: 0.3
 * Author: Dikhoff Software
 * Author URI: http://dikhoffsoftware.com
 *
 * Copyright (C) 2011  Dikhoff Software
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 */

require_once("fv-dynamic-content-widget.php");

/**
 * Add the action.
 * @since 0.1
 */
add_action( 'widgets_init', 'fv_load_widgets' );

/**
 * Register widgets.
 * @since 0.1
 */
function fv_load_widgets() {
	register_widget( 'fv_Dynamic_Content_Widget' );
}

?>