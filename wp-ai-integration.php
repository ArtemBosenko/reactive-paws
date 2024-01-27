<?php
/**
 * Plugin Name: WP AI Integration: The AI Integration for the WordPress website.
 * Description: The Integration with AI for the WP project.
 * Version: 1.0
 * Requires at least: 6.4
 * Requires PHP: 8.2
 * Author: Artem Bosenko
 * Author URI: https://www.linkedin.com/in/artem-bosenko-php/
 * Text Domain: wp-ai-integration
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright (c) 2023-2024 Artem Bosenko
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
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

require_once( plugin_dir_path( __FILE__ ) . 'src/Plugin/Plugin.php' );
WpAiIntegration\Plugin\Plugin::get_instance();


