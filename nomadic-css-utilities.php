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

// ─────────────────────────────────────────────────────────────────────────────
// Enqueue on the frontend
// ─────────────────────────────────────────────────────────────────────────────
function nomadic_utilities_enqueue_frontend() {
    wp_enqueue_style(
        'nomadic-css-utilities',
        plugin_dir_url( __FILE__ ) . 'utilities.css',
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'utilities.css' )
    );
}
add_action( 'wp_enqueue_scripts', 'nomadic_utilities_enqueue_frontend' );

// ─────────────────────────────────────────────────────────────────────────────
// Load utilities into the block editor
//
// Two hooks are required because they serve different purposes:
//
//   enqueue_block_editor_assets — registers the stylesheet in the outer admin
//   shell. CSS Class Manager scans this context to build its class index.
//
//   add_editor_style (after_setup_theme) — loads the stylesheet into the editor
//   canvas iframe where visual block editing happens. Without this, the
//   utilities are invisible in the actual editing surface.
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'enqueue_block_editor_assets', function () {
    wp_enqueue_style(
        'nomadic-css-utilities-editor',
        plugin_dir_url( __FILE__ ) . 'utilities.css',
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'utilities.css' )
    );
} );

add_action( 'after_setup_theme', function () {
    add_editor_style( plugin_dir_url( __FILE__ ) . 'utilities.css' );
}, 20 );

// ─────────────────────────────────────────────────────────────────────────────
// Register classes with CSS Class Manager plugin
// https://wordpress.org/plugins/css-class-manager/
//
// Uses css_class_manager_filtered_class_names (the documented PHP filter) to
// register ClassPreset objects directly. This bypasses any user-level toggle
// that suppresses theme.json-derived classes, and works regardless of whether
// the theme generates global styles.
// ─────────────────────────────────────────────────────────────────────────────
add_filter( 'css_class_manager_filtered_class_names', function ( array $class_names ): array {
    if ( ! class_exists( '\CSSClassManager\ClassPreset' ) ) {
        return $class_names;
    }

    global $wp_filesystem;

    if ( ! function_exists( 'WP_Filesystem' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    WP_Filesystem();

    $css = $wp_filesystem->get_contents( __DIR__ . '/utilities.css' );

    if ( ! $css ) {
        return $class_names;
    }

    // Strip block comments to avoid matching file extensions like .css / .json.
    $css = preg_replace( '/\/\*[\s\S]*?\*\//', '', $css );

    // Match base n- utilities (.n-flex) and responsive variants (.mobile\:n-flex).
    // The \\\\: in the pattern matches a literal backslash-colon in CSS source.
    // After capturing, unescape so CSS Class Manager receives "mobile:n-flex".
    preg_match_all( '/\.((?:[a-z]+\\\\:)?n-[a-zA-Z0-9_-]+)/', $css, $matches );
    $names = array_unique( $matches[1] );
    $names = array_map( fn( $n ) => str_replace( '\\:', ':', $n ), $names );
    sort( $names );

    foreach ( $names as $name ) {
        $class_names[] = new \CSSClassManager\ClassPreset( $name );
    }

    return $class_names;
} );

// ─────────────────────────────────────────────────────────────────────────────
// Admin notice: prompt to install CSS Class Manager if not active
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'admin_notices', 'nomadic_utilities_class_manager_notice' );

function nomadic_utilities_class_manager_notice() {
    if ( ! current_user_can( 'install_plugins' ) ) {
        return;
    }

    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if ( is_plugin_active( 'css-class-manager/css-class-manager.php' ) ) {
        return;
    }

    $install_url = add_query_arg(
        array(
            's'    => 'CSS Class Manager – An advanced autocomplete additional css class control for your blocks',
            'tab'  => 'search',
            'type' => 'term',
        ),
        admin_url( 'plugin-install.php' )
    );
    ?>
    <div class="notice notice-warning is-dismissible">
        <p style="font-size: 15px;">
            <strong>Nomadic CSS Utilities:</strong> Install the <strong>"CSS Class Manager"</strong> plugin to enable the class picker in the block editor —
            <a href="<?php echo esc_url( $install_url ); ?>">click here to install it now</a>.
        </p>
    </div>
    <?php
}
