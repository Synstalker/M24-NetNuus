<?php
/*
	Plugin Name: 24.com Koos Bar
	Description: 24.com Koos bar widget
	Version: 1.0.0
	Author: jared.rethman@24.com
	Author URI: http://ww.jaredrethman.com/
	License: GPLv2 or later
	Text Domain: tf_kb


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('ABSPATH'))
    die('-1');

define('TF_KB_URL', plugin_dir_url(__FILE__));
define('TF_KB_PATH', trailingslashit(plugin_dir_path(__FILE__)));

require_once(TF_KB_PATH . 'inc/koos-bar.php');