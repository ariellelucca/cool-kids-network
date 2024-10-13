<?php

/**
 * This class defines custom user roles
 */

namespace CoolKidsNetwork\Classes\CustomRoles;

use CoolKidsNetwork\Classes\Logger\Logger;

if (!defined('ABSPATH')) {
    die();
}

final class CustomRoles
{
        
    function __construct() {
        add_action('after_switch_theme', [$this, 'remove_basic_roles']);        
        add_action('after_switch_theme', [$this, 'create_roles']);
    }

    function remove_basic_roles()
    {
        global $wp_roles;

        $wp_roles->remove_role('subscriber');
        $wp_roles->remove_role('contributor');
        $wp_roles->remove_role('author');
        $wp_roles->remove_role('editor');

        LOGGER->add_entry('Removed basic roles.');

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
            'list_users' => true, // Add capability to list users
        ]);

        add_role('coolest_kid', 'Coolest Kid', [
            'read' => false,
            'create_posts' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'manage_categories' => false,
            'list_users' => true, // Add capability to list users
        ]);
        LOGGER->add_entry('Created custom cool_kid, coolest_kid and cooler_kid roles.');
    }
}