<?php
/**
 * Template part that lists all cool kids
 */

$current_user = wp_get_current_user();

$kid = new ClassKid;
$role = $kid->getRole($current_user);
if (!(in_array('coolest_kid', $role) || in_array('cooler_kid', $role))) {
    die();
}

$args = array(
    'role'    => ['cool_kid', 'coolest_kid', 'cooler_kid'],
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users( $args );

echo '<pre>';

print_r($users);
echo '</pre>';