<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// Admin notice: prompt to install CSS Class Manager if not active
// ─────────────────────────────────────────────────────────────────────────────
add_action( 'admin_notices', function () {
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
} );
