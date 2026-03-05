<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// Enqueue on the frontend
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'nomadic-css-utilities',
        plugin_dir_url( dirname( __FILE__ ) ) . 'utilities.css',
        array(),
        filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'utilities.css' )
    );
} );

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
        plugin_dir_url( dirname( __FILE__ ) ) . 'utilities.css',
        array(),
        filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'utilities.css' )
    );
} );

add_action( 'after_setup_theme', function () {
    add_editor_style( plugin_dir_url( dirname( __FILE__ ) ) . 'utilities.css' );
}, 20 );
