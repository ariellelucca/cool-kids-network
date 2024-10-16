<?php
/**
 * This file handles the methods for user registration
 */

namespace CoolKidsNetwork\Classes\NewUserRegister;

if (!defined('ABSPATH')) {
    die();
}


class NewUserRegister extends \WP_REST_Controller {


    public function __construct() {
        $this->register_routes();
    }

    // Register REST route for user registration
    public function register_routes() {
        add_action('rest_api_init', function () {
            register_rest_route(
                'cool-kids-network/v1', 
                '/user-register', [
                'methods' => 'POST',
                'callback' => [
                    $this, 
                    'user_register'
                ],
            ]);
        });
     }
 
    public function user_register($data) {
        $headers = $data->get_headers();
        $params = $data->get_params();
        $nonce = $headers['x_wp_nonce'][0];

        LOGGER->add_entry('Received user registration request');

        // If don't verify nonce, throws error
        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            LOGGER->add_entry('Error in nonce validation');
            return new \WP_REST_Response('Nonce validation error', 422);
        }

        // If email is empty, throws error
        if (empty($params['email'])) {
            LOGGER->add_entry('Error: empty email');
            return new \WP_REST_Response('Email cant be empty', 422);
        }

        // Verify if valid email and if is not already in use
        $email = sanitize_email($params['email']);
        $user = get_user_by('email', $email);

        if ($user) {
            LOGGER->add_entry('Error: email already exists - ' . $email);
            return new \WP_REST_Response('Email is already in use', 422);
        }

        // Creates a brand new user
        // Perform AJAX request
        $response = wp_remote_get('https://randomuser.me/api/', array(
            'method' => 'GET',
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));

        if (is_wp_error($response)) {
            LOGGER->add_entry('Error performing ajax request to randomuser.me/api/');
            return new \WP_REST_Response('Error performing AJAX request', 500);
        }

        $response_body = wp_remote_retrieve_body($response);

        $response_data = json_decode($response_body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            LOGGER->add_entry('Error parsing JSON response');
            return new \WP_REST_Response('Error parsing JSON response', 500);
        }

        $first_name = $response_data['results'][0]['name']['first'];
        $last_name = $response_data['results'][0]['name']['last'];
        $country = $response_data['results'][0]['location']['country'];
        $role = 'cool_kid';
        $password = 'coolkid';

        $user_id = wp_create_user($email, $password, $email);

        if (is_wp_error($user_id)) {
            LOGGER->add_entry('Error creating user');
            return new \WP_REST_Response('Error creating user', 500);
        }

        // Set the user role as cool_kid
        $user = new \WP_User($user_id);
        $user->set_role($role);

        // Update user meta data
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);
        update_user_meta($user_id, 'country', $country);

        // Return success response
        LOGGER->add_entry("User ($user_id) created successfully");
        return new \WP_REST_Response('User created successfully', 200);

    }
}