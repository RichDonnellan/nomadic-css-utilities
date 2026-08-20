<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// Register classes with CSS Class Manager plugin
// https://wordpress.org/plugins/css-class-manager/
//
// Uses css_class_manager_filtered_class_names (the documented PHP filter) to
// register ClassPreset objects directly. This bypasses any user-level toggle
// that suppresses theme.json-derived classes, and works regardless of whether
// the theme generates global styles.
//
// Priority controls dropdown order, higher number appears first.
// Base utilities: 30 → tablet: 20 → desktop: 10 (mobile-first authoring order).
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

    $css = $wp_filesystem->get_contents( plugin_dir_path( dirname( __FILE__ ) ) . 'utilities.css' );

    if ( ! $css ) {
        return $class_names;
    }

    // Strip block comments to avoid matching file extensions like .css / .json.
    $css = preg_replace( '/\/\*[\s\S]*?\*\//', '', $css );

    // Match base n- utilities (.n-flex) and responsive variants (.tablet\:n-flex).
    // The \\\\: in the pattern matches a literal backslash-colon in CSS source.
    // After capturing, unescape so CSS Class Manager receives "tablet:n-flex".
    preg_match_all( '/\.((?:[a-z]+\\\\:)?n-[a-zA-Z0-9_-]+)/', $css, $matches );
    $names = array_unique( $matches[1] );
    $names = array_map( fn( $n ) => str_replace( '\\:', ':', $n ), $names );

    foreach ( $names as $name ) {
        $priority     = str_starts_with( $name, 'desktop:' ) ? 10 : ( str_starts_with( $name, 'tablet:' ) ? 20 : 30 );
        $class_names[] = new \CSSClassManager\ClassPreset( $name, '', null, $priority );
    }

    return $class_names;
} );
