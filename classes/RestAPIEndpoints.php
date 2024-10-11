<?php

/**
 * This file has functions related to kid role management through REST API endpoints
 */

namespace CoolKidsNetwork\Classes\RestAPIEndpoints;

if (!defined('ABSPATH')) {
    die();
}


final class RestAPIEndpoints
{
    
    function __construct()
    {        
        add_action('rest_api_init', [$this, 'register_rest_api']);
    }


    function register_rest_api()
    {
        register_rest_route(
            'ckn/v1',
            'manage-role',
            [
            'methods' => 'POST',
            'callback' => [
                $this,
                'handle_manage_role'
            ],
            // Only allow loggesd-in users with admin privileges
            'permission_callback' => function () { 
                return (is_user_logged_in() && current_user_can('manage_options'));
            }
            ]
        );
    }

    function handle_manage_role($data)
    {
        $headers = $data->get_headers();
        $params = $data->get_params();
        $nonce = $headers['x_wp_nonce'][0];
        $current_user = wp_get_current_user();

        LOGGER->add_entry("Received new user role change request by user ID $current_user->ID");

        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            LOGGER->add_entry('Error in nonce validation');
            return new \WP_REST_Response('Message not sent', 422);
        }

        if (empty($params['email'] || empty($params['role']))) {
            LOGGER->add_entry('Error: empty email or role');
            return new \WP_REST_Response('Email or Role cant be empty', 422);
        }

        $email = $params['email'];
        $user = get_user_by('email', $email);

        if (!$user) {
            LOGGER->add_entry('Error user not found');
            return new \WP_REST_Response('User not found', 404);
        }

        $role = $params['role'];
        $valid_roles = ['cool_kid', 'cooler_kid', 'coolest_kid'];

        if (!in_array($role, $valid_roles)) {
            LOGGER->add_entry('Error invalid role.');
            return new \WP_REST_Response('Invalid role', 422);
        }

        $user_id = $user->ID;


        if (!user_can($current_user, 'promote_users')) {
            LOGGER->add_entry("UNAUTHORIZED $current_user->ID");
            return new \WP_REST_Response('Unauthorized', 401);
        }

        if ($role === 'administrator' && !user_can($current_user, 'create_users')) {
            LOGGER->add_entry("UNAUTHORIZED $current_user->ID");
            return new \WP_REST_Response('Unauthorized', 401);
        }

        if (user_can($user_id, $role)) {
            LOGGER->add_entry("User already has the specified role");
            return new \WP_REST_Response('User already has the specified role', 200);
        }

        $user->set_role($role);

        LOGGER->add_entry("User role ID $user_id updated successfully to $role by user ID $current_user->ID");
        return new \WP_REST_Response('User role updated successfully', 200);
    }

}