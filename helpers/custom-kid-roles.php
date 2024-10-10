<?php
/*
 * This file defines custom user roles
 */

namespace CoolKidsNetwork\Helpers\Roles;

if (!defined('ABSPATH')) {
    die();
}

function kid_roles_hooks() {
    add_action('init', __NAMESPACE__ . 'remove_basic_roles');
    add_action('init', __NAMESPACE__ . 'create_roles');
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
        'list_users' => true,
    ]);

    add_role('coolest_kid', 'Coolest Kid', [
        'read' => false,
        'create_posts' => false,
        'edit_posts' => false,
        'edit_others_posts' => false,
        'publish_posts' => false,
        'manage_categories' => false,
        'list_users' => true,
    ]);

}
