<?php
/*
 * This file defines custom user roles
 */

if (!defined('ABSPATH')) {
    die();
}

class CustomKidRoles {
    function __construct() {
        add_action('init', [$this, 'remove_basic_roles']);        
        add_action('init', [$this, 'create_roles']);
    }

    function remove_basic_roles() 
    {
        global $wp_roles;

        $wp_roles->remove_role('subscriber');
        $wp_roles->remove_role('contributor');
        $wp_roles->remove_role('author');
        $wp_roles->remove_role('editor');
    }

    function create_roles() 
    {

        add_role('cool_kid', 'Cool Kid', [
            'read' => false,
            'create_posts' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'manage_categories' => false,
        ]);

        add_role('cooler_kid', 'Cooler Kid', [
            'read' => false,
            'create_posts' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'manage_categories' => false,
        ]);

        add_role('coolest_kid', 'Coolest Kid', [
            'read' => false,
            'create_posts' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'manage_categories' => false,
        ]);

    }

}