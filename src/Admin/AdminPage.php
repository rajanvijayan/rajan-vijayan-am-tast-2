<?php
namespace RajanVijayan\Admin;

/**
 * Class AdminPage
 * Handles the creation and rendering of the MiUsage admin page.
 */
class AdminPage {
    /**
     * Initializes the admin page hooks.
     */
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'add_menu_page' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
    }

    /**
     * Adds the MiUsage admin page to the WordPress dashboard menu.
     */
    public static function add_menu_page() {
        add_menu_page(
            __( 'MiUsage Admin Page', 'rajan-vijayan' ),
            __( 'MiUsage', 'rajan-vijayan' ),
            'manage_options',
            'my-plugin-admin-page',
            array( __CLASS__, 'render_admin_page' )
        );
    }

    /**
     * Enqueues styles and scripts for the MiUsage admin page.
     *
     * @param string $hook The current admin page hook.
     */
    public static function enqueue_scripts( $hook ) {
        if ( 'toplevel_page_my-plugin-admin-page' !== $hook ) {
            return;
        }

        // Enqueue styles
        wp_enqueue_style(
            'my-plugin-admin-styles',
            plugin_dir_url( __FILE__ ) . '../../assets/css/admin-styles.css',
            array(),
            filemtime( plugin_dir_path( __FILE__ ) . '../../assets/css/admin-styles.css' )
        );

        // Enqueue scripts
        wp_enqueue_script(
            'my-plugin-admin-scripts',
            plugin_dir_url( __FILE__ ) . '../../assets/js/admin-scripts.js',
            array( 'jquery' ),
            filemtime( plugin_dir_path( __FILE__ ) . '../../assets/js/admin-scripts.js' ),
            true
        );

        // Pass the AJAX URL and security nonce to JavaScript
        wp_localize_script(
            'my-plugin-admin-scripts',
            'myplugin_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'security' => wp_create_nonce('my_plugin_nonce') )
        );
    }

    /**
     * Renders the MiUsage admin page.
     */
    public static function render_admin_page() {
        // Fetch and display data from the external API
        $cached_data = get_transient( 'my_plugin_cached_data' );
    
        if ( false !== $cached_data ) {    
            echo '<div class="wrap">';
            echo '<h1>' . __( 'MiUsage Admin Page', 'rajan-vijayan' ) . '</h1>';
            echo '<p>' . __( 'Data fetched from external API:', 'rajan-vijayan' ) . '</p>';
            
            // Check if data contains required fields
            if ( isset( $cached_data['data']['headers'], $cached_data['data']['rows'] ) ) {
                echo '<table class="wp-list-table widefat striped">';
                echo '<thead><tr>';
    
                // Print table headers
                foreach ( $cached_data['data']['headers'] as $header ) {
                    echo '<th>' . esc_html( $header ) . '</th>';
                }
    
                echo '</tr></thead>';
                echo '<tbody>';
    
                // Print table rows
                foreach ( $cached_data['data']['rows'] as $row ) {
                    echo '<tr>';
                    foreach ( $row as $cell ) {
                        if ( is_numeric( $cell ) && strlen($cell) == 10 ) { // Check if the cell is a timestamp
                            $formatted_date = date( 'd M Y', $cell ); // Format the timestamp
                            echo '<td>' . esc_html( $formatted_date ) . '</td>';
                        } else {
                            echo '<td>' . esc_html( $cell ) . '</td>';
                        }
                    }
                    echo '</tr>';
                }                            
    
                echo '</tbody></table>';
            } else {
                echo '<p>' . __( 'No data available.', 'rajan-vijayan' ) . '</p>';
            }
            
            echo '<p class="submit">';
            echo '<button id="refresh-data">' . __( 'Refresh Data', 'rajan-vijayan' ) . '</button>';
            echo '</p>';
            echo '</div>';
        } else {
            echo '<div class="wrap">';
            echo '<h1>' . __( 'MiUsage Admin Page', 'rajan-vijayan' ) . '</h1>';
            echo '<p>' . __( 'No data available. Please refresh.', 'rajan-vijayan' ) . '</p>';
            echo '<p class="submit">';
            echo '<button id="refresh-data">' . __( 'Refresh Data', 'rajan-vijayan' ) . '</button>';
            echo '</p>';
            echo '</div>';
        }
    }
}

// Initialize the admin page
AdminPage::init();
