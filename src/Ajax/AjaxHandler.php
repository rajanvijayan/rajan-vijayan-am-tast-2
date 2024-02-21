<?php
namespace RajanVijayan\Ajax;

/**
 * Handles AJAX requests for fetching data from an external API and caching it.
 */
class AjaxHandler {
    
    /**
     * Initializes the AJAX handler by registering hooks.
     */
    public static function init() {
        // Register AJAX action for logged-in users
        add_action( 'wp_ajax_my_plugin_fetch_data', array( __CLASS__, 'fetch_data' ) );
        
        // Register AJAX action for non-logged-in users
        add_action( 'wp_ajax_nopriv_my_plugin_fetch_data', array( __CLASS__, 'fetch_data' ) );
    }

    /**
     * Callback function to fetch data from the external API.
     */
    public static function fetch_data() {
        // Check nonce for security
        check_ajax_referer( 'my_plugin_nonce', 'nonce' );

        // Check if data is already cached
        $cached_data = get_transient( 'my_plugin_cached_data' );

        if ( false === $cached_data ) {
            // Data not cached, fetch from external API
            $api_response = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

            if ( is_wp_error( $api_response ) ) {
                // Error fetching data from API
                wp_send_json_error( array( 'message' => 'Error fetching data from API' ) );
            }

            $body = wp_remote_retrieve_body( $api_response );
            $data = json_decode($body, true);

            // Cache the data for one hour
            set_transient( 'my_plugin_cached_data', $data, HOUR_IN_SECONDS );

            // Send JSON success response with fetched data
            wp_send_json_success( $data );
        } else {
            // Data already cached, return it
            wp_send_json_success( $cached_data );
        }

        // Always exit to prevent further execution
        wp_die();
    }
}

// Initialize the AJAX handler
AjaxHandler::init();
