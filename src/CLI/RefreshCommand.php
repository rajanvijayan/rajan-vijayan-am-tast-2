<?php
namespace RajanVijayan\CLI;

/**
 * Registers WP CLI command for refreshing cached data.
 */
class RefreshCommand {
    
    /**
     * Initializes the WP CLI command.
     */
    public static function init() {
        // Register WP CLI command if WP CLI is active
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            \WP_CLI::add_command( 'my-plugin refresh-data', array( __CLASS__, 'refresh_data' ) );
        }
    }

    /**
     * Callback function to refresh cached data.
     *
     * ## EXAMPLES
     *     wp my-plugin refresh-data
     *
     * @param array $args       Command arguments.
     * @param array $assoc_args Command associative arguments.
     */
    public static function refresh_data( $args, $assoc_args ) {
        // Clear the transient to force data refresh on next AJAX call
        delete_transient( 'my_plugin_cached_data' );

        // Display success message
        \WP_CLI::success( 'Data cache refreshed successfully.' );
    }
}

// Initialize the CLI command
RefreshCommand::init();
