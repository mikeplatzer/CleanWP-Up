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

    // Generate Default Pages
     // Define the pages
     $pages = array(
        'Home' => array(
            'content' => 'This is the home page.'
        ),
        'Über uns' => array(
            'content' => 'This is the "Über uns" page.'
        ),
        'Kontakt' => array(
            'content' => 'This is the "Kontakt" page.'
        ),
        'Impressum' => array(
            'content' => 'This is the "Impressum" page.'
        )
    );

    // Create the pages
    foreach( $pages as $title => $page ) {
        $new_page = array(
            'post_title' => $title,
            'post_content' => $page['content'],
            'post_status' => 'publish',
            'post_type' => 'page'
        );

        // Check if the page has a template
        if( isset( $page['template'] ) ) {
            $new_page['page_template'] = $page['template'];
        }

        // Insert the page into the database
        wp_insert_post( $new_page );
    }

        // Get the privacy policy page
        $privacy_policy = get_page_by_title( 'Privacy Policy', OBJECT, 'page' );

        // Check if the page exists
        if( $privacy_policy ) {
            // Update the post
            wp_update_post( array(
                'ID' => $privacy_policy->ID,
                'post_title' => 'Datenschutzerklärung',
                'post_name' => 'datenschutz',
                'post_status' => 'publish'
            ) );
        }

        //Set Home as default page
        $homepage = get_page_by_title( 'Home' );
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
}

register_activation_hook( __FILE__, 'cleanUp_wp_activate' );