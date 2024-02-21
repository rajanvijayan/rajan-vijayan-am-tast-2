jQuery(document).ready(function($) {
    // When the refresh button is clicked
    $('#refresh-data').on('click', function() {
        // Display a confirmation message
        if (!confirm('Are you sure you want to refresh the data?')) {
            return;
        }

        // Perform AJAX request to refresh data
        $.ajax({
            url: myplugin_ajax_object.ajax_url, // AJAX endpoint URL
            type: 'POST', // HTTP method
            data: {
                action: 'my_plugin_fetch_data', // AJAX action
                nonce: myplugin_ajax_object.security // Nonce for security
            },
            success: function(response) {                
                if (response.success) {
                    // Data refreshed successfully, reload the page
                    location.reload();
                } else {
                    // Error handling
                    console.error(response.data.message);
                    alert('Error refreshing data. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                // Error handling
                console.error(xhr.responseText);
                alert('Error refreshing data. Please try again.');
            }
        });
    });
});
