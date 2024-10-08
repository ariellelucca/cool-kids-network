<?php
/*
 * This file defines custom routes
 */

namespace CoolKidsNetwork\Helpers\Routes;

if (!defined('ABSPATH')) {
    die();
}

add_action('init', __NAMESPACE__ . 'custom_rewrites');
add_action('template_redirect', __NAMESPACE__ . 'custom_template_redirect');

function custom_rewrites()
{
    add_rewrite_rule('^sign-in/?$', 'index.php?custom_sign_in=1', 'top');
    add_rewrite_rule('^sign-up/?$', 'index.php?custom_sign_up=1', 'top');
    add_filter('query_vars', __NAMESPACE__ . 'add_query_vars');
}

function custom_template_redirect()
{
    if (get_query_var('custom_sign_in')) {
        include get_template_directory() . '/sign-in.php';
        exit;
    }
    if (get_query_var('custom_sign_up')) {
        include get_template_directory() . '/sign-up.php';
        exit;
    }
}

function add_query_vars($vars)
{
    $vars[] = 'custom_sign_in';
    $vars[] = 'custom_sign_up';
    return $vars;
}