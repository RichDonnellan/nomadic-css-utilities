<?php
/**
 * Plugin Name: Nomadic CSS Utilities Framework
 * Description: Responsive layout, spacing, and typography utilities for the WordPress block editor. Use with the CSS Class Manager plugin for class picker integration.
 * Author:      Nomad Solutions
 * Author URI:  mailto:support@nomadsolutions.dev
 * Version:     1.0.0
 * Text Domain: nomadic-css-utilities
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/includes/enqueue.php';
require_once __DIR__ . '/includes/class-manager.php';
require_once __DIR__ . '/includes/admin-notice.php';
