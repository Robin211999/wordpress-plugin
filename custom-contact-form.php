<?php
/*
Plugin Name: Custom Contact Form
Description: A simple custom contact form plugin.
Version: 1.0
Author: Your Name
*/

// Code for the form goes here
// Inside the custom-contact-form.php file

function custom_contact_form() {
    ob_start(); ?>

    <form id="custom-contact-form" action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="message">Message:</label>
        <textarea name="message" required></textarea>

        <input type="submit" value="Submit">
    </form>

    <?php
    $form = ob_get_clean();
    return $form;
}

add_shortcode('custom_contact_form', 'custom_contact_form');

function handle_contact_form() {
    if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        // Send email (customize as needed)
        $to = 'your@email.com';
        $subject = 'New Contact Form Submission';
        $headers = "From: $name <$email>";

        wp_mail($to, $subject, $message, $headers);

        // Send a response back to the client
        echo json_encode(['success' => true]);
    } else {
        // Handle validation errors
        echo json_encode(['success' => false, 'error' => 'Invalid form data']);
    }

    // Always exit to prevent further processing
    exit();
}

add_action('wp_ajax_handle_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_handle_contact_form', 'handle_contact_form');
