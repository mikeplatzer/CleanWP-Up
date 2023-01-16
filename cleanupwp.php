<?php
/*
Plugin Name: CleanUp WP
Description: Deletes a specific page and post, sets the language to German, the permalink structure to post name, delete the plugins "Hello Dolly" and "Akismet" and sets the time and date format to a German format.
*/

function cleanUp_wp_activate() {
    // Delete page with ID 2
    wp_delete_post( 2, true );

    // Delete post with ID 1
    wp_delete_post( 1, true );

    // Set language to German
    switch_to_locale( 'de_DE' );

    update_option( 'timezone_string', 'Europe/Berlin' );

    // Set permalink structure to post name
    update_option( 'permalink_structure', '/%postname%/' );

    // Delete plugins "Hello Dolly" and "Akismet"
    delete_plugins(array('/hello.php'));
    delete_plugins(array('/akismet/akismet.php'));

    // Set time and date format to German format
    update_option( 'date_format', 'd.m.Y' );
    update_option( 'time_format', 'H:i' );
}

register_activation_hook( __FILE__, 'cleanUp_wp_activate' );