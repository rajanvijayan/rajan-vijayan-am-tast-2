<?php
namespace RajanVijayan\Blocks;

/**
 * Class GutenbergBlock
 *
 * Registers and initializes the Gutenberg block.
 */
class GutenbergBlock {
    /**
     * Initializes the Gutenberg block by registering block script and type.
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_block' ) );
    }

    /**
     * Registers the Gutenberg block script and type.
     */
    public static function register_block() {
        // Register the block script
        wp_register_script(
            'rajan-vijayan-gutenberg-block',
            plugin_dir_url( __FILE__ ) . '../../build/gutenberg-block.js',
            array('wp-block-editor', 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n'),
            filemtime( plugin_dir_path( __FILE__ ) . '../../build/gutenberg-block.js' ),
            true
        );

        // Register the block type
        register_block_type( 'rajan-vijayan/my-block', array(
            'editor_script' => 'rajan-vijayan-gutenberg-block',
        ) );

        // Localize script for AJAX functionality
        wp_localize_script(
            'rajan-vijayan-gutenberg-block',
            'myplugin_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'security' => wp_create_nonce('my_plugin_nonce') )
        );
    }
}

// Initialize the Gutenberg block
GutenbergBlock::init();

